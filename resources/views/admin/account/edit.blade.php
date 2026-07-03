@extends('layouts.admin')

@section('title', 'My Account — Admin')
@section('breadcrumb', 'My Account')
@section('page_eyebrow', 'System')
@section('page_title', 'Account & Password')

@push('styles')
<style>
.account-wrap{max-width:640px}
.account-card{
    background:var(--bc);border:1px solid var(--bb);border-radius:3px;
    padding:26px 28px;margin-bottom:20px;
}
.account-card h2{
    font-family:'Cinzel',serif;font-size:.8rem;letter-spacing:.12em;text-transform:uppercase;
    color:var(--white);margin-bottom:4px;display:flex;align-items:center;gap:10px;
}
.account-card h2::before{
    content:'';display:block;width:3px;height:15px;
    background:linear-gradient(180deg,var(--gold-light),var(--gold));border-radius:2px;
}
.account-card p.hint{color:var(--wf);font-size:.82rem;margin-bottom:20px}
.form-row{margin-bottom:16px}
.form-row label{
    display:block;font-family:'Cinzel',serif;font-size:.58rem;letter-spacing:.12em;
    text-transform:uppercase;color:var(--gold);margin-bottom:7px;
}
.form-row input{
    width:100%;padding:11px 13px;background:var(--black);border:1px solid var(--bb);
    color:var(--wd);font-family:inherit;font-size:.92rem;border-radius:2px;transition:border-color .2s;
}
.form-row input:focus{outline:none;border-color:var(--gold)}
.form-row .field-hint{font-size:.75rem;color:var(--wf);margin-top:5px}
.account-actions{display:flex;gap:12px;align-items:center;margin-top:8px}
.pw-divider{border:none;border-top:1px solid var(--bb);margin:22px 0}
</style>
@endpush

@section('content')
<div class="account-wrap">
    <form method="POST" action="{{ route('admin.account.update') }}" autocomplete="off">
        @csrf
        @method('PATCH')

        {{-- ── Profile ── --}}
        <div class="account-card">
            <h2>Profile</h2>
            <p class="hint">Update the name and email you use to sign in to the admin panel.</p>

            <div class="form-row">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
            </div>

            <div class="form-row">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
            </div>
        </div>

        {{-- ── Password ── --}}
        <div class="account-card">
            <h2>Change Password</h2>
            <p class="hint">Set a new password below. Leave these blank if you only want to update your profile.</p>

            <div class="form-row">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" autocomplete="new-password" placeholder="••••••••">
                <div class="field-hint">Minimum 8 characters.</div>
            </div>

            <div class="form-row">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="••••••••">
            </div>

            <hr class="pw-divider">

            <div class="form-row">
                <label for="current_password">Current Password <span style="color:#e07b73">*</span></label>
                <input type="password" id="current_password" name="current_password" autocomplete="current-password" placeholder="Enter your current password to confirm" required>
                <div class="field-hint">Required to save any changes on this page.</div>
            </div>
        </div>

        <div class="account-actions">
            <button type="submit" class="btn-sm btn-gold">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Save Changes
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn-sm btn-outline-gold">Cancel</a>
        </div>
    </form>
</div>
@endsection
