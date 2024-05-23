<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BookCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookcategories = BookCategory::latest()->get();
        return view('admin.bookCategory.index', compact('bookcategories'));
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
            ],
            [
                'name.required' => 'الإسم مطلوب',
            ]
        );
        try {

            $bookcategories = BookCategory::create($valid);
           
            $bookcategories->save();
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {

        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
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
        ], [
            'name.required' => 'الإسم مطلوب',
        ]);
        $id = Crypt::decrypt($id);
        try {
            $bookcategories = BookCategory::findOrFail($id);
            
            $bookcategories->update($valid);
          
            $section->save();
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
            $bookcategories = BookCategory::findOrFail($id);
            $bookcategories->destroy($id);

            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
