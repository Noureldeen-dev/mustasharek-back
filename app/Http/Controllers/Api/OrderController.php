<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getOrderWithProducts($user_id)
    {
        $order = Order::where('user', $user_id)
            ->with(['products' => function ($query) {
                $query->select( 'products.name');
            }])
            ->get();

        return response()->json($order);
    }
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        $items = $user->cart->products;
        $order = new order();
        $order->user = $user->id;
        $order->save();

        foreach ($items as $item) {
            $order->products()->attach($item->id,
                [
                    'quantity' => $item->orderd->quantity,
                    'price' => $item->price,
                    'total' => $item->orderd->quantity * $item->price,
                ]
            );
        }

        if (!$order->products()->count()) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في انشاء الطلب',
            ], 400);
        }

        $user->cart->clear();
        return response()->json([
            'success' => true,
            'message' => 'تم انشاء الطلب بنجاح',
            'order' => $order->load('products'),
        ], 200);


    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
