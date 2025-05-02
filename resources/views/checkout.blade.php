@extends('layouts.app')

@section('title', 'Checkout - Sellify')

@section('content')
    <div class="checkout-container">
        <h1 class="checkout-title">Checkout</h1>

        @if((auth()->check() && $cart->cartProducts->count() > 0) || (!auth()->check() && count($cart) > 0))
            <div class="checkout-content">
                <div class="checkout-main">
                    <!-- Shipping Information -->
                    <div class="checkout-section">
                        <div class="section-header">
                            <h2><i class="fas fa-shipping-fast"></i> Shipping Information</h2>
                        </div>
                        <div class="section-content">
                            @if(auth()->check() && auth()->user()->addresses->count() > 0)
                                <div class="saved-addresses">
                                    <h3>Saved Addresses</h3>
                                    <div class="address-list">
                                        @foreach(auth()->user()->addresses as $address)
                                            <div class="address-card">
                                                <input type="radio" 
                                                       name="shipping_address" 
                                                       id="address_{{ $address->id }}" 
                                                       value="{{ $address->id }}"
                                                       {{ $loop->first ? 'checked' : '' }}>
                                                <label for="address_{{ $address->id }}">
                                                    <div class="address-details">
                                                        <p class="address-name">{{ $address->first_name }} {{ $address->last_name }}</p>
                                                        <p class="address-street">{{ $address->address }}</p>
                                                        <p class="address-city">{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</p>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="btn-add-address" onclick="showNewAddressForm()">
                                        <i class="fas fa-plus"></i> Add New Address
                                    </button>
                                </div>
                            @endif

                            <form id="shipping-form" class="shipping-form" {{ auth()->check() && auth()->user()->addresses->count() > 0 ? 'style=display:none' : '' }}>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" id="first_name" name="first_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" id="city" name="city" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" id="state" name="state" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="zip_code">ZIP Code</label>
                                        <input type="text" id="zip_code" name="zip_code" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="checkout-section">
                        <div class="section-header">
                            <h2><i class="fas fa-credit-card"></i> Payment Information</h2>
                        </div>
                        <div class="section-content">
                            <form id="payment-form" class="payment-form">
                                <div class="form-group">
                                    <label for="card_number">Card Number</label>
                                    <div class="card-input">
                                        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
                                        <div class="card-icons">
                                            <i class="fab fa-cc-visa"></i>
                                            <i class="fab fa-cc-mastercard"></i>
                                            <i class="fab fa-cc-amex"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="expiry">Expiry Date</label>
                                        <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" name="cvv" placeholder="123" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="checkout-sidebar">
                    <!-- Order Summary -->
                    <div class="checkout-section">
                        <div class="section-header">
                            <h2><i class="fas fa-receipt"></i> Order Summary</h2>
                        </div>
                        <div class="section-content">
                            <div class="order-items">
                                @if(auth()->check())
                                    @foreach($cart->cartProducts as $item)
                                        <div class="order-item">
                                            <div class="item-image">
                                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                     alt="{{ $item->product->name }}">
                                            </div>
                                            <div class="item-details">
                                                <h4>{{ $item->product->name }}</h4>
                                                <p class="item-quantity">Qty: {{ $item->qty }}</p>
                                                <p class="item-price">${{ number_format($item->product->price * $item->qty, 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach($cart as $item)
                                        <div class="order-item">
                                            <div class="item-image">
                                                <img src="{{ asset('storage/' . $item['product']->image) }}" 
                                                     alt="{{ $item['product']->name }}">
                                            </div>
                                            <div class="item-details">
                                                <h4>{{ $item['product']->name }}</h4>
                                                <p class="item-quantity">Qty: {{ $item['quantity'] }}</p>
                                                <p class="item-price">${{ number_format($item['product']->price * $item['quantity'], 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="order-summary">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="summary-row">
                                    <span>Shipping</span>
                                    <span>Free</span>
                                </div>
                                <div class="summary-row">
                                    <span>Tax</span>
                                    <span>${{ number_format($total * 0.1, 2) }}</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total</span>
                                    <span>${{ number_format($total + ($total * 0.1), 2) }}</span>
                                </div>
                            </div>

                            <button class="btn-place-order" onclick="placeOrder()">
                                Place Order
                                <i class="fas fa-lock"></i>
                            </button>

                            <div class="secure-checkout">
                                <i class="fas fa-shield-alt"></i>
                                <p>Secure Checkout</p>
                            </div>
                        </div>
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
    .checkout-container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .checkout-title {
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 30px;
    }

    .checkout-content {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 30px;
    }

    .checkout-section {
        background: var(--card-bg);
        border-radius: 16px;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .section-header {
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .section-header h2 {
        font-size: 1.5rem;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-content {
        padding: 20px;
    }

    /* Shipping Information Styles */
    .saved-addresses {
        margin-bottom: 20px;
    }

    .saved-addresses h3 {
        font-size: 1.2rem;
        color: var(--text-primary);
        margin-bottom: 15px;
    }

    .address-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 20px;
    }

    .address-card {
        position: relative;
        padding: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
    }

    .address-card:hover {
        border-color: var(--primary-color);
    }

    .address-card input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .address-card input[type="radio"]:checked + label {
        color: var(--primary-color);
    }

    .address-card input[type="radio"]:checked + label .address-details {
        border-color: var(--primary-color);
    }

    .address-details {
        padding-left: 30px;
    }

    .address-name {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .address-street,
    .address-city {
        color: var(--text-secondary);
        margin: 0;
        font-size: 0.9rem;
    }

    .btn-add-address {
        width: 100%;
        padding: 12px;
        background: var(--background-light);
        color: var(--text-primary);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: var(--transition);
    }

    .btn-add-address:hover {
        background: var(--background-hover);
    }

    /* Form Styles */
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--text-primary);
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        background: var(--background-light);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: var(--text-primary);
        transition: var(--transition);
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    /* Payment Form Styles */
    .card-input {
        position: relative;
    }

    .card-icons {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        gap: 10px;
        color: var(--text-secondary);
    }

    /* Order Summary Styles */
    .order-items {
        margin-bottom: 20px;
    }

    .order-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .item-image img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .item-details h4 {
        margin: 0 0 5px 0;
        font-size: 1rem;
        color: var(--text-primary);
    }

    .item-quantity {
        color: var(--text-secondary);
        margin: 0 0 5px 0;
        font-size: 0.9rem;
    }

    .item-price {
        color: var(--primary-color);
        font-weight: 600;
        margin: 0;
    }

    .order-summary {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        color: var(--text-secondary);
    }

    .summary-row.total {
        color: var(--text-primary);
        font-size: 1.2rem;
        font-weight: 600;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-place-order {
        width: 100%;
        padding: 15px;
        background: var(--primary-color);
        color: var(--text-primary);
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
        transition: var(--transition);
    }

    .btn-place-order:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .secure-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 15px;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .secure-checkout i {
        color: var(--primary-color);
    }

    /* Empty Cart Styles */
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
        .checkout-content {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function showNewAddressForm() {
        document.querySelector('.saved-addresses').style.display = 'none';
        document.getElementById('shipping-form').style.display = 'block';
    }

    function placeOrder() {
        // Get form data
        const shippingForm = document.getElementById('shipping-form');
        const paymentForm = document.getElementById('payment-form');
        
        // Show loading state
        const orderButton = document.querySelector('.btn-place-order');
        orderButton.disabled = true;
        orderButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        
        // Prepare data
        const formData = new FormData();
        
        // Add shipping data
        if (shippingForm.style.display !== 'none') {
            formData.append('first_name', document.getElementById('first_name').value);
            formData.append('last_name', document.getElementById('last_name').value);
            formData.append('address', document.getElementById('address').value);
            formData.append('city', document.getElementById('city').value);
            formData.append('state', document.getElementById('state').value);
            formData.append('zip_code', document.getElementById('zip_code').value);
        } else {
            const selectedAddress = document.querySelector('input[name="shipping_address"]:checked');
            formData.append('address_id', selectedAddress.value);
        }
        
        // Add payment data
        formData.append('card_number', document.getElementById('card_number').value);
        formData.append('expiry', document.getElementById('expiry').value);
        formData.append('cvv', document.getElementById('cvv').value);
        
        // Send request
        fetch('{{ route("checkout.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification('Order placed successfully!', 'success');
                
                // Redirect to order confirmation
                window.location.href = data.redirect_url;
            } else {
                throw new Error(data.message || 'Error placing order');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification(error.message || 'Error placing order. Please try again.', 'error');
            
            // Reset button state
            orderButton.disabled = false;
            orderButton.innerHTML = 'Place Order <i class="fas fa-lock"></i>';
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

    // Format card number input
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        let formattedValue = '';
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) {
                formattedValue += ' ';
            }
            formattedValue += value[i];
        }
        e.target.value = formattedValue;
    });

    // Format expiry date input
    document.getElementById('expiry').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 2) {
            value = value.slice(0, 2) + '/' + value.slice(2, 4);
        }
        e.target.value = value;
    });

    // Format CVV input
    document.getElementById('cvv').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 3);
    });
</script>
@endpush