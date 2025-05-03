<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>{{ config('app.name', 'Sellify') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 24px;
            padding-top: 100px;
        }

        /* Navbar */
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

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
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
            color: var(--text-primary);
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .logout-button {
            color: var(--text-primary);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.05);
        }

        .logout-button:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--primary-color);
        }

        /* Card Styles */
        .card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            text-align: left;
            padding: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .table td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .table tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Status Badge */
        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-badge.completed {
            background: rgba(0, 191, 166, 0.1);
            color: var(--primary-color);
        }

        .status-badge.processing {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .status-badge.cancelled {
            background: rgba(244, 67, 54, 0.1);
            color: #f44336;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-image">
            <span class="sidebar-logo-text">Sellify Admin</span>
        </a>

        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Main</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home icon"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box icon"></i>
                    Products
                </a>
                <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart icon"></i>
                    Orders
                </a>
            </div>
        </nav>

        <div class="user-menu">
            <div class="user-avatar">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="user-details">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <div class="navbar">
            <div class="navbar-right">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Page Content -->
        {{ $slot }}
    </div>
</body>
</html> 