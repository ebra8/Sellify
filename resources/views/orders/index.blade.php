@extends('layouts.app')

@section('title', 'My Orders - Sellify')

@section('content')
<div class="cart-container">
    <h1 class="cart-title">My Orders</h1>

    @if($orders->isEmpty())
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h2>No Orders Yet</h2>
            <p>You haven't placed any orders yet. Start shopping to see your orders here.</p>
            <a href="{{ route('products.index') }}" class="btn-start-shopping">
                Start Shopping <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    @else
        <div class="cart-content">
            <div class="cart-items">
                @foreach($orders as $index => $order)
                    <div class="cart-item">
                        <div class="cart-item-header">
                            <div class="order-info">
                                <h3 class="order-number">Order #{{ $orders->count() - $index }}</h3>
                                <p class="order-date">{{ $order->created_at->format('F d, Y') }}</p>
                            </div>
                            <span class="badge bg-{{ $order->status_color }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        
                        @foreach($order->orderProducts as $item)
                            <div class="cart-item-content">
                                <div class="cart-item-image">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}">
                                </div>
                                <div class="cart-item-details">
                                    <h3 class="cart-item-title">{{ $item->product->name }}</h3>
                                    <p class="cart-item-description">{{ Str::limit($item->product->description, 100) }}</p>
                                    <div class="cart-item-price">${{ number_format($item->price, 2) }}</div>
                                </div>
                                <div class="cart-item-quantity">
                                    <div class="quantity-display">
                                        Qty: {{ $item->qty }}
                                    </div>
                                </div>
                                <div class="cart-item-total">
                                    ${{ number_format($item->price * $item->qty, 2) }}
                                </div>
                            </div>
                        @endforeach

                        @if($order->address)
                            <div class="order-address">
                                <h4>Shipping Address</h4>
                                @php
                                    $addressDetails = json_decode($order->address->details, true);
                                @endphp
                                <p>
                                    {{ $addressDetails['first_name'] }} {{ $addressDetails['last_name'] }}<br>
                                    {{ $addressDetails['address'] }}<br>
                                    {{ $addressDetails['city'] }}, {{ $addressDetails['state'] }} {{ $addressDetails['zip_code'] }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <div class="cart-summary-header">
                    <h2>Order Summary</h2>
                </div>
                <div class="cart-summary-content">
                    <div class="cart-summary-row">
                        <span>Total Orders</span>
                        <span>{{ $orders->count() }}</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Latest Order</span>
                        <span>{{ $orders->first()->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="cart-summary-actions">
                    <a href="{{ route('products.index') }}" class="btn-continue-shopping">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .cart-container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .cart-title {
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 30px;
    }

    .cart-content {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
    }

    .cart-items {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px;
    }

    .cart-item {
        background: var(--background-light);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .cart-item:last-child {
        margin-bottom: 0;
    }

    .cart-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .order-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .order-number {
        font-size: 1.2rem;
        color: var(--text-primary);
        margin: 0;
    }

    .order-date {
        color: var(--text-secondary);
        margin: 0;
        font-size: 0.9rem;
    }

    .cart-item-content {
        display: grid;
        grid-template-columns: 100px 1fr auto auto;
        gap: 20px;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cart-item-content:last-child {
        border-bottom: none;
    }

    .cart-item-image img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }

    .cart-item-details {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .cart-item-title {
        font-size: 1.1rem;
        color: var(--text-primary);
        margin: 0;
    }

    .cart-item-description {
        color: var(--text-secondary);
        margin: 0;
        font-size: 0.9rem;
    }

    .cart-item-price {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 1.1rem;
    }

    .quantity-display {
        background: var(--background-light);
        padding: 8px 16px;
        border-radius: 8px;
        color: var(--text-primary);
        font-weight: 500;
    }

    .cart-item-total {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .order-address {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .order-address h4 {
        color: var(--text-primary);
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .order-address p {
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.6;
    }

    .cart-summary {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px;
        height: fit-content;
    }

    .cart-summary-header {
        margin-bottom: 20px;
    }

    .cart-summary-header h2 {
        font-size: 1.5rem;
        color: var(--text-primary);
        margin: 0;
    }

    .cart-summary-content {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 30px;
    }

    .cart-summary-row {
        display: flex;
        justify-content: space-between;
        color: var(--text-secondary);
    }

    .cart-summary-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-continue-shopping {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px 24px;
        background: var(--primary-color);
        color: #fff;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-continue-shopping:hover {
        background: var(--primary-color-dark);
        color: #fff;
    }

    .empty-cart {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: var(--text-secondary);
        margin-bottom: 20px;
    }

    .empty-cart h2 {
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .empty-cart p {
        color: var(--text-secondary);
        margin-bottom: 30px;
    }

    .btn-start-shopping {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        background: var(--primary-color);
        color: #fff;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-start-shopping:hover {
        background: var(--primary-color-dark);
        color: #fff;
    }

    .badge {
        padding: 8px 16px;
        font-weight: 500;
        border-radius: 8px;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: #000;
    }

    .bg-info {
        background-color: #0dcaf0 !important;
        color: #000;
    }

    .bg-success {
        background-color: #198754 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }
</style>
@endpush
@endsection 