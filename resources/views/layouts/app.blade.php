<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>@yield('title', 'Sellify')</title>
    <style>
        :root {
            --primary-color: #00BFA6;
            --primary-dark: #009e88;
            --primary-light: #e0f7f4;
            --background-dark: #101c1d;
            --background-light: #223838;
            --text-primary: #ffffff;
            --text-secondary: #bfe6e0;
            --card-bg: rgba(22, 38, 38, 0.35);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.12);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.18);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: var(--background-dark);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: var(--card-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 24px 0;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: 32px;
            margin-bottom: 32px;
            padding: 8px 16px;  
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            transition: var(--transition);
            text-decoration: none;
        }

        .logo-image {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .sidebar-logo:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }

        .sidebar-logo-text {
            color: var(--primary-color);
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 4px;
            margin-bottom: 16px;
        }

        .menu-section {
            padding: 8px 16px;
            margin-bottom: 8px;
        }

        .menu-section-title {
            color: var(--text-secondary);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            padding-left: 8px;
        }

        .sidebar-link {
            color: var(--text-primary);
            text-decoration: none;
            font-size: 1rem;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 8px;
            transition: var(--transition);
            margin: 0 16px;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background: var(--background-light);
            transform: translateX(4px);
        }

        .sidebar-link .icon {
            font-size: 1.2rem;
            color: var(--primary-color);
            width: 24px;
            text-align: center;
        }

        /* User Menu Styles */
        .user-menu {
            margin-top: auto;
            width: 100%;
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            margin-bottom: 16px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            z-index: 120;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 20px 32px;
            background: rgba(13, 33, 33, 0.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-search {
            position: relative;
            width: 400px;
            margin-left: auto;
        }

        .search-input {
            background: var(--background-light);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 14px 24px 14px 48px;
            color: var(--text-primary);
            font-size: 1.1rem;
            width: 100%;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 191, 166, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .nav-icon {
            color: var(--text-primary);
            font-size: 1.2rem;
            padding: 8px;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
        }

        .nav-icon:hover {
            background: var(--background-light);
            color: var(--primary-color);
        }

        .nav-icon .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--primary-color);
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 100px 32px 32px;
            width: calc(100% - 280px);
        }

        /* Common Table Styles */
        .table {
            width: 100%;
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .table th {
            background: rgba(255, 255, 255, 0.05);
            font-weight: 500;
            color: var(--text-secondary);
        }

        /* Common Button Styles */
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--text-primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #ff4757;
            color: var(--text-primary);
        }

        .btn-danger:hover {
            background: #ff6b81;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--background-light);
            color: var(--text-primary);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Badge Styles */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-success {
            background: var(--primary-color);
            color: var(--text-primary);
        }

        .badge-warning {
            background: #ffa502;
            color: var(--text-primary);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
            }

            .sidebar-logo-text,
            .sidebar-link span,
            .menu-section-title {
                display: none;
            }

            .sidebar-link {
                justify-content: center;
                padding: 12px;
                margin: 0 8px;
            }

            .navbar {
                left: 80px;
            }

            .main-content {
                margin-left: 80px;
                width: calc(100% - 80px);
            }

            .navbar-search {
                width: 200px;
            }

            .logo-image {
                width: 32px;
                height: 32px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .navbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .navbar-search {
                display: none;
            }
        }

        .sidebar-link.text-danger {
            color: #ff4757 !important;
            transition: var(--transition);
        }

        .sidebar-link.text-danger:hover {
            background: rgba(255, 71, 87, 0.1) !important;
            color: #ff4757 !important;
        }

        .logo-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .logo-container i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .logo-letter {
            position: absolute;
            color: var(--text-primary);
            font-weight: bold;
            font-size: 1.2rem;
        }

        @media (max-width: 1024px) {
            .logo-container {
                width: 32px;
                height: 32px;
            }

            .logo-container i {
                font-size: 1.5rem;
            }

            .logo-letter {
                font-size: 1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('home') }}" class="sidebar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Sellify Logo" class="logo-image">
            <span class="sidebar-logo-text">Sellify</span>
        </a>

        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Menu</div>
                <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home icon"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('products.index') }}" class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag icon"></i>
                    <span>Products</span>
                </a>
                <a href="{{ route('categories.index') }}" class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags icon"></i>
                    <span>Categories</span>
                </a>
                <a href="{{ route('about') }}" class="sidebar-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    <i class="fas fa-info-circle icon"></i>
                    <span>About Us</span>
                </a>
            </div>

            @auth
                <div class="menu-section">
                    <div class="menu-section-title">Account</div>
                    <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i class="fas fa-user icon"></i>
                        <span>Profile</span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="sidebar-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart icon"></i>
                    <span>Cart</span>
                    </a>
                    <a href="{{ route('orders.index') }}" class="sidebar-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="fas fa-box icon"></i>
                        <span>Orders</span>
                    </a>
                </div>
            @endauth
        </nav>

        @auth
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">Customer</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="sidebar-link text-danger" style="width: 100%; text-align: left; background: none; border: none; padding: 12px 24px;">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        @else
            <div class="user-menu">
                <a href="{{ route('login') }}" class="sidebar-link">
                    <i class="fas fa-sign-in-alt icon"></i>
                    <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="sidebar-link">
                    <i class="fas fa-user-plus icon"></i>
                    <span>Register</span>
                </a>
            </div>
        @endauth
    </aside>

    <!-- Navbar -->
    <nav class="navbar">
        <form action="{{ route('products.search') }}" method="GET" class="navbar-search">
            <i class="fas fa-search search-icon"></i>
            <input type="text" 
                   name="query" 
                   class="search-input" 
                   placeholder="Search products..."
                   value="{{ request('query') }}"
                   required>
        </form>
        <div class="navbar-right">
            @auth
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html> 