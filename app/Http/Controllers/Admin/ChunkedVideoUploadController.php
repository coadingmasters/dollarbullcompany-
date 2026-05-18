<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChunkedVideoUploadController extends Controller
{
    private const CHUNK_DIR         = 'video-chunks';
    private const ALLOWED_EXT       = ['mp4', 'webm', 'mov', 'avi', 'mkv'];

    /** Step 1: reserve an upload session, return a UUID the client reuses */
    public function init(Request $request, Course $course)
    {
        $request->validate(['total_chunks' => 'required|integer|min:1|max:20000']);

        $uploadId = Str::uuid()->toString();
        Storage::makeDirectory(self::CHUNK_DIR . '/' . $uploadId);

        return response()->json(['upload_id' => $uploadId]);
    }

    /** Step 2 (repeated): store one chunk on disk */
    public function chunk(Request $request, Course $course)
    {
        $uploadId = $request->input('upload_id', '');
        if (!$this->validUuid($uploadId)) {
            return response()->json(['error' => 'Invalid upload ID.'], 400);
        }

        if (!$request->hasFile('chunk') || !$request->file('chunk')->isValid()) {
            return response()->json(['error' => 'Chunk missing or corrupt.'], 400);
        }

        $index     = (int) $request->input('chunk_index', 0);
        $chunkName = 'chunk_' . str_pad($index, 6, '0', STR_PAD_LEFT);
        $request->file('chunk')->storeAs(self::CHUNK_DIR . '/' . $uploadId, $chunkName);

        return response()->json(['ok' => true, 'index' => $index]);
    }

    /** Step 3: validate all chunks exist, assemble file, save to DB */
    public function finalize(Request $request, Course $course)
    {
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
        if (!in_array($ext, self::ALLOWED_EXT, true)) {
            $ext = 'mp4';
        }

        $chunkDir = storage_path('app/' . self::CHUNK_DIR . '/' . $uploadId);
        if (!is_dir($chunkDir)) {
            return response()->json(['error' => 'Upload session not found or expired. Please try again.'], 404);
        }

        // Verify every chunk arrived
        for ($i = 0; $i < $totalChunks; $i++) {
            $f = $chunkDir . '/chunk_' . str_pad($i, 6, '0', STR_PAD_LEFT);
            if (!file_exists($f)) {
                return response()->json(['error' => 'Chunk ' . $i . ' is missing. Please retry the upload.'], 422);
            }
        }

        // Assemble
        $finalRelPath = 'images/videos/' . Str::uuid() . '.' . $ext;
        $finalAbsPath = storage_path('app/public/' . $finalRelPath);

        if (!is_dir(dirname($finalAbsPath))) {
            mkdir(dirname($finalAbsPath), 0755, true);
        }

        $out = fopen($finalAbsPath, 'wb');
        if (!$out) {
            return response()->json(['error' => 'Cannot write video file. Check storage permissions.'], 500);
        }

        for ($i = 0; $i < $totalChunks; $i++) {
            $in = fopen($chunkDir . '/chunk_' . str_pad($i, 6, '0', STR_PAD_LEFT), 'rb');
            while (!feof($in)) {
                fwrite($out, fread($in, 65536));
            }
            fclose($in);
        }
        fclose($out);

        // Clean up temp chunks
        array_map('unlink', glob($chunkDir . '/chunk_*'));
        @rmdir($chunkDir);

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
