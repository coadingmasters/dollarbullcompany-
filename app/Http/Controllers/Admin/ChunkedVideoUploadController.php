<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChunkedVideoUploadController extends Controller
{
    private const CHUNK_DIR   = 'video-chunks';
    private const ALLOWED_EXT = ['mp4', 'webm', 'mov', 'avi', 'mkv'];
    private const DISK        = 'local'; // always local — chunks are temp files

    /**
     * Step 1 — reserve an upload session, return a UUID the client reuses.
     */
    public function init(Request $request, Course $course)
    {
        $request->validate(['total_chunks' => 'required|integer|min:1|max:20000']);

        $uploadId = Str::uuid()->toString();
        Storage::disk(self::DISK)->makeDirectory(self::CHUNK_DIR . '/' . $uploadId);

        return response()->json(['upload_id' => $uploadId]);
    }

    /**
     * Step 2 (repeated) — store one chunk on disk.
     */
    public function chunk(Request $request, Course $course)
    {
        $uploadId = $request->input('upload_id', '');
        if (! $this->validUuid($uploadId)) {
            return response()->json(['error' => 'Invalid upload ID.'], 400);
        }

        $dir = self::CHUNK_DIR . '/' . $uploadId;

        // Session must exist — created by init()
        if (! Storage::disk(self::DISK)->exists($dir)) {
            return response()->json([
                'error' => 'Upload session not found or expired. Please start the upload again.',
            ], 404);
        }

        if (! $request->hasFile('chunk') || ! $request->file('chunk')->isValid()) {
            return response()->json(['error' => 'Chunk missing or corrupt. The server will retry this chunk.'], 400);
        }

        $index     = (int) $request->input('chunk_index', 0);
        $chunkName = 'chunk_' . str_pad($index, 6, '0', STR_PAD_LEFT);

        $request->file('chunk')->storeAs($dir, $chunkName, self::DISK);

        return response()->json(['ok' => true, 'index' => $index]);
    }

    /**
     * Status — return which chunk indices have been received (for resume support).
     */
    public function status(Request $request, Course $course)
    {
        $uploadId = $request->input('upload_id', '');
        if (! $this->validUuid($uploadId)) {
            return response()->json(['error' => 'Invalid upload ID.'], 400);
        }

        $dir = self::CHUNK_DIR . '/' . $uploadId;

        if (! Storage::disk(self::DISK)->exists($dir)) {
            return response()->json(['received' => []]);
        }

        $received = [];
        foreach (Storage::disk(self::DISK)->files($dir) as $file) {
            $name = basename($file);
            if (preg_match('/^chunk_(\d+)$/', $name, $m)) {
                $received[] = (int) $m[1];
            }
        }

        return response()->json(['received' => $received]);
    }

    /**
     * Step 3 — verify all chunks, assemble, save to DB, clean up temp files.
     */
    public function finalize(Request $request, Course $course)
    {
        // Allow the assembly to run as long as it needs
        @set_time_limit(0);
        @ignore_user_abort(true);

        $data = $request->validate([
            'upload_id'    => ['required', 'string', 'regex:/^[0-9a-f\-]{36}$/'],
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string|max:5000',
            'total_chunks' => 'required|integer|min:1|max:20000',
            'file_name'    => 'nullable|string|max:255',
        ]);

        $uploadId    = $data['upload_id'];
        $totalChunks = (int) $data['total_chunks'];
        $fileName    = $data['file_name'] ?? 'video.mp4';
        $ext         = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (! in_array($ext, self::ALLOWED_EXT, true)) {
            $ext = 'mp4';
        }

        $dir      = self::CHUNK_DIR . '/' . $uploadId;
        $chunkDir = Storage::disk(self::DISK)->path($dir);

        if (! is_dir($chunkDir)) {
            return response()->json([
                'error' => 'Upload session not found or expired. Please upload the file again.',
            ], 404);
        }

        // Verify every chunk arrived before attempting assembly
        $missing = [];
        for ($i = 0; $i < $totalChunks; $i++) {
            $f = $chunkDir . DIRECTORY_SEPARATOR . 'chunk_' . str_pad($i, 6, '0', STR_PAD_LEFT);
            if (! file_exists($f)) {
                $missing[] = $i;
            }
        }
        if (! empty($missing)) {
            return response()->json([
                'error'   => 'Some chunks are missing: ' . implode(', ', array_slice($missing, 0, 5))
                           . (count($missing) > 5 ? '… and ' . (count($missing) - 5) . ' more' : '')
                           . '. Please retry the upload.',
                'missing' => $missing,
            ], 422);
        }

        // Assemble chunks → final video file
        $finalRelPath = 'images/videos/' . Str::uuid() . '.' . $ext;
        $finalAbsPath = Storage::disk('public')->path($finalRelPath);

        $destDir = dirname($finalAbsPath);
        if (! is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $out = @fopen($finalAbsPath, 'wb');
        if (! $out) {
            return response()->json([
                'error' => 'Cannot write video file. Check that storage/app/public/images/videos is writable.',
            ], 500);
        }

        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkPath = $chunkDir . DIRECTORY_SEPARATOR . 'chunk_' . str_pad($i, 6, '0', STR_PAD_LEFT);
            $in = fopen($chunkPath, 'rb');
            while (! feof($in)) {
                fwrite($out, fread($in, 131072)); // 128 KB read buffer
            }
            fclose($in);
        }
        fclose($out);

        // Clean up temp chunk directory
        foreach (glob($chunkDir . DIRECTORY_SEPARATOR . 'chunk_*') as $chunkFile) {
            @unlink($chunkFile);
        }
        @rmdir($chunkDir);

        // Save to database
        $course->videos()->create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'video_path'  => $finalRelPath,
            'sort_order'  => ($course->videos()->max('sort_order') ?? 0) + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => '"' . $data['title'] . '" uploaded successfully.',
        ]);
    }

    private function validUuid(string $id): bool
    {
        return (bool) preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $id);
    }
}
