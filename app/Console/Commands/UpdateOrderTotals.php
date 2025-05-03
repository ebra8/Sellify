<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class UpdateOrderTotals extends Command
{
    protected $signature = 'orders:update-totals';
    protected $description = 'Update total amounts for all orders';

    public function handle()
    {
        $orders = Order::with('orderProducts')->get();
        $bar = $this->output->createProgressBar(count($orders));
        
        foreach ($orders as $order) {
            $order->calculateTotal();
            $bar->advance();
        }
        
        $bar->finish();
        $this->info("\nOrder totals have been updated successfully!");
    }
} 