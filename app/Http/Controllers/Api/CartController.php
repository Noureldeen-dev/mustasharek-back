<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user->cart) {        
            $user->cart()->save(new Cart());            
            $user->load('cart');
        }
        
        $exists = $user->cart->products->contains($request->id);
        if ($exists) {
            $user->cart->products()->updateExistingPivot($request->id, ['quantity' => $request->quantity]);
        } else {
            $user->cart->products()->attach($request->id,
                [
                    'quantity' => $request->quantity,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة المنتج للسلة بنجاح',
            'order' => $user->cart->load('products'),
        ], 200);        
    }
}
