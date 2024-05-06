<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\deliveryMan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OrderDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = order::where('status_user', 0)->latest()->get();
        $men = deliveryMan::all();
        return view('admin.ordersDelivery.index', compact('orders', 'men'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id =  Crypt::decrypt($id);
        $order = order::findOrFail($id);
        try {
            $order->update([
                'delivery' => $request->delivery,
                'status_user' => 1,
            ]);
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
            toast('حدث خطأ غير متوقع', 'error');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
