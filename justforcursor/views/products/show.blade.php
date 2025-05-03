@extends('layouts.app')

@section('title', $product->name . ' - Sellify')

@section('content')
    <div class="product-detail">
        <div class="product-grid">
            <div class="product-image-container">
                <img src="{{ asset('storage/' . $product->image) }}" 
                     class="product-main-image" 
                     alt="{{ $product->name }}"
                     onerror="this.src='{{ asset('images/default-product.jpg') }}'">
            </div>
            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-meta">
                    <a href="{{ route('categories.show', $product->category->slug) }}" class="product-category">
                        {{ $product->category->name }}
                    </a>
                    <div class="product-stock {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </div>
        </div>
                <div class="product-price">${{ number_format($product->price, 2) }}</div>
            
                <div class="product-description">
                    <h3>Description</h3>
                <p>{{ $product->description }}</p>
            </div>

                @if($product->stock > 0)
                    <form action="{{ route('cart.update') }}" method="POST" class="product-form" id="addToCartForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn" onclick="decrementQuantity()">-</button>
                            <span 
                                   class="quantity-display" 
                                   data-value="1" 
                                   data-max="{{ $product->stock }}" 
                                   id="quantity">1</span>
                            <input type="hidden" name="quantity" id="quantityInput" value="1">
                            <button type="button" class="quantity-btn" onclick="incrementQuantity()">+</button>
                        </div>
                        <button type="submit" class="btn-add-to-cart">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </form>
                @else
                    <div class="out-of-stock-message">
                        <p>This product is currently out of stock. Please check back later.</p>
                    </div>
                @endif
                
                <div class="additional-info">
                    <div class="info-item">
                        <i class="fas fa-truck"></i>
                        <span>Free delivery on orders over $50</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-undo"></i>
                        <span>30-day return policy</span>
            </div>
                    <div class="info-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure payment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .product-detail {
        padding: 0 20px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }

    .product-image-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        background: var(--card-bg);
    }

    .product-main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .product-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .product-title {
        margin: 0;
        font-size: 2rem;
        color: var(--text-primary);
    }

    .product-meta {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .product-category {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 1rem;
        padding: 5px 10px;
        background: rgba(0, 191, 166, 0.1);
        border-radius: 20px;
        transition: var(--transition);
    }

    .product-category:hover {
        background: rgba(0, 191, 166, 0.2);
    }

    .product-stock {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .in-stock {
        background: rgba(0, 191, 166, 0.1);
        color: var(--primary-color);
    }

    .out-of-stock {
        background: rgba(255, 71, 87, 0.1);
        color: #ff4757;
    }

    .product-price {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .product-description {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px;
    }

    .product-description h3 {
        margin-top: 0;
        margin-bottom: 10px;
        color: var(--text-primary);
        font-size: 1.2rem;
    }

    .product-description p {
        margin: 0;
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .product-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        max-width: 200px;
        border-radius: 10px;
        overflow: hidden;
        background: var(--card-bg);
    }

    .quantity-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--background-light);
        border: none;
        color: var(--text-primary);
        font-size: 1.2rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .quantity-btn:hover {
        background: var(--primary-color);
    }

    .quantity-display {
        flex: 1;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: var(--text-primary);
        background: var(--background-light);
        user-select: none;
    }

    .btn-add-to-cart {
        padding: 15px 30px;
        background: var(--primary-color);
        color: var(--text-primary);
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: var(--transition);
    }

    .btn-add-to-cart:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .out-of-stock-message {
        padding: 15px;
        background: rgba(255, 71, 87, 0.1);
        border-radius: 10px;
        color: #ff4757;
    }

    .additional-info {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-item i {
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    @media (max-width: 992px) {
        .product-grid {
            grid-template-columns: 1fr;
        }

        .product-image-container {
            height: 400px;
        }
    }

    @media (max-width: 768px) {
        .product-image-container {
            height: 350px;
        }

        .product-title {
            font-size: 1.8rem;
        }

        .product-price {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 480px) {
        .product-image-container {
            height: 250px;
        }
        
        .product-title {
            font-size: 1.5rem;
        }

        .product-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .product-price {
            font-size: 1.6rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function incrementQuantity() {
        const display = document.getElementById('quantity');
        const input = document.getElementById('quantityInput');
        const max = parseInt(display.dataset.max);
        const currentValue = parseInt(display.dataset.value);
        if (currentValue < max) {
            const newValue = currentValue + 1;
            display.dataset.value = newValue;
            display.textContent = newValue;
            input.value = newValue;
        }
    }

    function decrementQuantity() {
        const display = document.getElementById('quantity');
        const input = document.getElementById('quantityInput');
        const currentValue = parseInt(display.dataset.value);
        if (currentValue > 1) {
            const newValue = currentValue - 1;
            display.dataset.value = newValue;
            display.textContent = newValue;
            input.value = newValue;
        }
    }

    // Add to cart functionality
    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitBtn = form.querySelector('.btn-add-to-cart');
        const originalBtnText = submitBtn.innerHTML;
        
        // Disable button and show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        
        // Create FormData and explicitly set the quantity
        const formData = new FormData(form);
        const quantity = document.getElementById('quantity').dataset.value;
        formData.set('quantity', quantity);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Show success notification
            showNotification('Product added to cart successfully!');
            
            // Update cart count
            updateCartCount();
            
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error adding product to cart. Please try again.', 'error');
            
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        // Add styles
        notification.style.position = 'fixed';
        notification.style.bottom = '20px';
        notification.style.right = '20px';
        notification.style.padding = '12px 24px';
        notification.style.background = type === 'success' ? 'var(--primary-color)' : '#ff4757';
        notification.style.color = '#fff';
        notification.style.borderRadius = '8px';
        notification.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        notification.style.zIndex = '1000';
        notification.style.animation = 'slideIn 0.3s ease';
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const cartCounts = document.querySelectorAll('.cart-count');
                cartCounts.forEach(count => {
                    count.textContent = data.count;
                    count.style.display = data.count > 0 ? 'block' : 'none';
                });
            });
    }

    // Add keyframe animations for notifications
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush