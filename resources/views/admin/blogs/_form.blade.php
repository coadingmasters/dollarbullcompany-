@php $isEdit = isset($blog); @endphp

@push('styles')
<style>
    :root {
        --gold:     #C9A84C;
        --gold-l:   #E8C97A;
        --gold-m:   rgba(201,168,76,.10);
        --gold-b:   rgba(201,168,76,.2);
        --gold-bh:  rgba(201,168,76,.5);
        --card:     #161616;
        --bdr:      rgba(201,168,76,.18);
        --bg2:      #0d0d0d;
        --txt:      #D8D0C0;
        --muted:    #7a7060;
        --err:      #e07a72;
    }

    .form-grid { display:grid; grid-template-columns:1fr 290px; gap:18px; align-items:start; }

    /* ── Cards ── */
    .form-card {
        background:var(--card); border:1px solid var(--bdr);
        overflow:hidden; margin-bottom:14px;
    }
    .form-card:last-child { margin-bottom:0; }
    .card-head {
        padding:12px 18px; border-bottom:1px solid var(--bdr);
        font-family:Cinzel,serif; font-size:.65rem; letter-spacing:.15em;
        text-transform:uppercase; color:var(--gold);
        background:rgba(201,168,76,.04);
    }
    .card-body { padding:18px; }

    /* ── Fields ── */
    .field { margin-bottom:16px; }
    .field:last-child { margin-bottom:0; }
    .field-label {
        display:block; font-family:Cinzel,serif; font-size:.62rem;
        letter-spacing:.12em; text-transform:uppercase; color:var(--gold);
        margin-bottom:7px;
    }
    .field-label .req { color:var(--err); margin-left:2px; }
    .field-input, .field-select, .field-textarea {
        width:100%; padding:9px 12px;
        background:var(--bg2); border:1px solid var(--bdr); color:var(--txt);
        font-family:Georgia,serif; font-size:.87rem; outline:none;
        transition:border-color .18s;
    }
    .field-input:focus, .field-select:focus, .field-textarea:focus {
        border-color:var(--gold-bh);
        box-shadow:0 0 0 2px rgba(201,168,76,.08);
    }
    .field-input::placeholder, .field-textarea::placeholder { color:var(--muted); }
    .field-textarea { resize:vertical; min-height:88px; }
    .field-hint  { font-size:.72rem; color:var(--muted); margin-top:4px; font-style:italic; }
    .field-error { font-size:.72rem; color:var(--err); margin-top:4px; }

    /* Slug preview */
    .slug-preview {
        display:inline-block; margin-top:5px; font-size:.72rem;
        color:var(--gold-l); background:var(--gold-m);
        border:1px solid var(--gold-b); padding:2px 9px;
        font-family:Cinzel,serif; letter-spacing:.04em;
    }

    /* Excerpt counter */
    .excerpt-footer { display:flex; justify-content:flex-end; margin-top:4px; }
    .char-count { font-size:.72rem; color:var(--muted); font-style:italic; }

    /* ── Tiptap toolbar ── */
    .tiptap-wrap { border:1px solid var(--bdr); overflow:hidden; transition:border-color .18s; }
    .tiptap-wrap:focus-within { border-color:var(--gold-bh); }

    .tiptap-toolbar {
        display:flex; align-items:center; gap:2px; flex-wrap:wrap;
        padding:7px 10px; background:rgba(201,168,76,.04); border-bottom:1px solid var(--bdr);
    }
    .tb-btn {
        min-width:28px; height:26px; padding:0 5px; border:1px solid transparent;
        background:none; cursor:pointer; font-size:.8rem;
        color:var(--txt); display:flex; align-items:center; justify-content:center;
        transition:all .14s; font-weight:600; font-family:Georgia,serif;
    }
    .tb-btn svg { width:13px; height:13px; }
    .tb-btn:hover { background:rgba(201,168,76,.12); border-color:var(--gold-b); color:var(--gold-l); }
    .tb-btn.is-active { background:rgba(201,168,76,.18); color:var(--gold-l); border-color:var(--gold-bh); }
    .tb-sep { width:1px; height:18px; background:var(--bdr); margin:0 3px; }

    .tiptap-editor {
        padding:16px 18px; min-height:340px; outline:none;
        font-family:Georgia,serif; font-size:.9rem; line-height:1.75; color:var(--txt);
        background:var(--bg2);
    }
    .tiptap-editor h1 { font-family:Cinzel,serif; font-size:1.5rem; font-weight:700; color:#fff; margin:.6em 0 .3em; }
    .tiptap-editor h2 { font-family:Cinzel,serif; font-size:1.2rem; font-weight:700; color:#fff; margin:.6em 0 .3em; }
    .tiptap-editor h3 { font-family:Cinzel,serif; font-size:1rem; font-weight:600; color:var(--txt); margin:.6em 0 .3em; }
    .tiptap-editor p  { margin:.4em 0; }
    .tiptap-editor ul, .tiptap-editor ol { padding-left:1.5em; margin:.4em 0; }
    .tiptap-editor blockquote {
        border-left:3px solid var(--gold); padding-left:14px;
        margin:.6em 0; color:var(--muted); font-style:italic;
    }
    .tiptap-editor pre {
        background:#0a0a0a; color:#e2e8f0; border:1px solid #1a1a1a;
        padding:14px 16px; margin:.6em 0; font-size:.82rem; overflow-x:auto;
    }
    .tiptap-editor code { background:#111; border:1px solid #1a1a1a; padding:1px 5px; font-size:.82rem; color:var(--gold-l); }
    .tiptap-editor pre code { background:none; border:none; padding:0; color:inherit; }
    .tiptap-editor hr { border:none; border-top:1px solid var(--bdr); margin:1em 0; }
    .tiptap-editor a { color:var(--gold); text-decoration:underline; }
    .ProseMirror-focused { outline:none; }
    .ProseMirror p.is-editor-empty:first-child::before {
        content:attr(data-placeholder); color:var(--muted);
        pointer-events:none; float:left; height:0; font-style:italic;
    }

    /* ── Image upload ── */
    .img-drop {
        border:2px dashed var(--bdr); padding:24px; text-align:center;
        cursor:pointer; transition:all .2s; position:relative; overflow:hidden;
        background:var(--bg2);
    }
    .img-drop:hover { border-color:var(--gold-bh); background:rgba(201,168,76,.04); }
    .img-drop input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; z-index:2; }
    .img-drop-icon { font-size:1.5rem; margin-bottom:6px; opacity:.4; }
    .img-drop-text { font-size:.78rem; color:var(--muted); font-style:italic; }
    .img-drop-text span { color:var(--gold-l); font-style:normal; }
    .img-preview-wrap { margin-top:10px; position:relative; }
    .img-preview { width:100%; height:150px; object-fit:cover; display:none; border:1px solid var(--bdr); }
    .img-remove {
        position:absolute; top:6px; right:6px; background:rgba(0,0,0,.7);
        border:1px solid var(--bdr); color:var(--gold-l); padding:3px 9px;
        font-family:Cinzel,serif; font-size:.58rem; letter-spacing:.06em; cursor:pointer;
    }
    .img-existing { width:100%; height:150px; object-fit:cover; border:1px solid var(--bdr); }

    /* ── Submit buttons ── */
    .submit-group { display:flex; flex-direction:column; gap:8px; }
    .btn-publish {
        width:100%; padding:10px; background:var(--gold-m); color:var(--gold-l);
        border:1px solid var(--gold-bh); font-family:Cinzel,serif; font-size:.68rem;
        letter-spacing:.15em; text-transform:uppercase; cursor:pointer; transition:all .18s;
    }
    .btn-publish:hover { background:rgba(201,168,76,.2); }
    .btn-draft {
        width:100%; padding:10px; background:#0d0d0d; color:var(--muted);
        border:1px solid var(--bdr); font-family:Cinzel,serif; font-size:.68rem;
        letter-spacing:.15em; text-transform:uppercase; cursor:pointer; transition:all .18s;
    }
    .btn-draft:hover { border-color:var(--gold-b); color:var(--txt); }

    @media (max-width:860px) { .form-grid { grid-template-columns:1fr; } }
</style>
@endpush

<form id="blogForm"
    action="{{ $isEdit ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="form-grid">

        {{-- ══ LEFT COLUMN ══ --}}
        <div>

            {{-- Title & Slug --}}
            <div class="form-card">
                <div class="card-head">Post Content</div>
                <div class="card-body">
                    <div class="field">
                        <label class="field-label" for="title">Title <span class="req">*</span></label>
                        <input type="text" id="title" name="title"
                            value="{{ old('title', $isEdit ? $blog->title : '') }}"
                            placeholder="Enter post title…" class="field-input" autocomplete="off">
                        @error('title')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="slug">Slug <span class="req">*</span></label>
                        <input type="text" id="slug" name="slug"
                            value="{{ old('slug', $isEdit ? $blog->slug : '') }}"
                            placeholder="auto-generated-from-title" class="field-input" autocomplete="off">
                        <div id="slugPreview" class="slug-preview">/blog/your-post-slug</div>
                        @error('slug')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="excerpt">Excerpt</label>
                        <textarea id="excerpt" name="excerpt" rows="3"
                            placeholder="Short summary shown on listing pages…"
                            class="field-textarea" maxlength="500">{{ old('excerpt', $isEdit ? $blog->excerpt : '') }}</textarea>
                        <div class="excerpt-footer">
                            <span class="char-count" id="charCount">500 characters remaining</span>
                        </div>
                        @error('excerpt')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Body (Tiptap) --}}
            <div class="form-card">
                <div class="card-head">Body Content</div>
                <div class="card-body" style="padding:0">
                    <div class="tiptap-wrap" style="border:none">
                        <div class="tiptap-toolbar" id="tiptapToolbar">
                            <button type="button" class="tb-btn" id="tb-bold"        title="Bold"><b>B</b></button>
                            <button type="button" class="tb-btn" id="tb-italic"      title="Italic"><i>I</i></button>
                            <button type="button" class="tb-btn" id="tb-underline"   title="Underline"><u>U</u></button>
                            <button type="button" class="tb-btn" id="tb-strike"      title="Strikethrough"><s>S</s></button>
                            <div class="tb-sep"></div>
                            <button type="button" class="tb-btn" id="tb-h1"         title="Heading 1">H1</button>
                            <button type="button" class="tb-btn" id="tb-h2"         title="Heading 2">H2</button>
                            <button type="button" class="tb-btn" id="tb-h3"         title="Heading 3">H3</button>
                            <div class="tb-sep"></div>
                            <button type="button" class="tb-btn" id="tb-ul" title="Bullet list">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="9" y1="6" x2="20" y2="6"/><line x1="9" y1="12" x2="20" y2="12"/><line x1="9" y1="18" x2="20" y2="18"/><circle cx="4" cy="6" r="1" fill="currentColor"/><circle cx="4" cy="12" r="1" fill="currentColor"/><circle cx="4" cy="18" r="1" fill="currentColor"/></svg>
                            </button>
                            <button type="button" class="tb-btn" id="tb-ol" title="Ordered list">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4M4 10h2M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg>
                            </button>
                            <button type="button" class="tb-btn" id="tb-blockquote" title="Blockquote">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                            </button>
                            <button type="button" class="tb-btn" id="tb-code" title="Code block">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                            </button>
                            <div class="tb-sep"></div>
                            <button type="button" class="tb-btn" id="tb-link" title="Add link">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                            </button>
                            <button type="button" class="tb-btn" id="tb-hr" title="Divider">—</button>
                            <div class="tb-sep"></div>
                            <button type="button" class="tb-btn" id="tb-undo" title="Undo">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7v6h6"/><path d="M21 17a9 9 0 00-9-9 9 9 0 00-6 2.3L3 13"/></svg>
                            </button>
                            <button type="button" class="tb-btn" id="tb-redo" title="Redo">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 7v6h-6"/><path d="M3 17a9 9 0 019-9 9 9 0 016 2.3l3 2.7"/></svg>
                            </button>
                        </div>
                        <div class="tiptap-editor" id="tiptapEditor"></div>
                    </div>
                    <textarea name="body" id="bodyHidden" style="display:none">{{ old('body', $isEdit ? $blog->body : '') }}</textarea>
                    @error('body')<div class="field-error" style="padding:8px 18px 12px">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>

        {{-- ══ RIGHT COLUMN ══ --}}
        <div>

            {{-- Publish --}}
            <div class="form-card">
                <div class="card-head">Publish</div>
                <div class="card-body">
                    <div class="submit-group">
                        <button type="submit" name="_publish" value="1" class="btn-publish">
                            {{ $isEdit ? '✦ Update Post' : '✦ Publish Post' }}
                        </button>
                        <button type="submit" name="_draft" value="1" class="btn-draft">
                            Save as Draft
                        </button>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="form-card">
                <div class="card-head">Status</div>
                <div class="card-body">
                    <div class="field">
                        <label class="field-label" for="statusField">Status</label>
                        <select name="status" id="statusField" class="field-select">
                            <option value="draft"     {{ old('status', $isEdit ? $blog->status : 'draft') === 'draft'     ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $isEdit ? $blog->status : 'draft') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="scheduled" {{ old('status', $isEdit ? $blog->status : 'draft') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        </select>
                    </div>
                    <div class="field" id="publishedAtWrap" style="display:none">
                        <label class="field-label" for="published_at">Publish Date &amp; Time</label>
                        <input type="datetime-local" id="published_at" name="published_at"
                            value="{{ old('published_at', $isEdit && $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}"
                            class="field-input">
                        @error('published_at')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Details --}}
            <div class="form-card">
                <div class="card-head">Details</div>
                <div class="card-body">
                    <div class="field">
                        <label class="field-label" for="category">Category</label>
                        <select name="category" id="category" class="field-select">
                            @foreach(['General','Tech','Design','Business','Lifestyle'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $isEdit ? $blog->category : 'General') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="author">Author</label>
                        <input type="text" id="author" name="author"
                            value="{{ old('author', $isEdit ? $blog->author : (auth('admin')->user()?->name ?? '')) }}"
                            placeholder="Author name" class="field-input">
                        @error('author')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="form-card">
                <div class="card-head">Featured Image</div>
                <div class="card-body">
                    @if($isEdit && $blog->featured_image)
                    <div class="img-preview-wrap" id="existingImgWrap">
                        <img src="{{ Storage::url($blog->featured_image) }}" alt="Featured" class="img-existing" id="existingImg">
                        <button type="button" class="img-remove" onclick="removeExistingImage()">Remove</button>
                    </div>
                    <input type="hidden" name="_keep_image" id="keepImage" value="1">
                    <div id="uploadZoneWrap" style="margin-top:10px;display:none">
                    @else
                    <div id="uploadZoneWrap">
                    @endif
                        <div class="img-drop" id="imgDrop">
                            <input type="file" name="featured_image" id="featuredImage" accept="image/*">
                            <div class="img-drop-icon">◈</div>
                            <div class="img-drop-text">
                                Drop image here or <span>click to browse</span><br>
                                <span style="font-size:.68rem">PNG, JPG, WebP — max 5MB</span>
                            </div>
                        </div>
                        <div class="img-preview-wrap">
                            <img id="imgPreview" class="img-preview" alt="Preview">
                        </div>
                    </div>
                    @error('featured_image')<div class="field-error" style="margin-top:8px">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>{{-- end right column --}}
    </div>{{-- end form-grid --}}
</form>

@push('scripts')
<script type="module">
import { Editor } from 'https://esm.sh/@tiptap/core@2';
import StarterKit from 'https://esm.sh/@tiptap/starter-kit@2';
import Underline from 'https://esm.sh/@tiptap/extension-underline@2';
import Link from 'https://esm.sh/@tiptap/extension-link@2';
import Placeholder from 'https://esm.sh/@tiptap/extension-placeholder@2';

const bodyHidden = document.getElementById('bodyHidden');
const editor = new Editor({
    element: document.getElementById('tiptapEditor'),
    extensions: [
        StarterKit,
        Underline,
        Link.configure({ openOnClick: false }),
        Placeholder.configure({ placeholder: 'Start writing your post…' }),
    ],
    content: bodyHidden.value || '',
    onUpdate({ editor }) { bodyHidden.value = editor.getHTML(); updateToolbarState(); },
    onSelectionUpdate() { updateToolbarState(); },
});

document.getElementById('blogForm').addEventListener('submit', function () {
    bodyHidden.value = editor.getHTML();
});

function tb(id, action) {
    document.getElementById(id)?.addEventListener('click', function(e) {
        e.preventDefault(); action(); updateToolbarState();
    });
}
tb('tb-bold',        () => editor.chain().focus().toggleBold().run());
tb('tb-italic',      () => editor.chain().focus().toggleItalic().run());
tb('tb-underline',   () => editor.chain().focus().toggleUnderline().run());
tb('tb-strike',      () => editor.chain().focus().toggleStrike().run());
tb('tb-h1',          () => editor.chain().focus().toggleHeading({ level: 1 }).run());
tb('tb-h2',          () => editor.chain().focus().toggleHeading({ level: 2 }).run());
tb('tb-h3',          () => editor.chain().focus().toggleHeading({ level: 3 }).run());
tb('tb-ul',          () => editor.chain().focus().toggleBulletList().run());
tb('tb-ol',          () => editor.chain().focus().toggleOrderedList().run());
tb('tb-blockquote',  () => editor.chain().focus().toggleBlockquote().run());
tb('tb-code',        () => editor.chain().focus().toggleCodeBlock().run());
tb('tb-hr',          () => editor.chain().focus().setHorizontalRule().run());
tb('tb-undo',        () => editor.chain().focus().undo().run());
tb('tb-redo',        () => editor.chain().focus().redo().run());
tb('tb-link', () => {
    const prev = editor.getAttributes('link').href;
    const url  = window.prompt('Enter URL:', prev || 'https://');
    if (url === null) return;
    url === '' ? editor.chain().focus().unsetLink().run()
               : editor.chain().focus().setLink({ href: url }).run();
    updateToolbarState();
});

function updateToolbarState() {
    const map = {
        'tb-bold':       () => editor.isActive('bold'),
        'tb-italic':     () => editor.isActive('italic'),
        'tb-underline':  () => editor.isActive('underline'),
        'tb-strike':     () => editor.isActive('strike'),
        'tb-h1':         () => editor.isActive('heading', { level: 1 }),
        'tb-h2':         () => editor.isActive('heading', { level: 2 }),
        'tb-h3':         () => editor.isActive('heading', { level: 3 }),
        'tb-ul':         () => editor.isActive('bulletList'),
        'tb-ol':         () => editor.isActive('orderedList'),
        'tb-blockquote': () => editor.isActive('blockquote'),
        'tb-code':       () => editor.isActive('codeBlock'),
        'tb-link':       () => editor.isActive('link'),
    };
    Object.entries(map).forEach(([id, check]) => {
        document.getElementById(id)?.classList.toggle('is-active', check());
    });
}
updateToolbarState();

// Slug
const titleInput = document.getElementById('title');
const slugInput  = document.getElementById('slug');
const slugPreview= document.getElementById('slugPreview');
let slugEdited   = slugInput.value !== '';

function toSlug(str) {
    return str.toLowerCase().trim()
        .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-')
        .replace(/-+/g, '-').replace(/^-+|-+$/g, '');
}
titleInput.addEventListener('input', function() {
    if (!slugEdited) { slugInput.value = toSlug(this.value); updateSlugPreview(); }
});
slugInput.addEventListener('input', function() { slugEdited = true; updateSlugPreview(); });
function updateSlugPreview() {
    slugPreview.textContent = '/blog/' + (slugInput.value || 'your-post-slug');
}
updateSlugPreview();

// Excerpt counter
const excerptEl = document.getElementById('excerpt');
const charCount = document.getElementById('charCount');
function updateCounter() {
    const rem = 500 - excerptEl.value.length;
    charCount.textContent = rem + ' characters remaining';
    charCount.style.color = rem < 60 ? '#e07a72' : '#7a7060';
}
excerptEl.addEventListener('input', updateCounter);
updateCounter();

// Status → published_at
const statusEl        = document.getElementById('statusField');
const publishedAtWrap = document.getElementById('publishedAtWrap');
function togglePublishedAt() {
    publishedAtWrap.style.display = statusEl.value === 'scheduled' ? 'block' : 'none';
}
statusEl.addEventListener('change', togglePublishedAt);
togglePublishedAt();

// Image preview
const imgInput   = document.getElementById('featuredImage');
const imgPreview = document.getElementById('imgPreview');
if (imgInput) {
    imgInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => { imgPreview.src = e.target.result; imgPreview.style.display = 'block'; };
        reader.readAsDataURL(file);
    });
}

window.removeExistingImage = function() {
    document.getElementById('existingImgWrap').style.display = 'none';
    document.getElementById('keepImage').value = '0';
    document.getElementById('uploadZoneWrap').style.display = 'block';
};

// Draft button
document.querySelector('button[name="_draft"]')?.addEventListener('click', function() {
    document.getElementById('statusField').value = 'draft';
});
</script>
@endpush
