<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        $sections = section::all();
        return view('admin.categories.index', compact('categories','sections'));
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
        $valid = $request->validate(
            [
                'name' => 'required',
                'section_id' => 'required'
            ],
            [
                'name.required' => 'الإسم مطلوب',
                'section_id.required' => 'القسم مطلوب',
            ]
        );
        try {

            Category::create($valid);            
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {

        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $valid = $request->validate([
            'name' => 'required',
            'section_id' => 'required'
        ], [
            'name.required' => 'الإسم مطلوب',
            'section_id.required' => 'القسم مطلوب',
        ]);
        $id = Crypt::decrypt($id);
        try {
            $category = Category::findOrFail($id);

            $category->update($valid);
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
            $category = Category::findOrFail($id);
            $category->destroy($id);
            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
