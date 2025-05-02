@extends('layouts.app')

@section('title', 'Home - Sellify')

@section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1>Discover Amazing Products</h1>
            <p>Your one-stop shop for quality products at unbeatable prices</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Shop Now</a>
        </div>
    </div>

    <!-- Featured Categories -->
    <section class="section">
        <div class="section-header">
            <h2>Shop by Category</h2>
            <p>Browse our wide range of categories</p>
        </div>
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
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="section section-alt">
        <div class="section-header">
            <h2>Why Choose Us</h2>
            <p>We're committed to providing the best shopping experience</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🚚</div>
                <h3>Fast Shipping</h3>
                <p>Free shipping on orders over $50</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Secure Shopping</h3>
                <p>100% secure payment processing</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>24/7 Support</h3>
                <p>Always here to help you</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">↩️</div>
                <h3>Easy Returns</h3>
                <p>30-day return policy</p>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="section newsletter-section">
        <div class="newsletter-content">
            <h2>Stay Updated</h2>
            <p>Subscribe to our newsletter for exclusive offers and updates</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/images/Back-ground.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin: -1.5rem -1.5rem 2rem -1.5rem;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.4) 100%);
        z-index: 1;
    }

    .hero-content {
        max-width: 800px;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        font-weight: 700;
    }

    .hero-content p {
        font-size: 1.4rem;
        margin-bottom: 2rem;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        opacity: 0.9;
    }

    .hero-content .btn {
        padding: 15px 40px;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hero-content .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    /* Section Styles */
    .section {
        padding: 4rem 0;
    }

    .section-alt {
        background-color: var(--bg-secondary);
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-header h2 {
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .section-header p {
        color: var(--text-secondary);
    }

    /* Categories Grid */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 0 20px;
    }

    .category-card {
        background: var(--card-bg);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        text-decoration: none;
        color: var(--text-primary);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .category-image {
        height: 250px;
        overflow: hidden;
        position: relative;
        background: #f5f5f5;
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
        background: var(--card-bg);
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-info h2 {
        margin: 0;
        font-size: 1.2rem;
        color: var(--text-primary);
        font-weight: 600;
    }

    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        padding: 0 20px;
    }

    .feature-card {
        text-align: center;
        padding: 2rem;
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
    }

    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .feature-card h3 {
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .feature-card p {
        color: var(--text-secondary);
        margin: 0;
    }

    /* Newsletter Section */
    .newsletter-section {
        background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
        color: white;
        text-align: center;
    }

    .newsletter-content {
        max-width: 600px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .newsletter-form {
        display: flex;
        gap: 10px;
        margin-top: 2rem;
    }

    .newsletter-form input {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
    }

    .newsletter-form .btn {
        padding: 12px 24px;
        background: white;
        color: var(--primary-color);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.5rem;
        }

        .categories-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .newsletter-form {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .hero-content h1 {
            font-size: 2rem;
        }

        .categories-grid {
            grid-template-columns: 1fr;
        }

        .features-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
