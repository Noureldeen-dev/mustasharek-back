<?php

namespace App\Http\Controllers;

use App\Models\city;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = city::latest()->get();
        return view('admin.cities.index', compact('cities'));
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
        try {
            $valid = $request->validate([
                'name' => 'required',
                'price' => 'required',
                'status' => 'required|integer'
            ], [
                'name.required' => 'الإسم مطلوب',
                'price.required' => 'السعر مطلوب',
                'status.required' => 'الحالة مطلوبة',
            ]);
            city::create($valid);
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(city $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(city $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $id = Crypt::decrypt($id);
        try {
            $city = city::findOrFail($id);
            $valid = $request->validate([
                'name' => 'required',
                'price' => 'required',
                'status' => 'required|integer'
            ], [
                'name.required' => 'الإسم مطلوب',
                'price.required' => 'السعر مطلوب',
                'status.required' => 'الحالة مطلوبة',
            ]);
            $city->update($valid);
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
            $city = city::findOrFail($id);
            $city->destroy($id);
            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
