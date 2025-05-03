@extends('layouts.app')

@section('title', 'Cart - Sellify')

@section('content')
    <div class="cart-container">
        <h1 class="cart-title">Shopping Cart</h1>

        @if((auth()->check() && $cart->cartProducts->count() > 0) || (!auth()->check() && count($cart) > 0))
            <div class="cart-content">
                <div class="cart-items">
                    @if(auth()->check())
                        @foreach($cart->cartProducts as $item)
                            <div class="cart-item" data-product-id="{{ $item->product->id }}">
                                <div class="cart-item-image">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}">
                                </div>
                                <div class="cart-item-details">
                                    <h3 class="cart-item-title">{{ $item->product->name }}</h3>
                                    <p class="cart-item-description">{{ Str::limit($item->product->description, 100) }}</p>
                                    <div class="cart-item-price">${{ number_format($item->product->price, 2) }}</div>
                                </div>
                                <div class="cart-item-quantity">
                                    <div class="quantity-controls">
                                        <button type="button" class="quantity-btn" onclick="decrementQuantity(this)">-</button>
                                        <span 
                                               class="quantity-display" 
                                               data-value="{{ $item->qty }}" 
                                               data-max="{{ $item->product->stock }}"
                                               data-product-id="{{ $item->product->id }}"
                                               data-price="{{ $item->product->price }}">{{ $item->qty }}</span>
                                        <button type="button" class="quantity-btn" onclick="incrementQuantity(this)">+</button>
                                    </div>
                                </div>
                                <div class="cart-item-total">
                                    ${{ number_format($item->product->price * $item->qty, 2) }}
                                </div>
                                <button class="cart-item-remove" onclick="removeItem(this)" data-product-id="{{ $item->product->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    @else
                        @foreach($cart as $item)
                            <div class="cart-item" data-product-id="{{ $item['product']->id }}">
                                <div class="cart-item-image">
                                    <img src="{{ asset('storage/' . $item['product']->image) }}" 
                                         alt="{{ $item['product']->name }}">
                                </div>
                                <div class="cart-item-details">
                                    <h3 class="cart-item-title">{{ $item['product']->name }}</h3>
                                    <p class="cart-item-description">{{ Str::limit($item['product']->description, 100) }}</p>
                                    <div class="cart-item-price">${{ number_format($item['product']->price, 2) }}</div>
                                </div>
                                <div class="cart-item-quantity">
                                    <div class="quantity-controls">
                                        <button type="button" class="quantity-btn" onclick="decrementQuantity(this)">-</button>
                                        <span 
                                               class="quantity-display" 
                                               data-value="{{ $item['quantity'] }}" 
                                               data-max="{{ $item['product']->stock }}"
                                               data-product-id="{{ $item['product']->id }}"
                                               data-price="{{ $item['product']->price }}">{{ $item['quantity'] }}</span>
                                        <button type="button" class="quantity-btn" onclick="incrementQuantity(this)">+</button>
                                    </div>
                                </div>
                                <div class="cart-item-total">
                                    ${{ number_format($item['product']->price * $item['quantity'], 2) }}
                                </div>
                                <button class="cart-item-remove" onclick="removeItem(this)" data-product-id="{{ $item['product']->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="cart-summary">
                    <div class="cart-summary-header">
                        <h2>Order Summary</h2>
                    </div>
                    <div class="cart-summary-content">
                        <div class="cart-summary-row">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="cart-summary-row">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div class="cart-summary-row total">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    <div class="cart-summary-actions">
                        <a href="{{ route('products.index') }}" class="btn-continue-shopping">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                        <button class="btn-clear-cart" onclick="clearCart()">
                            <i class="fas fa-trash"></i> Clear Cart
                        </button>
                        <a href="{{ route('checkout') }}" class="btn-checkout">
                            Proceed to Checkout <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="btn-start-shopping">
                    Start Shopping <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>
@endsection

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
        display: grid;
        grid-template-columns: 100px 1fr auto auto auto;
        gap: 20px;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cart-item:last-child {
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
        font-size: 1.2rem;
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

    .cart-item-quantity {
        display: flex;
        align-items: center;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        background: var(--background-light);
        border-radius: 8px;
        overflow: hidden;
    }

    .quantity-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--background-light);
        border: none;
        color: var(--text-primary);
        font-size: 1.1rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .quantity-btn:hover {
        background: var(--primary-color);
    }

    .quantity-display {
        width: 50px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: var(--text-primary);
        background: var(--background-light);
        user-select: none;
    }

    .cart-item-total {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .cart-item-remove {
        background: none;
        border: none;
        color: #ff4757;
        cursor: pointer;
        font-size: 1.1rem;
        padding: 8px;
        border-radius: 8px;
        transition: var(--transition);
    }

    .cart-item-remove:hover {
        background: rgba(255, 71, 87, 0.1);
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

    .cart-summary-row.total {
        color: var(--text-primary);
        font-size: 1.2rem;
        font-weight: 600;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cart-summary-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-continue-shopping,
    .btn-clear-cart,
    .btn-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px;
        border-radius: 8px;
        font-size: 1rem;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .btn-continue-shopping {
        background: var(--background-light);
        color: var(--text-primary);
    }

    .btn-continue-shopping:hover {
        background: var(--background-hover);
    }

    .btn-clear-cart {
        background: rgba(255, 71, 87, 0.1);
        color: #ff4757;
    }

    .btn-clear-cart:hover {
        background: rgba(255, 71, 87, 0.2);
    }

    .btn-checkout {
        background: var(--primary-color);
        color: var(--text-primary);
    }

    .btn-checkout:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .empty-cart {
        text-align: center;
        padding: 60px 20px;
        background: var(--card-bg);
        border-radius: 16px;
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: var(--text-secondary);
        margin-bottom: 20px;
    }

    .empty-cart h2 {
        font-size: 1.8rem;
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
        color: var(--text-primary);
        text-decoration: none;
        border-radius: 8px;
        transition: var(--transition);
    }

    .btn-start-shopping:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .cart-content {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 80px 1fr;
            gap: 15px;
        }

        .cart-item-image img {
            width: 80px;
            height: 80px;
        }

        .cart-item-quantity,
        .cart-item-total,
        .cart-item-remove {
            grid-column: 2;
        }

        .cart-item-quantity {
            justify-content: flex-start;
        }

        .cart-item-total {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function incrementQuantity(button) {
        const display = button.parentElement.querySelector('.quantity-display');
        const max = parseInt(display.dataset.max);
        const currentValue = parseInt(display.dataset.value);
        if (currentValue < max) {
            display.dataset.value = currentValue + 1;
            display.textContent = currentValue + 1;
            updateQuantity(display);
        }
    }

    function decrementQuantity(button) {
        const display = button.parentElement.querySelector('.quantity-display');
        const currentValue = parseInt(display.dataset.value);
        if (currentValue > 1) {
            display.dataset.value = currentValue - 1;
            display.textContent = currentValue - 1;
            updateQuantity(display);
        }
    }

    function updateQuantity(display) {
        const productId = display.dataset.productId;
        const quantity = display.dataset.value;
        const cartItem = display.closest('.cart-item');
        const price = parseFloat(display.dataset.price);
        
        // Show loading state
        cartItem.style.opacity = '0.5';
        cartItem.style.pointerEvents = 'none';
        
        fetch('{{ route("cart.update-quantity") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                // Update total using the stored price
                const total = price * quantity;
                cartItem.querySelector('.cart-item-total').textContent = `$${total.toFixed(2)}`;
                
                // Update cart count
                updateCartCount();
                
                // Show notification
                showNotification('Cart updated successfully');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating cart. Please try again.', 'error');
        })
        .finally(() => {
            // Remove loading state
            cartItem.style.opacity = '1';
            cartItem.style.pointerEvents = 'auto';
        });
    }

    function removeItem(button) {
        const productId = button.dataset.productId;
        const cartItem = button.closest('.cart-item');
        
        // Show loading state
        cartItem.style.opacity = '0.5';
        cartItem.style.pointerEvents = 'none';
        
        fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                // Remove item with animation
                cartItem.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    cartItem.remove();
                    
                    // If no items left, reload page to show empty cart
                    if (document.querySelectorAll('.cart-item').length === 0) {
                        location.reload();
                    }
                }, 300);
                
                // Update cart count
                updateCartCount();
                
                // Show notification
                showNotification('Item removed from cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error removing item. Please try again.', 'error');
            
            // Remove loading state
            cartItem.style.opacity = '1';
            cartItem.style.pointerEvents = 'auto';
        });
    }

    function clearCart() {
        if (!confirm('Are you sure you want to clear your cart?')) {
            return;
        }
        
        // Show loading state
        document.querySelector('.cart-items').style.opacity = '0.5';
        document.querySelector('.cart-items').style.pointerEvents = 'none';
        
        fetch('{{ route("cart.clear") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                // Reload page to show empty cart
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error clearing cart. Please try again.', 'error');
            
            // Remove loading state
            document.querySelector('.cart-items').style.opacity = '1';
            document.querySelector('.cart-items').style.pointerEvents = 'auto';
        });
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

    // Add keyframe animations
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