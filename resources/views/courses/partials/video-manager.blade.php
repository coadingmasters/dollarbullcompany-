<div class="form-group" style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border)">
    <label>Course videos</label>
    <p class="help-text" style="margin-bottom:16px">Upload multiple lesson videos. Verified students can watch these on the frontend.</p>

    @if(session('success'))
        <p style="color:#7dcea0;margin-bottom:12px">{{ session('success') }}</p>
    @endif

    @if($course->videos->isNotEmpty())
        <ul style="list-style:none;margin-bottom:20px">
            @foreach($course->videos as $video)
                <li style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);gap:12px">
                    <span>{{ $loop->iteration }}. {{ $video->title }}</span>
                    <form method="POST" action="{{ route('courses.videos.destroy', [$course, $video]) }}" onsubmit="return confirm('Remove this video?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:rgba(192,57,43,.15);border:1px solid rgba(192,57,43,.4);color:#e07b73;padding:6px 12px;cursor:pointer;font-size:.75rem">Remove</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p class="help-text" style="margin-bottom:12px">No videos yet.</p>
    @endif

    <div style="background:rgba(201,168,76,.04);border:1px solid var(--border);padding:16px">
        <p style="font-family:Cinzel,serif;font-size:.65rem;letter-spacing:.12em;color:var(--gold);margin-bottom:12px;text-transform:uppercase">Add new video</p>
        <form method="POST" action="{{ route('courses.videos.store', $course) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Video title <span class="req">*</span></label>
                <input type="text" name="title" required placeholder="Lesson 1 — Introduction">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="2"></textarea>
            </div>
            <div class="form-group">
                <label>Video file <span class="req">*</span></label>
                <input type="file" name="video" accept="video/*" required>
                <div class="help-text">MP4, WebM, MOV — max 500MB</div>
            </div>
            <button type="submit" class="btn" style="flex:none;width:auto"><span>Upload video</span></button>
        </form>
    </div>
</div>
