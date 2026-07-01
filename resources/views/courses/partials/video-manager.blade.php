@php
    $initUrl     = route('courses.videos.upload.init',     $course);
    $chunkUrl    = route('courses.videos.upload.chunk',    $course);
    $statusUrl   = route('courses.videos.upload.status',   $course);
    $finalizeUrl = route('courses.videos.upload.finalize', $course);
@endphp

<div style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border)">
    <label style="font-family:Cinzel,serif;font-size:.65rem;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:6px">Course Videos</label>
    <p class="help-text" style="margin-bottom:16px">Upload lesson videos (MP4 recommended). Large files are split into chunks automatically — no size limit, no timeouts.</p>

    @if(session('success'))
        <p style="color:#7dcea0;margin-bottom:14px">✓ {{ session('success') }}</p>
    @endif

    {{-- ── Delete confirmation modal ── --}}
    <div id="delModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.75);align-items:center;justify-content:center">
        <div style="background:#1a1a1a;border:1px solid rgba(192,57,43,.5);padding:28px 32px;max-width:380px;width:90%;text-align:center">
            <div style="font-size:2rem;margin-bottom:12px">🗑️</div>
            <p style="font-family:Cinzel,serif;font-size:.8rem;letter-spacing:.1em;color:#e07b73;margin-bottom:8px;text-transform:uppercase">Delete Video</p>
            <p id="delModalTitle" style="color:var(--wd);font-size:.9rem;margin-bottom:20px"></p>
            <p style="color:var(--wf);font-size:.8rem;margin-bottom:24px">This action cannot be undone.</p>
            <div style="display:flex;gap:10px;justify-content:center">
                <button onclick="closeDelModal()" style="padding:9px 22px;background:rgba(255,255,255,.06);border:1px solid var(--bb);color:var(--wd);cursor:pointer;font-family:Cinzel,serif;font-size:.6rem;letter-spacing:.1em;text-transform:uppercase">Cancel</button>
                <button id="delConfirmBtn" style="padding:9px 22px;background:rgba(192,57,43,.2);border:1px solid rgba(192,57,43,.5);color:#e07b73;cursor:pointer;font-family:Cinzel,serif;font-size:.6rem;letter-spacing:.1em;text-transform:uppercase">Yes, Delete</button>
            </div>
        </div>
    </div>

    {{-- ── Existing videos list ── --}}
    <div id="videoListWrap">
        @if($course->videos->isNotEmpty())
            <ul id="videoItems" style="list-style:none;margin-bottom:20px">
                @foreach($course->videos as $video)
                    <li style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);gap:12px">
                        <span style="color:var(--wd)">{{ $loop->iteration }}. {{ $video->title }}</span>
                        <form method="POST" action="{{ route('courses.videos.destroy', [$course, $video]) }}" class="del-form">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="openDelModal(this, '{{ addslashes($video->title) }}')"
                                    style="background:rgba(192,57,43,.15);border:1px solid rgba(192,57,43,.4);color:#e07b73;padding:5px 12px;cursor:pointer;font-size:.75rem">
                                Delete
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p id="noVideos" class="help-text" style="margin-bottom:14px">No videos yet.</p>
        @endif
    </div>

    <script>
    let _delForm = null;
    function openDelModal(btn, title) {
        _delForm = btn.closest('form');
        document.getElementById('delModalTitle').textContent = '"' + title + '"';
        const modal = document.getElementById('delModal');
        modal.style.display = 'flex';
        document.getElementById('delConfirmBtn').onclick = function () {
            _delForm.submit();
        };
    }
    function closeDelModal() {
        document.getElementById('delModal').style.display = 'none';
        _delForm = null;
    }
    // Close on backdrop click
    document.getElementById('delModal').addEventListener('click', function(e) {
        if (e.target === this) closeDelModal();
    });
    </script>

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
    // ── Config ────────────────────────────────────────────────
    const CHUNK_SIZE    = 2 * 1024 * 1024;  // 2 MB per chunk
    const CONCURRENCY   = 2;                 // parallel chunk uploads (gentle on shared hosting)
    const MAX_RETRIES   = 5;                 // retries per chunk within a pass (with backoff)
    const RETRY_BASE    = 1000;              // ms base delay, doubles each retry
    const RETRY_CAP     = 15000;             // max backoff between retries
    const CHUNK_TIMEOUT = 120000;            // abort a single chunk request after 120s
    const MAX_PASSES    = 6;                 // whole-file resume passes for stragglers

    const INIT_URL   = @json($initUrl);
    const CHUNK_URL  = @json($chunkUrl);
    const STATUS_URL = @json($statusUrl);
    const FINAL_URL  = @json($finalizeUrl);
    const CSRF       = document.querySelector('meta[name="csrf-token"]')?.content
                       || document.querySelector('input[name="_token"]')?.value || '';

    // ── State ─────────────────────────────────────────────────
    let selFile        = null;
    let uploading      = false;
    let aborted        = false;
    let startedAt      = 0;
    let completedBytes = 0;

    // ── DOM ───────────────────────────────────────────────────
    const fileInput = document.getElementById('vFileInput');
    const dropZone  = document.getElementById('dropZone');

    fileInput.addEventListener('change', () => {
        if (fileInput.files?.[0]) pick(fileInput.files[0]);
    });
    dropZone.addEventListener('dragover',  e => { e.preventDefault(); dropZone.style.borderColor = 'var(--gold)'; });
    dropZone.addEventListener('dragleave', ()  => { dropZone.style.borderColor = 'rgba(212,160,23,.3)'; });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.style.borderColor = 'rgba(212,160,23,.3)';
        const f = e.dataTransfer?.files?.[0];
        if (f) { fileInput.files = e.dataTransfer.files; pick(f); }
    });

    function pick(file) {
        selFile = file;
        document.getElementById('dzEmpty').style.display    = 'none';
        document.getElementById('dzSelected').style.display = 'block';
        document.getElementById('dzFileName').textContent   = file.name;
        document.getElementById('dzFileSize').textContent   = fmtBytes(file.size);
        hideError(); hideSuccess();
    }

    // ── Upload entry point ────────────────────────────────────
    window.vcStartUpload = async function () {
        if (uploading) return;

        const title = document.getElementById('vTitle').value.trim();
        const desc  = document.getElementById('vDesc').value.trim();

        if (!title)   { showError('Please enter a video title.'); return; }
        if (!selFile) { showError('Please select a video file.'); return; }

        const ext = selFile.name.split('.').pop().toLowerCase();
        if (!['mp4','webm','mov','avi','mkv'].includes(ext)) {
            showError('Unsupported format. Please use MP4, WebM, MOV, AVI or MKV.');
            return;
        }

        uploading      = true;
        aborted        = false;
        completedBytes = 0;
        startedAt      = Date.now();

        setBusy(true);
        hideError();
        hideSuccess();
        showProgress(0, 'Initializing upload…');

        const totalChunks = Math.ceil(selFile.size / CHUNK_SIZE);

        try {
            // ── Step 1: Init session ───────────────────────────
            const initRes = await apiJSON(INIT_URL, { total_chunks: totalChunks });
            if (!initRes.ok) {
                const body = await initRes.json().catch(() => ({}));
                throw new Error(body.message || body.error || 'Could not start upload session (HTTP ' + initRes.status + '). Please try again.');
            }
            const { upload_id } = await initRes.json();

            // ── Step 2: Upload all chunks in parallel ──────────
            await uploadAllChunks(upload_id, totalChunks);

            if (aborted) throw new Error('__CANCELLED__');

            // ── Step 3: Finalize ───────────────────────────────
            showProgress(92, 'Assembling video on server…');

            const finalRes = await apiJSON(FINAL_URL, {
                upload_id,
                title,
                description:  desc,
                total_chunks: totalChunks,
                file_name:    selFile.name,
            });

            if (!finalRes.ok) {
                const body = await finalRes.json().catch(() => ({}));
                throw new Error(body.message || body.error || 'Finalization failed (HTTP ' + finalRes.status + '). Please try again.');
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
            }, 800);

        } catch (err) {
            uploading = false;
            setBusy(false);
            hideProgress();
            if (err.message !== '__CANCELLED__') {
                const msg = (err.message || 'Upload failed. Please try again.').replace('__FATAL__', '');
                showError(msg);
            }
        }
    };

    window.vcCancel = function () {
        aborted   = true;
        uploading = false;
        setBusy(false);
        hideProgress();
    };

    // ── Parallel chunk uploader with multi-pass resume ────────
    // A single chunk that exhausts its retries is not fatal: we collect
    // stragglers and re-send only those on the next pass, asking the server
    // (status endpoint) which chunks it already has. This survives the
    // intermittent "Failed to fetch" drops common on shared hosting.
    async function uploadAllChunks(uploadId, totalChunks) {
        const chunkBytes = new Array(totalChunks).fill(0); // bytes per chunk index
        for (let i = 0; i < totalChunks; i++) {
            chunkBytes[i] = Math.min(CHUNK_SIZE, selFile.size - i * CHUNK_SIZE);
        }

        let pending = Array.from({ length: totalChunks }, (_, i) => i);

        for (let pass = 0; pass < MAX_PASSES; pass++) {
            if (aborted) throw new Error('__CANCELLED__');

            // On resume passes, ask the server what it already received so we
            // never re-upload chunks that actually made it through.
            if (pass > 0) {
                const received = await fetchReceived(uploadId);
                if (received) {
                    pending = pending.filter(i => !received.has(i));
                    completedBytes = 0;
                    for (let i = 0; i < totalChunks; i++) {
                        if (received.has(i)) completedBytes += chunkBytes[i];
                    }
                }
                if (pending.length === 0) break; // everything landed
                showProgress(
                    Math.min(90, Math.round((completedBytes / selFile.size) * 90)),
                    'Reconnecting — resuming ' + pending.length + ' chunk(s)…'
                );
                await sleep(1500 + Math.random() * 2000); // let any throttle window clear
            }

            const failed = await runUploadPass(uploadId, pending, chunkBytes, totalChunks);

            if (aborted) throw new Error('__CANCELLED__');
            if (failed.length === 0) return; // all chunks delivered
            pending = failed;
        }

        throw new Error(
            pending.length + ' chunk(s) could not be uploaded after several attempts. ' +
            'This is usually a temporary network drop or a server limit on your host — ' +
            'please check your connection and click Upload Video to try again.'
        );
    }

    // Run one pass over the given chunk indices; returns the indices that
    // soft-failed (exhausted retries) so the caller can retry them.
    async function runUploadPass(uploadId, indices, chunkBytes, totalChunks) {
        const queue  = indices.slice();
        const failed = [];
        let   qi     = 0;

        function getNext() {
            if (aborted) return null;
            if (qi >= queue.length) return null;
            return queue[qi++];
        }

        async function worker() {
            while (true) {
                const i = getNext();
                if (i === null) break;
                try {
                    await uploadOneChunkWithRetry(uploadId, i);
                    completedBytes += chunkBytes[i];
                    const elapsed = Math.max((Date.now() - startedAt) / 1000, 0.01);
                    const speed   = completedBytes / elapsed;
                    const eta     = (selFile.size - completedBytes) / Math.max(speed, 1);
                    const pct     = Math.min(90, Math.round((completedBytes / selFile.size) * 90));
                    const done    = Math.round((completedBytes / selFile.size) * totalChunks);
                    showProgress(pct, 'Uploading… (' + done + ' / ' + totalChunks + ' chunks)', speed, eta);
                } catch (e) {
                    if (e.message === '__CANCELLED__') throw e;
                    if (e.message && e.message.indexOf('__FATAL__') === 0) throw e;
                    failed.push(i); // transient — retry on the next pass
                }
            }
        }

        const workers = Array.from({ length: Math.min(CONCURRENCY, queue.length) }, worker);
        await Promise.all(workers);
        return failed;
    }

    // Upload one chunk, retrying transient errors with capped back-off + jitter
    // and a per-request timeout so a stalled socket is aborted (not left hanging).
    async function uploadOneChunkWithRetry(uploadId, index) {
        const start = index * CHUNK_SIZE;
        const end   = Math.min(start + CHUNK_SIZE, selFile.size);

        for (let attempt = 0; attempt <= MAX_RETRIES; attempt++) {
            if (aborted) throw new Error('__CANCELLED__');

            const fd = new FormData();
            fd.append('upload_id',   uploadId);
            fd.append('chunk_index', index);
            fd.append('chunk',       selFile.slice(start, end), 'chunk');

            const ctrl  = new AbortController();
            const timer = setTimeout(() => ctrl.abort(), CHUNK_TIMEOUT);

            try {
                const res = await fetch(CHUNK_URL, {
                    method:  'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                    body:    fd,
                    signal:  ctrl.signal,
                });
                clearTimeout(timer);

                if (res.ok) return; // success

                // 4xx (except 408 timeout / 429 too-many-requests) = real client/
                // session error — retrying won't help, so fail the whole upload.
                if (res.status >= 400 && res.status < 500 && res.status !== 408 && res.status !== 429) {
                    const body = await res.json().catch(() => ({}));
                    throw new Error('__FATAL__' + (body.error || ('Chunk rejected by server (HTTP ' + res.status + ').'))
                        + ' Please refresh the page and try again.');
                }
                // 408 / 429 / 5xx → fall through to retry
            } catch (err) {
                clearTimeout(timer);
                if (aborted) throw new Error('__CANCELLED__');
                if (err.message && err.message.indexOf('__FATAL__') === 0) throw err;
                // network error / timeout / abort → retry
            }

            if (attempt === MAX_RETRIES) {
                throw new Error('chunk ' + index + ' unreachable'); // soft-fail → next pass
            }

            // Exponential back-off with jitter, capped
            const backoff = Math.min(RETRY_BASE * Math.pow(2, attempt), RETRY_CAP);
            await sleep(backoff + Math.random() * 600);
        }
    }

    // Ask the server which chunk indices it currently holds (for resume).
    async function fetchReceived(uploadId) {
        try {
            const res = await fetch(STATUS_URL + '?upload_id=' + encodeURIComponent(uploadId), {
                method:  'GET',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            if (!res.ok) return null;
            const body = await res.json();
            return new Set(Array.isArray(body.received) ? body.received : []);
        } catch (_) {
            return null; // status check is best-effort
        }
    }

    // ── Fetch helpers ─────────────────────────────────────────
    function apiJSON(url, data) {
        return fetch(url, {
            method:  'POST',
            headers: {
                'Content-Type':  'application/json',
                'X-CSRF-TOKEN':  CSRF,
                'Accept':        'application/json',
            },
            body: JSON.stringify(data),
        });
    }

    function sleep(ms) {
        return new Promise(r => setTimeout(r, ms));
    }

    // ── UI helpers ────────────────────────────────────────────
    function setBusy(on) {
        const btn    = document.getElementById('uploadBtn');
        const cancel = document.getElementById('cancelBtn');
        const dz     = document.getElementById('dropZone');
        btn.disabled = on;
        document.getElementById('uploadBtnTxt').textContent = on ? 'Uploading…' : 'Upload Video';
        cancel.style.display      = on ? 'inline-block' : 'none';
        dz.style.pointerEvents    = on ? 'none' : 'auto';
        dz.style.opacity          = on ? '.5' : '1';
        document.getElementById('vFileInput').disabled = on;
        document.getElementById('vTitle').disabled     = on;
        document.getElementById('vDesc').disabled      = on;
    }

    function showProgress(pct, status, speed, eta) {
        document.getElementById('progressWrap').style.display  = 'block';
        document.getElementById('pBar').style.width            = pct + '%';
        document.getElementById('pPct').textContent            = pct + '%';
        document.getElementById('pStatus').textContent         = status;
        document.getElementById('pSpeed').textContent          = (speed > 0) ? fmtBytes(speed) + '/s' : '';
        document.getElementById('pEta').textContent            = (eta > 0 && isFinite(eta)) ? 'ETA ' + fmtTime(eta) : '';
    }
    function hideProgress() { document.getElementById('progressWrap').style.display = 'none'; }

    function showError(msg) {
        const el = document.getElementById('vError');
        el.innerHTML  = '⚠ ' + esc(msg);
        el.style.display = 'block';
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    function hideError()   { document.getElementById('vError').style.display   = 'none'; }

    function showSuccess(msg) {
        const el = document.getElementById('vSuccess');
        el.textContent   = '✓ ' + msg;
        el.style.display = 'block';
    }
    function hideSuccess() { document.getElementById('vSuccess').style.display = 'none'; }

    function appendToList(title) {
        const noVid = document.getElementById('noVideos');
        if (noVid) noVid.remove();

        let list = document.getElementById('videoItems');
        if (!list) {
            list          = document.createElement('ul');
            list.id       = 'videoItems';
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
        document.getElementById('vTitle').value              = '';
        document.getElementById('vDesc').value               = '';
        document.getElementById('vFileInput').value          = '';
        document.getElementById('dzEmpty').style.display     = 'block';
        document.getElementById('dzSelected').style.display  = 'none';
        dropZone.style.borderColor = 'rgba(212,160,23,.3)';
        dropZone.style.opacity     = '1';
    }

    function fmtBytes(b) {
        if (b >= 1073741824) return (b / 1073741824).toFixed(1) + ' GB';
        if (b >= 1048576)    return (b / 1048576).toFixed(1)    + ' MB';
        if (b >= 1024)       return (b / 1024).toFixed(0)       + ' KB';
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
