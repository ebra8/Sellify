@extends('layouts.app')

@section('title', 'Resources')

@section('content')
<div class="resources-container">
    <div class="resources-grid">
        <!-- Main Views -->
        <div class="resource-section">
            <h2>Main Views</h2>
            <div class="resource-cards">
                <a href="{{ route('home') }}" class="resource-card">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('about') }}" class="resource-card">
                    <i class="fas fa-info-circle"></i>
                    <span>About</span>
                </a>
                <a href="{{ route('welcome') }}" class="resource-card">
                    <i class="fas fa-door-open"></i>
                    <span>Welcome</span>
                </a>
            </div>
        </div>

        <!-- Shop Views -->
        <div class="resource-section">
            <h2>Shop</h2>
            <div class="resource-cards">
                <a href="{{ route('products.index') }}" class="resource-card">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
                <a href="{{ route('categories.index') }}" class="resource-card">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                </a>
                <a href="{{ route('cart.index') }}" class="resource-card">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Cart</span>
                </a>
            </div>
        </div>

        <!-- User Views -->
        <div class="resource-section">
            <h2>User</h2>
            <div class="resource-cards">
                <a href="{{ route('profile.edit') }}" class="resource-card">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('address.index') }}" class="resource-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Address</span>
                </a>
                <a href="{{ route('orders.index') }}" class="resource-card">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Orders</span>
                </a>
            </div>
        </div>

        <!-- Checkout Views -->
        <div class="resource-section">
            <h2>Checkout</h2>
            <div class="resource-cards">
                <a href="{{ route('checkout.index') }}" class="resource-card">
                    <i class="fas fa-credit-card"></i>
                    <span>Checkout</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
:root {
    --bg-color: #0a0a0a;
    --card-bg: #1a1a1a;
    --text-color: #ffffff;
    --accent-color: #6366f1;
}

body {
    background-color: var(--bg-color);
    color: var(--text-color);
    margin: 0;
    padding: 0;
    height: 100vh;
    overflow: hidden;
}

.resources-container {
    height: 100vh;
    padding: 1rem;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
}

.resources-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    width: 100%;
    max-width: 1400px;
    align-items: start;
}

.resource-section {
    background: var(--card-bg);
    border-radius: 0.5rem;
    padding: 1rem;
}

.resource-section h2 {
    font-size: 1rem;
    margin: 0 0 1rem 0;
    color: var(--accent-color);
    font-weight: 500;
}

.resource-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
    gap: 0.5rem;
}

.resource-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 0.5rem;
    text-decoration: none;
    color: var(--text-color);
    transition: all 0.2s;
}

.resource-card:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.resource-card i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: var(--accent-color);
}

.resource-card span {
    font-size: 0.875rem;
    text-align: center;
}

@media (max-width: 1024px) {
    .resources-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .resources-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush 