@extends('layouts.admin')

@section('title', 'P2P Registration #' . $p2p->id)
@section('breadcrumb', 'P2P Trading')
@section('page_eyebrow', 'P2P Trading')
@section('page_title', $p2p->first_name . ' ' . $p2p->last_name)

@section('page_actions')
  <a href="{{ route('admin.p2p.index') }}" class="btn-sm btn-outline-gold">← All Registrations</a>
@endsection

@section('content')
<style>
  .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}
  @media(max-width:700px){.detail-grid{grid-template-columns:1fr}}
  .dcard{background:var(--bc);border:1px solid var(--bb);padding:24px}
  .dcard-title{font-family:Cinzel,serif;font-size:.6rem;letter-spacing:.16em;text-transform:uppercase;color:var(--gold);margin-bottom:16px;padding-bottom:10px;border-bottom:1px solid var(--bb)}
  .drow{display:flex;gap:12px;margin-bottom:12px;font-size:.86rem}
  .dlabel{color:var(--wf);min-width:120px;font-size:.78rem;font-style:italic}
  .dval{color:var(--wd)}
  .badge{display:inline-block;padding:4px 14px;font-family:Cinzel,serif;font-size:.6rem;letter-spacing:.12em;text-transform:uppercase}
  .badge-pending{background:rgba(234,179,8,.1);border:1px solid rgba(234,179,8,.3);color:#fde047}
  .badge-verified{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#86efac}
  .badge-rejected{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#fca5a5}
  .act-btn{padding:9px 20px;font-family:Cinzel,serif;font-size:.6rem;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;border:1px solid var(--bb);background:none;color:var(--wd);text-decoration:none;display:inline-block;margin-right:8px}
  .act-btn:hover{border-color:var(--gold);color:var(--gold)}
  .flash{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#86efac;padding:12px 16px;margin-bottom:20px;font-size:.85rem}
</style>

@if(session('success'))
  <div class="flash">✓ {{ session('success') }}</div>
@endif

<div class="detail-grid">

  {{-- Info --}}
  <div class="dcard">
    <div class="dcard-title">Registration Details</div>
    <div class="drow"><span class="dlabel">Full Name</span><span class="dval">{{ $p2p->first_name }} {{ $p2p->last_name }}</span></div>
    <div class="drow"><span class="dlabel">Email</span><span class="dval">{{ $p2p->email }}</span></div>
    <div class="drow"><span class="dlabel">WhatsApp</span><span class="dval">{{ $p2p->whatsapp_number }}</span></div>
    <div class="drow"><span class="dlabel">Country</span><span class="dval">{{ $p2p->country }}</span></div>
    <div class="drow"><span class="dlabel">Exchange</span><span class="dval">{{ $p2p->exchange ?: '—' }}</span></div>
    <div class="drow"><span class="dlabel">Submitted</span><span class="dval">{{ $p2p->created_at->format('d M Y, g:i A') }}</span></div>
    <div class="drow"><span class="dlabel">Status</span><span class="badge badge-{{ $p2p->status }}">{{ ucfirst($p2p->status) }}</span></div>
  </div>

  {{-- Payment Screenshot --}}
  <div class="dcard">
    <div class="dcard-title">Payment Screenshot</div>
    @if($p2p->payment_screenshot)
      <a href="{{ Storage::disk('public')->url($p2p->payment_screenshot) }}" target="_blank">
        <img src="{{ Storage::disk('public')->url($p2p->payment_screenshot) }}"
             alt="Payment proof"
             style="width:100%;max-height:320px;object-fit:contain;border:1px solid var(--bb);background:#0a0a0a">
      </a>
      <p style="font-size:.75rem;color:var(--wf);margin-top:8px">Click image to open full size</p>
    @else
      <p style="color:var(--wf);font-style:italic">No screenshot uploaded.</p>
    @endif
  </div>
</div>

{{-- Actions --}}
<div style="margin-top:24px;display:flex;gap:10px;flex-wrap:wrap">
  @if($p2p->status !== 'verified')
    <form method="POST" action="{{ route('admin.p2p.verify', $p2p) }}" style="display:inline">
      @csrf @method('PATCH')
      <button type="submit" class="act-btn" style="color:#86efac;border-color:rgba(34,197,94,.4)">✓ Mark Verified</button>
    </form>
  @endif

  @if($p2p->status !== 'rejected')
    <form method="POST" action="{{ route('admin.p2p.reject', $p2p) }}" style="display:inline">
      @csrf @method('PATCH')
      <button type="submit" class="act-btn" style="color:#fde047;border-color:rgba(234,179,8,.35)">✕ Reject</button>
    </form>
  @endif

  <form method="POST" action="{{ route('admin.p2p.destroy', $p2p) }}" style="display:inline"
        onsubmit="return confirm('Delete this registration permanently?')">
    @csrf @method('DELETE')
    <button type="submit" class="act-btn" style="color:#fca5a5;border-color:rgba(239,68,68,.35)">🗑 Delete</button>
  </form>
</div>
@endsection
