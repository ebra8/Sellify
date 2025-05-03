@extends('layouts.app')

@section('title', 'Categories - Sellify')

@section('content')
<div class="categories-container">
    <div class="section-header">
        <h1>Categories</h1>
        <p>Browse our product categories</p>
    </div>

    <div class="categories-grid">
        @forelse($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" class="category-card">
                <div class="category-image">
                    @php
                        $categoryImages = [
                            'electronics' => 'electronics.jpg',
                            'clothing' => 'clothing.jpg',
                            'home & kitchen' => 'home_kitchen.jpg',
                            'books' => 'books.jpg',
                            'sports & outdoors' => 'sports_outdoors.jpg',
                            'watches' => 'watches.jpg',
                            'gears' => 'gears.jpg',
                            'laptops' => 'laptops.png'
                        ];
                        
                        $imageName = strtolower($category->name);
                        $imageFile = isset($categoryImages[$imageName]) ? $categoryImages[$imageName] : 'default.jpg';
                    @endphp
                    <img src="{{ asset('images/categories/' . $imageFile) }}" 
                         alt="{{ $category->name }}"
                         onerror="this.src='{{ asset('images/categories/default.jpg') }}'">
                </div>
                <div class="category-info">
                    <h2>{{ $category->name }}</h2>
                    <div class="category-meta">
                        <span class="product-count">
                            <i class="fas fa-box"></i>
                            {{ $category->products_count ?? 0 }} products
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="no-categories">
                <p>No categories found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    .categories-container {
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

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .category-card {
        background: var(--card-bg);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        text-decoration: none;
        color: var(--text-primary);
        transition: var(--transition);
    }

    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .category-image {
        height: 200px;
        overflow: hidden;
        position: relative;
        background: var(--background-light);
    }

    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-image img {
        transform: scale(1.05);
    }

    .category-info {
        padding: 20px;
        text-align: center;
    }

    .category-info h2 {
        margin: 0 0 10px;
        font-size: 1.4rem;
        color: var(--text-primary);
    }

    .category-meta {
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .product-count {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .product-count i {
        color: var(--primary-color);
    }

    .no-categories {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px;
        background: var(--card-bg);
        border-radius: 16px;
    }

    .no-categories p {
        color: var(--text-secondary);
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .categories-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
    }

    @media (max-width: 480px) {
        .categories-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush 