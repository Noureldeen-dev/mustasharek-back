<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\order;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController  extends Controller
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

    $request->validate([

        'book_id' => 'required',
        'value' => 'required|numeric',
    ]);
 
   
        $consultation = order::create([
            'user_id' => $user->id,
            'book_id' => $request->book_id,
            'value' => $request->value,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'تم انشاء الطلب بنجاح',
            'consultation' => $consultation,
        ], 201);
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
