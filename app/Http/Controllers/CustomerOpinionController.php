<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerOpinion;
use Illuminate\Support\Facades\Crypt;

class CustomerOpinionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opinions = CustomerOpinion::latest()->get();

        return view('admin.opinions.index', compact('opinions'));
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
    public function show(CustomerOpinion $customerOpinion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerOpinion $customerOpinion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerOpinion $customerOpinion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $id =  Crypt::decrypt($id);
            $city = CustomerOpinion::findOrFail($id);
            $city->destroy($id);
            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
