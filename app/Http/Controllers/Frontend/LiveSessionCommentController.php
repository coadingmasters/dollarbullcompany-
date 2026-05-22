<?php

namespace App\Http\Controllers\Frontend;

use App\Events\LiveSessionComment;
use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use App\Models\LiveSessionMessage;
use Illuminate\Http\Request;

class LiveSessionCommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $session = LiveSession::findOrFail($id);

        $student = auth('student')->user();
        $name    = $student?->name ?? 'Viewer';
        $message = trim($request->input('message'));
        $time    = now()->format('H:i');

        // Persist to database so it survives page reloads
        LiveSessionMessage::create([
            'live_session_id' => $session->id,
            'student_name'    => $name,
            'message'         => $message,
        ]);

        // Broadcast in real-time to admin broadcast page
        event(new LiveSessionComment(
            sessionId: $session->id,
            name:      $name,
            message:   $message,
            time:      $time,
        ));

        return response()->json(['ok' => true, 'name' => $name, 'time' => $time]);
    }
}
