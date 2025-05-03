<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        try {
            if (!Auth::check()) {
                Log::error('Dashboard access attempt without authentication');
                return redirect()->route('login')->with('error', 'Please login to access the dashboard.');
            }

            $user = Auth::user();
            
            // Log user details for debugging
            Log::info('Dashboard access attempt', [
                'user_id' => $user->id ?? 'null',
                'user_name' => $user->name ?? 'null',
                'is_admin' => $user->isAdmin() ? 'true' : 'false',
                'auth_check' => Auth::check() ? 'true' : 'false'
            ]);
            
            if (!$user || !$user->isAdmin()) {
                Log::error('Unauthorized dashboard access attempt', [
                    'user_id' => $user->id ?? 'null',
                    'user_name' => $user->name ?? 'null',
                    'is_admin' => $user->isAdmin() ? 'true' : 'false'
                ]);
                return redirect()->route('home')->with('error', 'Unauthorized access. Admin privileges required.');
            }

            // Initialize default values
            $data = [
                'user' => $user,
                'totalProducts' => 0,
                'totalOrders' => 0,
                'totalUsers' => 0,
                'todaySales' => 0,
                'monthlySales' => 0,
                'yearlySales' => 0,
                'orderStatuses' => [],
                'lowStockProducts' => collect(),
                'recentOrders' => collect(),
                'monthlySalesData' => []
            ];

            // Log the data being passed to the view
            Log::info('Dashboard data being passed to view:', [
                'user_exists' => isset($data['user']),
                'user_name' => $data['user']->name ?? 'null',
                'user_id' => $data['user']->id ?? 'null'
            ]);

            try {
                // Basic statistics without cache first
                $data['totalProducts'] = Product::count();
                $data['totalOrders'] = Order::count();
                $data['totalUsers'] = User::where('is_admin', false)->count();
            } catch (\Exception $e) {
                Log::error('Error fetching basic statistics: ' . $e->getMessage());
            }

            try {
                // Sales Statistics
                $today = Carbon::today();
                $data['todaySales'] = Order::whereDate('created_at', $today)
                    ->where('status', '!=', 'cancelled')
                    ->sum('total') ?? 0;
                    
                $data['monthlySales'] = Order::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->where('status', '!=', 'cancelled')
                    ->sum('total') ?? 0;
                    
                $data['yearlySales'] = Order::whereYear('created_at', Carbon::now()->year)
                    ->where('status', '!=', 'cancelled')
                    ->sum('total') ?? 0;
            } catch (\Exception $e) {
                Log::error('Error fetching sales statistics: ' . $e->getMessage());
            }

            try {
                // Order Status Counts
                $data['orderStatuses'] = Order::select('status', DB::raw('count(*) as count'))
                    ->groupBy('status')
                    ->get()
                    ->pluck('count', 'status')
                    ->toArray();
            } catch (\Exception $e) {
                Log::error('Error fetching order statuses: ' . $e->getMessage());
            }

            try {
                // Low Stock Products
                $data['lowStockProducts'] = Product::where('stock', '<', 10)
                    ->where('active', true)
                    ->orderBy('stock', 'asc')
                    ->take(5)
                    ->get();
            } catch (\Exception $e) {
                Log::error('Error fetching low stock products: ' . $e->getMessage());
            }

            try {
                // Recent Orders
                $data['recentOrders'] = Order::with(['user'])
                    ->where('status', '!=', 'cancelled')
                    ->latest()
                    ->take(5)
                    ->get();
            } catch (\Exception $e) {
                Log::error('Error fetching recent orders: ' . $e->getMessage());
            }

            try {
                // Monthly Sales Data
                $data['monthlySalesData'] = Order::select(
                        DB::raw('MONTH(created_at) as month'),
                        DB::raw('SUM(total) as total')
                    )
                    ->whereYear('created_at', Carbon::now()->year)
                    ->where('status', '!=', 'cancelled')
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get()
                    ->pluck('total', 'month')
                    ->toArray();
            } catch (\Exception $e) {
                Log::error('Error fetching monthly sales data: ' . $e->getMessage());
            }

            return view('admin.dashboard', $data);
        } catch (\Exception $e) {
            // Log the error with more details
            Log::error('Dashboard Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return view with error message and default data
            return view('admin.dashboard', [
                'error' => 'There was an error loading the dashboard data. Please try again later.',
                'totalProducts' => 0,
                'totalOrders' => 0,
                'totalUsers' => 0,
                'todaySales' => 0,
                'monthlySales' => 0,
                'yearlySales' => 0,
                'orderStatuses' => [],
                'lowStockProducts' => collect(),
                'recentOrders' => collect(),
                'monthlySalesData' => []
            ]);
        }
    }
} 