<?php

namespace App\Http\Controllers\Frontend;

use App\Events\LiveSessionComment;
use App\Http\Controllers\Controller;
use App\Models\LiveSession;
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

        event(new LiveSessionComment(
            sessionId: $session->id,
            name:      $name,
            message:   trim($request->input('message')),
            time:      now()->format('H:i'),
        ));

        return response()->json(['ok' => true]);
    }
}
