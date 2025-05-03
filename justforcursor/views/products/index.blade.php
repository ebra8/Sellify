@extends('layouts.app')

@section('title', 'Products - Sellify')

@section('content')
    <div class="products-header">
        <h1>All Products</h1>
        @if(isset($category))
            <p class="subtitle">Browse products in {{ $category->name }}</p>
        @endif
    </div>

    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card">
                <a href="{{ route('products.show', $product->slug) }}" class="product-link">
                    <div class="product-image">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}"
                             onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                    </div>
                    <div class="product-info">
                        <h3>{{ $product->name }}</h3>
                        <p class="product-price">${{ number_format($product->price, 2) }}</p>
                        <div class="product-meta">
                            <span class="product-stock {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="no-products">
                <p>No products available at the moment.</p>
                <a href="{{ route('categories.index') }}" class="btn btn-primary">Browse Categories</a>
            </div>
        @endforelse
    </div>
@endsection 

@push('styles')
<style>
    .products-header {
        text-align: center;
        margin-bottom: 30px;
        padding: 0 20px;
    }

    .products-header h1 {
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 0 20px;
    }

    .product-card {
        background: var(--card-bg);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .product-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .product-image {
        height: 200px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-info {
        padding: 15px;
    }

    .product-info h3 {
        margin: 0 0 10px;
        font-size: 16px;
        color: var(--text-primary);
    }

    .product-price {
        font-size: 18px;
        font-weight: 600;
        color: var(--primary-color);
        margin: 0 0 10px;
    }

    .product-meta {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-stock {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .in-stock {
        background: rgba(0, 191, 166, 0.1);
        color: var(--primary-color);
    }

    .out-of-stock {
        background: rgba(255, 71, 87, 0.1);
        color: #ff4757;
    }

    .no-products {
        text-align: center;
        grid-column: 1 / -1;
        padding: 40px;
        background: var(--card-bg);
        border-radius: 16px;
    }

    .no-products p {
        color: var(--text-secondary);
        margin-bottom: 20px;
    }

    .pagination-container {
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .pagination-info {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .pagination {
        margin-top: 0;
    }

    @media (max-width: 992px) {
        .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush 