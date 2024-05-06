<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::latest()->get();

        return view('admin.coupons.index', compact('coupons'));
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
        $valid = $request->validate([
            'price' => 'required|numeric',
        ]);
        try {
            $valid['code'] = uniqid();
            Coupon::create($valid);
            toast('تمت الاضافة بنجاح', 'success');
        } catch (Exception $e) {
            toast('حدث خطأ', 'error');
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $valid = $request->validate([
            'price' => 'required|numeric',
        ]);
        $id = Crypt::decrypt($id);
        try {
            $Coupon = Coupon::findOrFail($id);
            $Coupon->update($valid);
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $id =  Crypt::decrypt($id);
            $city = Coupon::findOrFail($id);
            $city->destroy($id);
            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
