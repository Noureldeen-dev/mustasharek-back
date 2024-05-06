<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\product;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PreProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $PreProducts = product::latest()->get();
        $sections = section::latest()->get();
        return view('admin.PreProducts.index', compact('PreProducts','sections'));
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
                'section' => 'required',
                'price' => 'required',
                'price2' => 'required',
                'count' => 'required',
                'category' => 'required',
                'desc' => 'required',
                'color' => 'required'
            ],[
                'name.required' => 'الإسم مطلوب',
                'section.required' => 'القسم مطلوب',
                'price.required' => 'السعر مطلوب',
                'price2.required' => 'السعر الأخر مطلوب',
                'count.required' => 'العدد مطلوب',
                'category.required' => 'الفئة مطلوبة',
                'desc.required' => 'التفاصيل مطلوبة',
                'color.required' => 'اللون مطلوبة',
            ]);
            $valid['pic'] = "000";
            product::create($valid);
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $PreProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $PreProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $id = Crypt::decrypt($id);
        try {
            $PreProduct = product::findOrFail($id);
            $valid = $request->validate([
                'name' => 'required',
                'section' => 'required',
                'price' => 'required',
                'price2' => 'required',
                'count' => 'required',
                'category' => 'required',
                'desc' => 'required',
                'color' => 'required',
            ],[
                'name.required' => 'الإسم مطلوب',
                'section.required' => 'القسم مطلوب',
                'price.required' => 'السعر مطلوب',
                'price2.required' => 'السعر الأخر مطلوب',
                'count.required' => 'العدد مطلوب',
                'category.required' => 'الفئة مطلوبة',
                'desc.required' => 'التفاصيل مطلوبة',
                'color.required' => 'اللون مطلوبة',
            ]);
            $PreProduct->update($valid);
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        try {
            $id =  Crypt::decrypt($id);
            $PreProduct = product::findOrFail($id);
            $PreProduct->destroy($id);
            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
