@extends('layouts.admin')

@section('title', 'Add Slide — Admin')
@section('breadcrumb', 'Add Slide')
@section('page_eyebrow', 'Hero Slider')
@section('page_title', 'Add New Slide')
@section('page_actions')
    <a href="{{ route('admin.sliders.index') }}" class="btn-sm btn-outline-gold">← Back to Slides</a>
@endsection

@push('styles')
<style>
.slide-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
.form-card { background: var(--bc); border: 1px solid var(--bb); border-radius: 3px; padding: 24px; }
.form-card-title {
    font-family: Cinzel, serif; font-size: .65rem; letter-spacing: .2em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--bb);
    display: flex; align-items: center; gap: 8px;
}
.form-group { margin-bottom: 18px; }
.form-label {
    display: block; font-family: Cinzel, serif; font-size: .58rem; letter-spacing: .14em;
    text-transform: uppercase; color: var(--wf); margin-bottom: 7px;
}
.form-control {
    width: 100%; background: rgba(255,255,255,.04); border: 1px solid var(--bb); border-radius: 2px;
    padding: 10px 14px; color: #fff; font-size: .88rem; font-family: inherit;
    transition: border-color .25s, background .25s; outline: none;
}
.form-control:focus { border-color: rgba(212,160,23,.5); background: rgba(255,255,255,.06); }
.form-control::placeholder { color: rgba(255,255,255,.22); }
textarea.form-control { resize: vertical; min-height: 80px; }
.form-hint { font-size: .75rem; color: var(--wf); margin-top: 5px; }
.form-divider { border: none; border-top: 1px solid var(--bb); margin: 16px 0; }
.preview-box {
    width: 100%; height: 160px; background: #0a0a0a; border: 1px solid var(--bb);
    border-radius: 2px; display: flex; align-items: center; justify-content: center;
    overflow: hidden; margin-bottom: 14px;
}
.preview-box img { width: 100%; height: 100%; object-fit: cover; display: none; }
.preview-placeholder { font-family: Cinzel, serif; font-size: .65rem; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.2); }
.toggle-wrap { display: flex; align-items: center; gap: 10px; }
.toggle-track {
    width: 40px; height: 22px; background: rgba(255,255,255,.1); border: 1px solid var(--bb);
    border-radius: 11px; position: relative; cursor: pointer; transition: background .25s;
}
.toggle-track.on { background: rgba(34,197,94,.3); border-color: rgba(34,197,94,.5); }
.toggle-knob {
    position: absolute; top: 2px; left: 2px; width: 16px; height: 16px; border-radius: 50%;
    background: rgba(255,255,255,.35); transition: transform .25s, background .25s;
}
.toggle-track.on .toggle-knob { transform: translateX(18px); background: #4ade80; }
.toggle-label { font-size: .82rem; color: var(--wf); }
@media(max-width:900px) { .slide-form-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<form method="POST" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data">
@csrf

<div class="slide-form-grid">

    {{-- LEFT: Image + Buttons --}}
    <div>
        <div class="form-card">
            <div class="form-card-title">
                <svg style="width:13px;height:13px;stroke:var(--gold);fill:none;stroke-width:2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Slide Image
            </div>

            <div class="preview-box" id="previewBox">
                <img id="imgPreview" src="" alt="Preview">
                <span class="preview-placeholder" id="previewPlaceholder">Image Preview</span>
            </div>

            <div class="form-group">
                <label class="form-label">Upload Image File</label>
                <input type="file" name="image_file" id="imageFile" class="form-control" accept="image/*">
                <div class="form-hint">Max 5 MB. JPG, PNG, WebP. If provided, overrides URL below.</div>
            </div>

            <div style="text-align:center;color:var(--wf);font-size:.78rem;margin:4px 0">— or —</div>

            <div class="form-group">
                <label class="form-label">Image URL</label>
                <input type="text" name="image_url" id="imageUrl" class="form-control" placeholder="https://example.com/image.jpg">
                <div class="form-hint">Use a direct image URL (e.g. from Unsplash).</div>
            </div>

            <hr class="form-divider">

            <div class="form-card-title" style="margin-top:4px">Buttons</div>

            <div class="form-group">
                <label class="form-label">Button 1 Label</label>
                <input type="text" name="btn1_label" class="form-control" placeholder="Start Trading" value="{{ old('btn1_label') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Button 1 URL</label>
                <input type="text" name="btn1_url" class="form-control" placeholder="/courses" value="{{ old('btn1_url') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Button 2 Label</label>
                <input type="text" name="btn2_label" class="form-control" placeholder="Learn More" value="{{ old('btn2_label') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Button 2 URL</label>
                <input type="text" name="btn2_url" class="form-control" placeholder="/about" value="{{ old('btn2_url') }}">
            </div>
        </div>
    </div>

    {{-- RIGHT: Text fields + Settings --}}
    <div style="display:flex;flex-direction:column;gap:24px">
        <div class="form-card">
            <div class="form-card-title">
                <svg style="width:13px;height:13px;stroke:var(--gold);fill:none;stroke-width:2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Slide Text
            </div>

            <div class="form-group">
                <label class="form-label">Badge / Tag <span style="color:var(--wf)">(top label)</span></label>
                <input type="text" name="badge" class="form-control" placeholder="Welcome to Dollar Bull University" value="{{ old('badge') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Headline</label>
                <input type="text" name="headline" class="form-control" placeholder="The Future of Digital" value="{{ old('headline') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Highlighted Word <span style="color:var(--wf)">(shown in gold)</span></label>
                <input type="text" name="highlight" class="form-control" placeholder="Finance Is Here" value="{{ old('highlight') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Sub-text / Description</label>
                <textarea name="sub" class="form-control" placeholder="Trade, invest and grow your crypto portfolio...">{{ old('sub') }}</textarea>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-title">Settings</div>
            <div class="form-group">
                <label class="form-label">Sort Order <span style="color:var(--wf)">(lower = shown first)</span></label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0" style="max-width:120px">
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <div class="toggle-wrap" id="toggleWrap">
                    <div class="toggle-track on" id="toggleTrack" onclick="toggleActive()"></div>
                    <input type="hidden" name="is_active" id="isActiveInput" value="1">
                    <span class="toggle-label" id="toggleLabel">Active (visible on homepage)</span>
                </div>
            </div>

            <div style="margin-top:24px;display:flex;gap:10px">
                <button type="submit" class="btn-sm btn-gold">Save Slide</button>
                <a href="{{ route('admin.sliders.index') }}" class="btn-sm btn-outline-gold">Cancel</a>
            </div>
        </div>
    </div>

</div>
</form>
@endsection

@push('scripts')
<script>
// Live image preview
document.getElementById('imageFile').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (e) { showPreview(e.target.result); };
    reader.readAsDataURL(file);
    document.getElementById('imageUrl').value = ''; // clear URL field
});

document.getElementById('imageUrl').addEventListener('input', function () {
    const url = this.value.trim();
    if (url) showPreview(url);
});

function showPreview(src) {
    const img = document.getElementById('imgPreview');
    const placeholder = document.getElementById('previewPlaceholder');
    img.src = src;
    img.style.display = 'block';
    placeholder.style.display = 'none';
}

// Active toggle
function toggleActive() {
    const track = document.getElementById('toggleTrack');
    const input = document.getElementById('isActiveInput');
    const label = document.getElementById('toggleLabel');
    const isOn = track.classList.toggle('on');
    input.value = isOn ? '1' : '0';
    label.textContent = isOn ? 'Active (visible on homepage)' : 'Hidden (not shown on homepage)';
}
</script>
@endpush
