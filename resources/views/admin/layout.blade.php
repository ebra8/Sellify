<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .admin-content {
            background-color: #f9fafb;
            color: #1f2937;
        }
        .admin-content h1, .admin-content h2, .admin-content h3 {
            color: #111827;
        }
        .admin-content .text-gray-600 {
            color: #4b5563;
        }
        .admin-content .text-gray-500 {
            color: #6b7280;
        }
        .admin-content .text-gray-900 {
            color: #111827;
        }
        .admin-content .bg-white {
            background-color: #ffffff;
        }
        .admin-content .border-gray-200 {
            border-color: #e5e7eb;
        }
        .admin-content .hover\:bg-gray-50:hover {
            background-color: #f9fafb;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 flex flex-col py-6 px-4">
            <div class="mb-10">
                <span class="text-2xl font-bold text-teal-400 tracking-tight">Sellify Admin</span>
            </div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-gray-700 transition font-medium">Dashboard</a></li>
                    <li><a href="{{ route('admin.products.index') }}" class="block py-2 px-3 rounded hover:bg-gray-700 transition font-medium">Products</a></li>
                    <li><a href="{{ route('admin.orders.index') }}" class="block py-2 px-3 rounded hover:bg-gray-700 transition font-medium">Orders</a></li>
                    <li><a href="{{ route('admin.users.index') }}" class="block py-2 px-3 rounded hover:bg-gray-700 transition font-medium">Users</a></li>
                    <li><a href="{{ route('admin.categories.index') }}" class="block py-2 px-3 rounded hover:bg-gray-700 transition font-medium">Categories</a></li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-gray-800 shadow p-4 flex items-center justify-between">
                <h1 class="text-xl font-semibold tracking-tight">@yield('title', 'Dashboard')</h1>
                <div class="flex items-center gap-4">
                    <span class="text-teal-300 font-medium">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="py-2 px-4 rounded bg-red-600 hover:bg-red-700 text-white font-semibold transition">Logout</button>
                    </form>
                </div>
            </header>
            <!-- Page Content -->
            <main class="flex-1 p-8 admin-content">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html> 