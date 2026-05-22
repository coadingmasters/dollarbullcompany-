@extends('layouts.admin')

@section('title', 'P2P Registrations — Admin')
@section('breadcrumb', 'P2P Trading')
@section('page_eyebrow', 'Services')
@section('page_title', 'P2P Registrations')

@section('content')
<style>
  .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:14px;margin-bottom:28px}
  .stat{background:var(--bc);border:1px solid var(--bb);padding:16px 20px}
  .stat-n{font-family:Cinzel,serif;font-size:1.6rem;color:var(--white);margin-bottom:4px}
  .stat-l{font-size:.72rem;color:var(--wf);text-transform:uppercase;letter-spacing:.1em;font-family:Cinzel,serif}
  .tbl{width:100%;border-collapse:collapse}
  .tbl th{font-family:Cinzel,serif;font-size:.6rem;letter-spacing:.14em;text-transform:uppercase;color:var(--gold);border-bottom:1px solid var(--bb);padding:10px 12px;text-align:left}
  .tbl td{padding:11px 12px;border-bottom:1px solid rgba(255,255,255,.04);font-size:.85rem;color:var(--wd);vertical-align:middle}
  .tbl tr:hover td{background:rgba(255,255,255,.02)}
  .badge{display:inline-block;padding:3px 10px;font-family:Cinzel,serif;font-size:.55rem;letter-spacing:.12em;text-transform:uppercase;border-radius:2px}
  .badge-pending{background:rgba(234,179,8,.1);border:1px solid rgba(234,179,8,.3);color:#fde047}
  .badge-verified{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#86efac}
  .badge-rejected{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#fca5a5}
  .act-btn{padding:5px 12px;font-family:Cinzel,serif;font-size:.55rem;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;border:1px solid var(--bb);background:none;color:var(--wd);margin-right:4px;text-decoration:none;display:inline-block}
  .act-btn:hover{border-color:var(--gold);color:var(--gold)}
  .act-btn.del{border-color:rgba(239,68,68,.35);color:#fca5a5}
  .act-btn.del:hover{background:rgba(239,68,68,.1)}
  .empty{padding:40px;text-align:center;color:var(--wf);font-style:italic}
  .flash{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#86efac;padding:12px 16px;margin-bottom:20px;font-size:.85rem}
</style>

@if(session('success'))
  <div class="flash">✓ {{ session('success') }}</div>
@endif

<div class="stats">
  <div class="stat"><div class="stat-n">{{ $counts['total'] }}</div><div class="stat-l">Total</div></div>
  <div class="stat"><div class="stat-n" style="color:#fde047">{{ $counts['pending'] }}</div><div class="stat-l">Pending</div></div>
  <div class="stat"><div class="stat-n" style="color:#86efac">{{ $counts['verified'] }}</div><div class="stat-l">Verified</div></div>
  <div class="stat"><div class="stat-n" style="color:#fca5a5">{{ $counts['rejected'] }}</div><div class="stat-l">Rejected</div></div>
</div>

<div class="table-card">
  @if($registrations->isEmpty())
    <p class="empty">No P2P registrations yet.</p>
  @else
    <table class="tbl">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>WhatsApp</th>
          <th>Country</th>
          <th>Exchange</th>
          <th>Submitted</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($registrations as $r)
        <tr>
          <td style="color:var(--wf)">{{ $r->id }}</td>
          <td>{{ $r->first_name }} {{ $r->last_name }}</td>
          <td style="font-size:.8rem">{{ $r->email }}</td>
          <td style="font-size:.8rem">{{ $r->whatsapp_number }}</td>
          <td>{{ $r->country }}</td>
          <td>{{ $r->exchange ?: '—' }}</td>
          <td style="color:var(--wf);font-size:.78rem">{{ $r->created_at->format('d M Y') }}</td>
          <td><span class="badge badge-{{ $r->status }}">{{ ucfirst($r->status) }}</span></td>
          <td>
            <a href="{{ route('admin.p2p.show', $r) }}" class="act-btn">View</a>

            @if($r->status !== 'verified')
              <form method="POST" action="{{ route('admin.p2p.verify', $r) }}" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="act-btn" style="color:#86efac;border-color:rgba(34,197,94,.35)">Verify</button>
              </form>
            @endif

            @if($r->status !== 'rejected')
              <form method="POST" action="{{ route('admin.p2p.reject', $r) }}" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="act-btn" style="color:#fde047;border-color:rgba(234,179,8,.3)">Reject</button>
              </form>
            @endif

            <form method="POST" action="{{ route('admin.p2p.destroy', $r) }}" style="display:inline"
                  onsubmit="return confirm('Delete this registration? This cannot be undone.')">
              @csrf @method('DELETE')
              <button type="submit" class="act-btn del">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@endsection
