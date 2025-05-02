@extends('layouts.app')

@section('title', 'My Profile - Sellify')

@section('content')
<div class="profile-card">
    <div class="profile-header">
        <h2>My Profile</h2>
    </div>

    <div class="profile-info">
        <div class="info-row">
            <div class="info-label">Name:</div>
            <div class="info-value">{{ $user->name }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value">{{ $user->email }}</div>
        </div>

        @if($user->phone)
        <div class="info-row">
            <div class="info-label">Phone:</div>
            <div class="info-value">{{ $user->phone }}</div>
        </div>
        @endif

        @if($user->address)
        <div class="info-row">
            <div class="info-label">Address:</div>
            <div class="info-value">{{ $user->address }}</div>
        </div>
        @endif

        <div class="info-row">
            <div class="info-value">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 32px;
        box-shadow: var(--shadow-md);
        max-width: 800px;
        margin: 0 auto;
    }

    .profile-header {
        margin-bottom: 32px;
        text-align: center;
    }

    .profile-header h2 {
        color: var(--text-primary);
        font-size: 1.8rem;
        margin-bottom: 8px;
    }

    .profile-info {
        display: grid;
        gap: 24px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 16px;
        padding: 16px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        transition: var(--transition);
    }

    .info-row:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .info-label {
        color: var(--text-secondary);
        font-weight: 500;
    }

    .info-value {
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .info-row {
            grid-template-columns: 1fr;
            gap: 8px;
        }
    }
</style>
@endpush 