@extends('layouts.app')

@section('title', 'Categories - Sellify')

@section('content')
    <h1>Browse Categories</h1>

    <div class="categories-grid">
        @foreach($categories as $category)
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
                    <p class="product-count">{{ $category->products_count ?? 0 }} products</p>
                </div>
            </a>
        @endforeach
    </div>
@endsection

@push('styles')
<style>
    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: var(--text-primary);
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
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
        padding: 15px;
        text-align: center;
    }

    .category-info h2 {
        margin: 0;
        font-size: 18px;
        color: var(--text-primary);
    }

    .product-count {
        margin: 8px 0 0;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    @media (max-width: 768px) {
        .categories-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .categories-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush 