@extends('layouts.app')

@section('title', 'Dashboard - Sellify')

@section('content')
<div class="dashboard-container">
    <div class="section-header">
        <h1>Dashboard</h1>
        <p>Welcome to your dashboard</p>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-content">
                <h3>Recent Orders</h3>
                <p>View your recent orders and track their status</p>
                <a href="{{ route('orders.index') }}" class="btn btn-primary">View Orders</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="card-content">
                <h3>Profile Settings</h3>
                <p>Manage your account settings and preferences</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-heart"></i>
            </div>
            <div class="card-content">
                <h3>Wishlist</h3>
                <p>View and manage your saved items</p>
                <a href="#" class="btn btn-primary">View Wishlist</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-header h1 {
        color: var(--text-primary);
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .section-header p {
        color: var(--text-secondary);
        font-size: 1.1rem;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .dashboard-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        transition: var(--transition);
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .card-icon {
        width: 60px;
        height: 60px;
        background: var(--background-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .card-icon i {
        font-size: 1.8rem;
        color: var(--primary-color);
    }

    .card-content h3 {
        color: var(--text-primary);
        font-size: 1.4rem;
        margin-bottom: 10px;
    }

    .card-content p {
        color: var(--text-secondary);
        margin-bottom: 20px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        background: var(--primary-color);
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
    }

    .btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush 