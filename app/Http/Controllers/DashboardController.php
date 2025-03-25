<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function customers()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function suppliers()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function products()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function orders()
    {

        return view('orders.index');
    }
}