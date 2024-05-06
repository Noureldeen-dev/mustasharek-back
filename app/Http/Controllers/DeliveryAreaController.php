<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\city;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DeliveryAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = city::where('status', 1)->latest()->get();
        return view('admin.areas.index', compact('cities'));
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
            'name' => 'required',
            'price' => 'required',
            'city' => 'required',
        ], [
            'name.required' => 'الإسم مطلوب',
            'price.required' => 'السعر مطلوب',
            'city.required' => 'المدينة مطلوبة',
        ]);
        try {
            DeliveryArea::create($valid);
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryArea $deliveryArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryArea $deliveryArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $id = Crypt::decrypt($id);
        $valid = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'city' => 'required'
        ], [
            'name.required' => 'الإسم مطلوب',
            'price.required' => 'السعر مطلوب',
            'city.required' => 'المدينة مطلوبة',
        ]);
        try {
            $area = DeliveryArea::findOrFail($id);
            $area->update($valid);
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
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
            $city = DeliveryArea::findOrFail($id);
            $city->destroy($id);
            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
