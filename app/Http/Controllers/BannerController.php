<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Book;
use App\Models\BookCategory;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner= Banner::latest()->get();
        
        return view('admin.banner.index', compact('banner'));
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
            
            'image' => 'required|image|max:2048', // Add image validation rules
        ], [
            'image.required' => 'صورة الكتاب مطلوب',
            'image.image' => 'الملف المرفوع يجب أن يكون صورة',
            'image.max' => 'الصورة يجب أن لا تتجاوز 2 ميجابايت',
        ]);
    
        try {
            // Handle image upload
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->move(public_path('banners'), $imageName);
        
            $banners = Banner::create(array_merge($valid, [
                'image' => $imageName,
            ]));
        
            $banners->save();
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
            // Handle exception
            toast('حدث خطأ أثناء إضافة البنر', 'error');
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
    public function update(Request $request, $id)
{
    $id = Crypt::decrypt($id);
    $banners = Banner::findOrFail($id);

    $valid = $request->validate([
      
        'image' => 'image|max:2048', // Update image validation rules
    ], [
     
        'image.image' => 'الملف المرفوع يجب أن يكون صورة',
        'image.max' => 'الصورة يجب أن لا تتجاوز 2 ميجابايت',
    ]);

    try {
        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->move(public_path('banners'), $imageName);

            // Delete the old image if it exists
            if ($banners->image) {
                $oldImagePath = public_path('banners/' . $banners->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $banners->image = $imageName;
         
            $banners->status = $request->status;
        }else{
           
            $banners->status = $request->status; 
        }

     
      
     
        $banners->save();

        toast('تمت العملية بنجاح', 'success');
    } catch (Exception $e) {
        // Handle exception
        
        toast('حدث خطأ أثناء تعديل البانر', 'error');
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
            $book = Book::findOrFail($id);
            $book->destroy($id);

            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
