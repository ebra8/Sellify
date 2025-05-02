@extends('layouts.app')

@section('title', 'Edit Profile - Sellify')

@section('content')
<div class="profile-container">
    <div class="profile-form">
        <div class="form-header">
            <h2>Edit Profile</h2>
            <p class="subtitle">Update your personal information</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h3 class="section-title">Personal Information</h3>
                
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required>
                    </div>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required>
                    </div>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <div class="input-group">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="tel" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', $user->phone) }}">
                    </div>
                    @error('phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <div class="input-group">
                        <i class="fas fa-map-marker-alt input-icon"></i>
                        <input type="text" 
                               class="form-control @error('address') is-invalid @enderror" 
                               id="address" 
                               name="address" 
                               value="{{ old('address', $user->address) }}">
                    </div>
                    @error('address')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">Change Password</h3>
                <p class="section-description">Leave password fields empty if you don't want to change it</p>

                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password">
                    </div>
                    @error('current_password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password" class="form-label">New Password</label>
                    <div class="input-group">
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" 
                               class="form-control @error('new_password') is-invalid @enderror" 
                               id="new_password" 
                               name="new_password">
                    </div>
                    @error('new_password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                    <div class="input-group">
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" 
                               class="form-control" 
                               id="new_password_confirmation" 
                               name="new_password_confirmation">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .profile-form {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 32px;
        box-shadow: var(--shadow-md);
    }

    .form-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .form-header h2 {
        color: var(--text-primary);
        font-size: 2rem;
        margin-bottom: 8px;
    }

    .subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .form-section {
        margin-bottom: 40px;
    }

    .section-title {
        color: var(--text-primary);
        font-size: 1.4rem;
        margin-bottom: 8px;
    }

    .section-description {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 24px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        color: var(--text-secondary);
    }

    .form-control {
        width: 100%;
        padding: 12px 16px 12px 48px;
        background: var(--background-light);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: var(--text-primary);
        font-size: 1rem;
        transition: var(--transition);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 191, 166, 0.1);
    }

    .form-control.is-invalid {
        border-color: #ff4757;
    }

    .invalid-feedback {
        display: block;
        color: #ff4757;
        font-size: 0.875rem;
        margin-top: 8px;
    }

    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-success {
        background: rgba(0, 191, 166, 0.1);
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
    }

    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: var(--primary-color);
        color: var(--text-primary);
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-save:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .profile-form {
            padding: 24px;
        }

        .form-header h2 {
            font-size: 1.8rem;
        }
    }
</style>
@endpush 