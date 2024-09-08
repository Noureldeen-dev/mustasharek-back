<?php

namespace App\Http\Controllers;

use App\Models\ConsultationsCategories;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ConsultationsCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookcategories = ConsultationsCategories::latest()->get();
        return view('admin.consultationsCategories.index', compact('bookcategories'));
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
                'price' => 'required',
                'image' => 'required',
                
            ],
            [
                'name.required' => 'الإسم مطلوب',
                'price.required' => 'السعر مطلوب',
                'image.required' => 'صورة التصنيف مطلوب',
            ]
        );
        try {
     // Handle image upload
     $image = $request->file('image');
     $imageName = $image->getClientOriginalName();
     $imagePath = $image->move(public_path('cocat'), $imageName);
 
 
     $bookcategories = ConsultationsCategories::create(array_merge($valid, [
         'image' => $imageName,
     ]));
 
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
        $valid = $request->validate(
            [
                'name' => 'required',
                'price' => 'required',
            ],
            [
                'name.required' => 'الإسم مطلوب',
                'price.required' => 'السعر مطلوب',
            ]
        );
        $id = Crypt::decrypt($id);
        try {
            $bookcategories = ConsultationsCategories::findOrFail($id);

            if ($request->hasFile('image')) {
               
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $imagePath = $image->move(public_path('cocat'), $imageName);


                $bookcategories->name = $request->name;
            $bookcategories->price = $request->price;

            $bookcategories->image =$imageName;
            }else{
              
                $bookcategories->name = $request->name;
            $bookcategories->price = $request->price;
            }

           
            
            $bookcategories->save();
          
            $bookcategories->save();
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
            $bookcategories = ConsultationsCategories::findOrFail($id);
            $bookcategories->destroy($id);

            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
