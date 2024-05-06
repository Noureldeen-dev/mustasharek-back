<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\product;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $price=10;
        $MonthPrice=10;
       /*
        $today = Carbon::today();
        $sales = Order::whereDate('created_at', $today)
            ->where('status_user', 2)
            ->pluck('product');
        $price = Product::whereIn('id', $sales)->sum('price');


        $currentMonth = Carbon::now()->format('m');
        $MonthSales = Order::whereMonth('created_at', $currentMonth)
            ->where('status_user', 2)
            ->pluck('product');
        $MonthPrice = Product::whereIn('id', $MonthSales)->sum('price');
        */


        return view('admin.dashboard', compact('price', 'MonthPrice'));
    }
}
