<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderProducts.product']);

        // Search functionality
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                // Search by order ID
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }
                
                // Search by customer details
                $q->orWhereHas('user', function($q) use ($search) {
                    $q->where(function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                    });
                });

                // Search by order total
                if (is_numeric(str_replace(['$', ','], '', $search))) {
                    $q->orWhere('total', 'like', "%" . str_replace(['$', ','], '', $search) . "%");
                }

                // Search by order date
                try {
                    $date = \Carbon\Carbon::parse($search);
                    $q->orWhereDate('created_at', $date->format('Y-m-d'));
                } catch (\Exception $e) {
                    // Invalid date format, ignore
                }
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        // Recalculate totals for orders with missing totals
        foreach ($orders as $order) {
            if (!$order->total || $order->total == 0) {
                $order->calculateTotal();
            }
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderProducts.product']);

        // Recalculate total if missing
        if (!$order->total || $order->total == 0) {
            $order->calculateTotal();
        }

        // Validate order
        if (!$order->validateOrder()) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order #' . $order->id . ' has invalid items. Please check the order details.');
        }

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        try {
            DB::beginTransaction();

            // Record history if status changed
            if ($order->status !== $validated['status']) {
                $order->history()->create([
                    'status' => $validated['status'],
                    'note' => 'Status updated from ' . ucfirst($order->status) . ' to ' . ucfirst($validated['status'])
                ]);
            }

            $order->update($validated);

            // Recalculate total if missing
            if (!$order->total || $order->total == 0) {
                $order->calculateTotal();
            }

            DB::commit();

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Order status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating order status: ' . $e->getMessage());
            
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Failed to update order status. Please try again.');
        }
    }
} 