<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $statuses = [2, 3, 4, 5];
        $num_customers = User::whereHas('orders', function ($query) use ($statuses) {
            $query->whereIn('status', $statuses);
        })->get()->count();
        $num_products = Product::all()->count();
        $revenue = Order::whereIn('status', $statuses)->sum('total_price');
        $sales = round($revenue / Order::whereIn('status', $statuses)->count(), 2);
        //dd($revenue, $num_customers, $sales, $num_products);
        return view('admin.index', compact('revenue', 'num_customers', 'sales', 'num_products'));
    }
}