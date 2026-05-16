@php
    $videoMaxMb = (int) (config('courses.video_max_kb', 204800) / 1024);
@endphp

<div class="form-group" style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border)">
    <label>Course videos</label>
    <p class="help-text" style="margin-bottom:16px">Upload lesson videos (MP4 recommended). Verified students watch these on the course learn page.</p>

    @if($errors->any())
        <div style="background:rgba(192,57,43,.12);border:1px solid rgba(192,57,43,.35);color:#e07b73;padding:12px 14px;margin-bottom:14px;font-size:.85rem">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

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
        <form id="courseVideoUploadForm" method="POST" action="{{ route('courses.videos.store', $course) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Video title <span class="req">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Lesson 1 — Introduction">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="2">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label>Video file <span class="req">*</span></label>
                <input type="file" name="video" accept="video/mp4,video/webm,video/quicktime,.mp4,.webm,.mov" required>
                <div class="help-text">MP4 or WebM — max {{ $videoMaxMb }} MB. Large files may take a minute; keep this tab open.</div>
            </div>
            <button type="submit" class="btn" id="courseVideoUploadBtn" style="flex:none;width:auto"><span>Upload video</span></button>
            <p id="courseVideoUploadStatus" class="help-text" style="margin-top:10px;display:none;color:var(--gold-light)"></p>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const form = document.getElementById('courseVideoUploadForm');
    const btn = document.getElementById('courseVideoUploadBtn');
    const status = document.getElementById('courseVideoUploadStatus');
    const maxMb = {{ $videoMaxMb }};

    if (!form || !btn) return;

    form.addEventListener('submit', function (e) {
        const fileInput = form.querySelector('input[name="video"]');
        const file = fileInput?.files?.[0];

        if (file && file.size > maxMb * 1024 * 1024) {
            e.preventDefault();
            alert('This file is larger than ' + maxMb + ' MB. Choose a smaller video or compress it first.');
            return;
        }

        btn.disabled = true;
        btn.querySelector('span').textContent = 'Uploading…';
        if (status) {
            status.style.display = 'block';
            status.textContent = file
                ? 'Uploading "' + file.name + '" — please wait and do not close this page.'
                : 'Uploading — please wait.';
        }
    });
})();
</script>
@endpush
