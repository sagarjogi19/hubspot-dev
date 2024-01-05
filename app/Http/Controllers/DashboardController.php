<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::count();
        $customer = Customer::count();
        $ticket = Ticket::count();

        return view('dashboard.dashboard', [
            'product' => $product,
            'customer' => $customer,
            'ticket' => $ticket
        ]);
    }
}
