@extends('layouts.app')

@section('title', 'Search Results - Sellify')

@section('content')
    <div class="search-container">
        <div class="search-header">
            <h1>Search Results</h1>
            <p class="search-subtitle">Found {{ $products->total() }} results for "{{ $query }}"</p>
            
            @if($category || $minPrice || $maxPrice || $sort != 'relevance')
                <div class="active-filters">
                    <span class="active-filters-label">Active Filters:</span>
                    @if($category)
                        <span class="filter-tag">
                            Category: {{ $categories->firstWhere('slug', $category)->name }}
                            <a href="{{ route('products.search', array_merge(request()->except('category'), ['query' => $query])) }}" class="remove-filter">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                    @if($minPrice || $maxPrice)
                        <span class="filter-tag">
                            Price: ${{ $minPrice ?? '0' }} - ${{ $maxPrice ?? '∞' }}
                            <a href="{{ route('products.search', array_merge(request()->except(['min_price', 'max_price']), ['query' => $query])) }}" class="remove-filter">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                    @if($sort != 'relevance')
                        <span class="filter-tag">
                            Sort: {{ ucfirst(str_replace('_', ' ', $sort)) }}
                            <a href="{{ route('products.search', array_merge(request()->except('sort'), ['query' => $query])) }}" class="remove-filter">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                    <a href="{{ route('products.search', ['query' => $query]) }}" class="clear-filters">
                        Clear All Filters
                    </a>
                </div>
            @endif
        </div>

        <div class="search-content">
            <div class="search-filters">
                <div class="filters-card">
                    <div class="filters-header">
                        <h3>Filters</h3>
                        <button class="filters-toggle" onclick="toggleFilters()">
                            <i class="fas fa-sliders-h"></i>
                        </button>
                    </div>
                    <form action="{{ route('products.search') }}" method="GET" class="filters-form" id="filtersForm">
                        <input type="hidden" name="query" value="{{ $query }}">
                        
                        <div class="filter-group">
                            <label>Category</label>
                            <select name="category" class="filter-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ $category == $cat->slug ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Price Range</label>
                            <div class="price-range">
                                <div class="price-input-group">
                                    <span class="price-currency">$</span>
                                    <input type="number" 
                                           name="min_price" 
                                           class="filter-input price-input" 
                                           placeholder="0"
                                           value="{{ $minPrice }}"
                                           min="0">
                                </div>
                                <span class="price-separator">to</span>
                                <div class="price-input-group">
                                    <span class="price-currency">$</span>
                                    <input type="number" 
                                           name="max_price" 
                                           class="filter-input price-input" 
                                           placeholder="∞"
                                           value="{{ $maxPrice }}"
                                           min="0">
                                </div>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label>Sort By</label>
                            <select name="sort" class="filter-select">
                                <option value="relevance" {{ $sort == 'relevance' ? 'selected' : '' }}>Relevance</option>
                                <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Newest First</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                    </form>
                </div>
            </div>

            <div class="search-results">
                @forelse($products as $product)
                    <div class="product-card">
                        <a href="{{ route('products.show', $product->slug) }}" class="product-link">
                            <div class="product-image">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}"
                                     onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                @if($product->stock <= 0)
                                    <div class="out-of-stock-badge">Out of Stock</div>
                                @endif
                            </div>
                            <div class="product-info">
                                <h3>{{ $product->name }}</h3>
                                <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                                <p class="product-price">${{ number_format($product->price, 2) }}</p>
                                <div class="product-meta">
                                    <span class="product-stock {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                    </span>
                                    @if($product->stock > 0)
                                        <span class="product-quantity">
                                            {{ $product->stock }} available
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="no-results">
                        <i class="fas fa-search fa-3x"></i>
                        <h2>No Products Found</h2>
                        <p>We couldn't find any products matching your search criteria.</p>
                        <div class="no-results-actions">
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag"></i> Browse All Products
                            </a>
                            <a href="{{ route('products.search', ['query' => $query]) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear Filters
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .search-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .search-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .search-header h1 {
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .search-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .active-filters-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .filter-tag {
        background: var(--background-light);
        color: var(--text-primary);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .remove-filter {
        color: var(--text-secondary);
        text-decoration: none;
        transition: var(--transition);
    }

    .remove-filter:hover {
        color: #ff4757;
    }

    .clear-filters {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .clear-filters:hover {
        color: var(--primary-dark);
    }

    .search-content {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
    }

    .search-filters {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .filters-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--shadow-md);
    }

    .filters-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .filters-header h3 {
        color: var(--text-primary);
        font-size: 1.2rem;
        margin: 0;
    }

    .filters-toggle {
        display: none;
        background: none;
        border: none;
        color: var(--text-secondary);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        transition: var(--transition);
    }

    .filters-toggle:hover {
        background: var(--background-light);
        color: var(--primary-color);
    }

    .filters-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .filter-select,
    .filter-input {
        background: var(--background-light);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 10px 12px;
        color: var(--text-primary);
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .filter-select:focus,
    .filter-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(0, 191, 166, 0.1);
    }

    .price-range {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .price-input-group {
        position: relative;
        flex: 1;
    }

    .price-currency {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .price-input {
        padding-left: 24px !important;
        width: 100%;
    }

    .price-separator {
        color: var(--text-secondary);
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .search-results {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .product-card {
        background: var(--card-bg);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        position: relative;
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
        position: relative;
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

    .out-of-stock-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 71, 87, 0.9);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .product-info {
        padding: 15px;
    }

    .product-info h3 {
        margin: 0 0 10px;
        font-size: 16px;
        color: var(--text-primary);
    }

    .product-description {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 10px;
        line-height: 1.4;
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
        flex-wrap: wrap;
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

    .product-quantity {
        font-size: 12px;
        color: var(--text-secondary);
    }

    .no-results {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: var(--card-bg);
        border-radius: 16px;
    }

    .no-results i {
        color: var(--text-secondary);
        margin-bottom: 20px;
    }

    .no-results h2 {
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .no-results p {
        color: var(--text-secondary);
        margin-bottom: 20px;
    }

    .no-results-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    @media (max-width: 1024px) {
        .search-content {
            grid-template-columns: 240px 1fr;
        }
    }

    @media (max-width: 768px) {
        .search-content {
            grid-template-columns: 1fr;
        }

        .search-filters {
            position: static;
        }

        .filters-toggle {
            display: block;
        }

        .filters-form {
            display: none;
        }

        .filters-form.active {
            display: flex;
        }

        .filters-card {
            margin-bottom: 20px;
        }

        .active-filters {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-tag {
            justify-content: space-between;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleFilters() {
        const form = document.getElementById('filtersForm');
        form.classList.toggle('active');
    }
</script>
@endpush 