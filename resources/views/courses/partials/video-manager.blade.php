@php
    $initUrl     = route('courses.videos.upload.init',     $course);
    $chunkUrl    = route('courses.videos.upload.chunk',    $course);
    $finalizeUrl = route('courses.videos.upload.finalize', $course);
@endphp

<div style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border)">
    <label style="font-family:Cinzel,serif;font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:6px">Course Videos</label>
    <p class="help-text" style="margin-bottom:16px">Upload lesson videos (MP4 recommended). Large files are split into chunks automatically — no size limit, no timeouts.</p>

    @if(session('success'))
        <p style="color:#7dcea0;margin-bottom:14px">✓ {{ session('success') }}</p>
    @endif

    {{-- ── Existing videos list ── --}}
    <div id="videoListWrap">
        @if($course->videos->isNotEmpty())
            <ul id="videoItems" style="list-style:none;margin-bottom:20px">
                @foreach($course->videos as $video)
                    <li style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);gap:12px">
                        <span style="color:var(--wd)">{{ $loop->iteration }}. {{ $video->title }}</span>
                        <form method="POST" action="{{ route('courses.videos.destroy', [$course, $video]) }}" onsubmit="return confirm('Remove this video?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:rgba(192,57,43,.15);border:1px solid rgba(192,57,43,.4);color:#e07b73;padding:5px 12px;cursor:pointer;font-size:.75rem">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p id="noVideos" class="help-text" style="margin-bottom:14px">No videos yet.</p>
        @endif
    </div>

    {{-- ── Upload panel ── --}}
    <div style="background:rgba(201,168,76,.04);border:1px solid var(--border);padding:20px" id="uploadPanel">
        <p style="font-family:Cinzel,serif;font-size:.65rem;letter-spacing:.12em;color:var(--gold);margin-bottom:16px;text-transform:uppercase">Add New Video</p>

        {{-- Title --}}
        <div style="margin-bottom:14px">
            <label style="font-family:Cinzel,serif;font-size:.6rem;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:6px">Video Title <span style="color:#e07b73">*</span></label>
            <input type="text" id="vTitle" placeholder="Lesson 1 — Introduction"
                   style="width:100%;padding:10px 12px;background:var(--black);border:1px solid var(--bb);color:var(--wd);font-family:inherit">
        </div>

        {{-- Description --}}
        <div style="margin-bottom:14px">
            <label style="font-family:Cinzel,serif;font-size:.6rem;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:6px">Description</label>
            <textarea id="vDesc" rows="2"
                      style="width:100%;padding:10px 12px;background:var(--black);border:1px solid var(--bb);color:var(--wd);font-family:inherit;resize:vertical"></textarea>
        </div>

        {{-- Drop zone --}}
        <div style="margin-bottom:16px">
            <label style="font-family:Cinzel,serif;font-size:.6rem;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:6px">Video File <span style="color:#e07b73">*</span></label>
            <div id="dropZone"
                 onclick="document.getElementById('vFileInput').click()"
                 style="border:2px dashed rgba(212,160,23,.3);padding:28px 20px;text-align:center;cursor:pointer;transition:border-color .2s;background:rgba(255,255,255,.015)">
                <div id="dzEmpty">
                    <div style="font-size:2rem;margin-bottom:8px;opacity:.5">📹</div>
                    <div style="font-size:.85rem;color:var(--wf)">Drag &amp; drop your video here, or <span style="color:var(--gold)">click to select</span></div>
                    <div style="font-size:.75rem;color:var(--wf);margin-top:5px;opacity:.7">MP4, WebM, MOV, AVI, MKV — any file size</div>
                </div>
                <div id="dzSelected" style="display:none">
                    <div style="font-size:1.8rem;margin-bottom:8px">🎬</div>
                    <div id="dzFileName" style="font-size:.88rem;color:var(--gold-light);word-break:break-all"></div>
                    <div id="dzFileSize" style="font-size:.78rem;color:var(--wf);margin-top:4px"></div>
                </div>
            </div>
            <input type="file" id="vFileInput" accept="video/mp4,video/webm,video/quicktime,.mp4,.webm,.mov,.avi,.mkv" style="display:none">
        </div>

        {{-- Progress --}}
        <div id="progressWrap" style="display:none;margin-bottom:16px;background:rgba(0,0,0,.25);border:1px solid var(--border);padding:14px">
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:.8rem">
                <span id="pStatus" style="color:var(--gold-light)">Preparing…</span>
                <span id="pPct" style="color:var(--wf)">0%</span>
            </div>
            <div style="background:rgba(255,255,255,.06);border-radius:2px;height:8px;overflow:hidden">
                <div id="pBar" style="height:100%;width:0%;border-radius:2px;transition:width .25s ease;background:linear-gradient(90deg,#A07810,#F5C842)"></div>
            </div>
            <div style="display:flex;justify-content:space-between;margin-top:8px;font-size:.75rem;color:var(--wf)">
                <span id="pSpeed"></span>
                <span id="pEta"></span>
            </div>
        </div>

        {{-- Error --}}
        <div id="vError" style="display:none;background:rgba(192,57,43,.12);border:1px solid rgba(192,57,43,.35);color:#e07b73;padding:12px 14px;margin-bottom:14px;font-size:.85rem;line-height:1.5"></div>

        {{-- Success --}}
        <div id="vSuccess" style="display:none;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#86efac;padding:12px 14px;margin-bottom:14px;font-size:.85rem"></div>

        {{-- Buttons --}}
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <button type="button" id="uploadBtn" onclick="vcStartUpload()"
                    class="btn" style="width:auto">
                <span id="uploadBtnTxt">Upload Video</span>
            </button>
            <button type="button" id="cancelBtn" onclick="vcCancel()"
                    style="display:none;background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.4);color:#fca5a5;padding:10px 18px;cursor:pointer;font-family:Cinzel,serif;font-size:.6rem;letter-spacing:.1em;text-transform:uppercase">
                Cancel
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    // ── Constants ──────────────────────────────────────────────
    const CHUNK_SIZE  = 1 * 1024 * 1024;   // 1 MB — safely under PHP's 2 MB limit
    const INIT_URL    = @json($initUrl);
    const CHUNK_URL   = @json($chunkUrl);
    const FINAL_URL   = @json($finalizeUrl);
    // CSRF: try meta tag first, then any hidden _token input on the page
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content
              || document.querySelector('input[name="_token"]')?.value || '';

    // ── State ──────────────────────────────────────────────────
    let selFile   = null;
    let uploading = false;
    let aborted   = false;
    let startedAt = 0;
    let bytesDone = 0;

    // ── File selection ─────────────────────────────────────────
    const fileInput = document.getElementById('vFileInput');
    const dropZone  = document.getElementById('dropZone');

    fileInput.addEventListener('change', () => {
        if (fileInput.files?.[0]) pick(fileInput.files[0]);
    });
    dropZone.addEventListener('dragover',  e => { e.preventDefault(); dropZone.style.borderColor = 'var(--gold)'; });
    dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor = 'rgba(212,160,23,.3)'; });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.style.borderColor = 'rgba(212,160,23,.3)';
        const f = e.dataTransfer?.files?.[0];
        if (f) { fileInput.files = e.dataTransfer.files; pick(f); }
    });

    function pick(file) {
        selFile = file;
        document.getElementById('dzEmpty').style.display = 'none';
        document.getElementById('dzSelected').style.display = 'block';
        document.getElementById('dzFileName').textContent = file.name;
        document.getElementById('dzFileSize').textContent = fmtBytes(file.size);
        hideError(); hideSuccess();
    }

    // ── Upload entry point (called by onclick) ─────────────────
    window.vcStartUpload = async function () {
        if (uploading) return;

        const title = document.getElementById('vTitle').value.trim();
        const desc  = document.getElementById('vDesc').value.trim();

        if (!title)   { showError('Please enter a video title.'); return; }
        if (!selFile) { showError('Please select a video file.'); return; }

        const ext = selFile.name.split('.').pop().toLowerCase();
        if (!['mp4','webm','mov','avi','mkv'].includes(ext)) {
            showError('Unsupported file type. Please use MP4, WebM, MOV, AVI or MKV.');
            return;
        }

        uploading = true;
        aborted   = false;
        bytesDone = 0;
        startedAt = Date.now();

        setBusy(true);
        hideError();
        hideSuccess();
        showProgress(0, 'Initializing upload…');

        const totalChunks = Math.ceil(selFile.size / CHUNK_SIZE);

        try {
            // ── 1. Init ────────────────────────────────────────
            const initRes = await api(INIT_URL, 'POST',
                JSON.stringify({ total_chunks: totalChunks }),
                { 'Content-Type': 'application/json' }
            );
            if (!initRes.ok) throw new Error('Could not start upload session. Please try again.');
            const { upload_id } = await initRes.json();

            // ── 2. Upload chunks ───────────────────────────────
            for (let i = 0; i < totalChunks; i++) {
                if (aborted) throw new Error('__CANCELLED__');

                const start = i * CHUNK_SIZE;
                const end   = Math.min(start + CHUNK_SIZE, selFile.size);
                const blob  = selFile.slice(start, end);

                const fd = new FormData();
                fd.append('upload_id',    upload_id);
                fd.append('chunk_index',  i);
                fd.append('total_chunks', totalChunks);
                fd.append('chunk',        blob, 'chunk');

                const res = await api(CHUNK_URL, 'POST', fd, {});
                if (!res.ok) {
                    const err = await res.json().catch(() => ({}));
                    throw new Error(err.error || 'Failed on chunk ' + i + '. Please retry.');
                }

                bytesDone = end;
                const elapsed = Math.max((Date.now() - startedAt) / 1000, 0.01);
                const speed   = bytesDone / elapsed;
                const eta     = (selFile.size - bytesDone) / speed;
                // 90% of bar for chunks, last 10% for finalize
                const pct = Math.round((bytesDone / selFile.size) * 90);
                showProgress(pct, 'Uploading… (' + (i + 1) + ' / ' + totalChunks + ' chunks)', speed, eta);
            }

            if (aborted) throw new Error('__CANCELLED__');

            // ── 3. Finalize ────────────────────────────────────
            showProgress(93, 'Assembling video on server…');

            const finalRes = await api(FINAL_URL, 'POST',
                JSON.stringify({ upload_id, title, description: desc, total_chunks: totalChunks, file_name: selFile.name }),
                { 'Content-Type': 'application/json' }
            );
            if (!finalRes.ok) {
                const err = await finalRes.json().catch(() => ({}));
                throw new Error(err.message || err.error || 'Finalization failed. Please try again.');
            }

            const result = await finalRes.json();
            showProgress(100, '✓ Done!');

            setTimeout(() => {
                setBusy(false);
                hideProgress();
                showSuccess(result.message || 'Video uploaded successfully!');
                appendToList(title);
                resetForm();
                uploading = false;
            }, 900);

        } catch (err) {
            uploading = false;
            setBusy(false);
            hideProgress();
            if (err.message !== '__CANCELLED__') {
                showError(err.message || 'Upload failed. Please try again.');
            }
        }
    };

    window.vcCancel = function () {
        aborted   = true;
        uploading = false;
        setBusy(false);
        hideProgress();
    };

    // ── Helpers ────────────────────────────────────────────────
    function api(url, method, body, extraHeaders) {
        return fetch(url, {
            method,
            headers: Object.assign({ 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }, extraHeaders),
            body,
        });
    }

    function setBusy(on) {
        const btn    = document.getElementById('uploadBtn');
        const cancel = document.getElementById('cancelBtn');
        const dz     = document.getElementById('dropZone');
        btn.disabled = on;
        document.getElementById('uploadBtnTxt').textContent = on ? 'Uploading…' : 'Upload Video';
        cancel.style.display = on ? 'inline-block' : 'none';
        dz.style.pointerEvents = on ? 'none' : 'auto';
        dz.style.opacity = on ? '.6' : '1';
        document.getElementById('vFileInput').disabled = on;
        document.getElementById('vTitle').disabled = on;
        document.getElementById('vDesc').disabled  = on;
    }

    function showProgress(pct, status, speed, eta) {
        document.getElementById('progressWrap').style.display = 'block';
        document.getElementById('pBar').style.width  = pct + '%';
        document.getElementById('pPct').textContent  = pct + '%';
        document.getElementById('pStatus').textContent = status;
        document.getElementById('pSpeed').textContent  = (speed && speed > 0) ? fmtBytes(speed) + '/s' : '';
        document.getElementById('pEta').textContent   = (eta && eta > 0 && isFinite(eta)) ? 'ETA ' + fmtTime(eta) : '';
    }
    function hideProgress() { document.getElementById('progressWrap').style.display = 'none'; }

    function showError(msg) {
        const el = document.getElementById('vError');
        el.textContent = '⚠ ' + msg;
        el.style.display = 'block';
    }
    function hideError()   { document.getElementById('vError').style.display = 'none'; }

    function showSuccess(msg) {
        const el = document.getElementById('vSuccess');
        el.textContent = '✓ ' + msg;
        el.style.display = 'block';
    }
    function hideSuccess() { document.getElementById('vSuccess').style.display = 'none'; }

    function appendToList(title) {
        const noVid = document.getElementById('noVideos');
        if (noVid) noVid.remove();

        let list = document.getElementById('videoItems');
        if (!list) {
            list = document.createElement('ul');
            list.id = 'videoItems';
            list.style.cssText = 'list-style:none;margin-bottom:20px';
            document.getElementById('uploadPanel').before(list);
        }
        const n  = list.children.length + 1;
        const li = document.createElement('li');
        li.style.cssText = 'display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);gap:12px';
        li.innerHTML = '<span style="color:var(--wd)">' + n + '. ' + esc(title) + '</span>'
                     + '<span style="font-size:.75rem;color:var(--wf)">Just uploaded</span>';
        list.appendChild(li);
    }

    function resetForm() {
        selFile = null;
        document.getElementById('vTitle').value  = '';
        document.getElementById('vDesc').value   = '';
        document.getElementById('vFileInput').value = '';
        document.getElementById('dzEmpty').style.display    = 'block';
        document.getElementById('dzSelected').style.display = 'none';
        dropZone.style.borderColor = 'rgba(212,160,23,.3)';
        dropZone.style.opacity = '1';
    }

    function fmtBytes(b) {
        if (b >= 1073741824) return (b / 1073741824).toFixed(1) + ' GB';
        if (b >= 1048576)    return (b / 1048576).toFixed(1) + ' MB';
        if (b >= 1024)       return (b / 1024).toFixed(0) + ' KB';
        return b + ' B';
    }
    function fmtTime(s) {
        if (s < 60)   return Math.round(s) + 's';
        if (s < 3600) return Math.floor(s / 60) + 'm ' + Math.round(s % 60) + 's';
        return Math.floor(s / 3600) + 'h ' + Math.round((s % 3600) / 60) + 'm';
    }
    function esc(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }
})();
</script>
@endpush
