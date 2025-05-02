@extends('layouts.app')

@section('title', 'About Us - Sellify')

@section('content')
    <div class="about-container">
        <div class="about-header">
            <h1>About Sellify</h1>
            <p class="subtitle">Your trusted marketplace for quality products</p>
        </div>

        <div class="about-grid">
            <div class="about-section">
                <div class="icon-wrapper">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h2>Our Mission</h2>
                <p>To provide a seamless and enjoyable shopping experience, connecting quality products with passionate customers.</p>
            </div>

            <div class="about-section">
                <div class="icon-wrapper">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2>Security First</h2>
                <p>Your security is our priority. We use industry-leading technology to protect your data and transactions.</p>
            </div>

            <div class="about-section">
                <div class="icon-wrapper">
                    <i class="fas fa-truck"></i>
                </div>
                <h2>Fast Delivery</h2>
                <p>We partner with reliable shipping services to ensure your products reach you quickly and safely.</p>
            </div>

            <div class="about-section">
                <div class="icon-wrapper">
                    <i class="fas fa-heart"></i>
                </div>
                <h2>Customer Focus</h2>
                <p>Our dedicated support team is always ready to help you with any questions or concerns.</p>
            </div>
        </div>

        <div class="about-features">
            <h2>Why Choose Sellify?</h2>
            <div class="features-list">
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>Quality guaranteed products</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>Secure payment methods</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>30-day return policy</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>24/7 customer support</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .about-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .about-header h1 {
        font-size: 2.5rem;
        color: var(--text-primary);
        margin-bottom: 15px;
    }

    .subtitle {
        font-size: 1.2rem;
        color: var(--text-secondary);
    }

    .about-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
    }

    .about-section {
        background: var(--card-bg);
        padding: 30px;
        border-radius: 16px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .about-section:hover {
        transform: translateY(-5px);
    }

    .icon-wrapper {
        width: 70px;
        height: 70px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .icon-wrapper i {
        font-size: 1.8rem;
        color: var(--text-primary);
    }

    .about-section h2 {
        font-size: 1.4rem;
        color: var(--text-primary);
        margin-bottom: 15px;
    }

    .about-section p {
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .about-features {
        background: var(--card-bg);
        padding: 40px;
        border-radius: 16px;
        text-align: center;
    }

    .about-features h2 {
        font-size: 1.8rem;
        color: var(--text-primary);
        margin-bottom: 30px;
    }

    .features-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-primary);
    }

    .feature-item i {
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .about-header h1 {
            font-size: 2rem;
        }

        .about-features {
            padding: 30px 20px;
        }

        .features-list {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush 