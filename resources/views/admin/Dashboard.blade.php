@extends('layouts.admin')

@section('title', 'Dashboard — CryptoOnly Admin')
@section('breadcrumb', 'Dashboard')
@section('page_eyebrow', 'Overview')
@section('page_title', 'Dashboard')

@section('page_actions')
    <a href="{{ url('/admin/reports') }}" class="btn-sm btn-outline-gold">
        <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
        Export Report
    </a>
    <a href="{{ url('/admin/users/create') }}" class="btn-sm btn-gold">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Member
    </a>
@endsection

@section('content')
    @include('admin.partials.dashboard-body')
@endsection
