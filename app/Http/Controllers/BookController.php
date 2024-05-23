<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $book= Book::latest()->get();
        $bookCategories= BookCategory::latest()->get();
        return view('admin.book.index', compact('book','bookCategories'));
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
            'book_category_id' => 'required',
            'price' => 'required',
            'image' => 'required|image|max:2048', // Add image validation rules
        ], [
            'name.required' => 'اسم الكتاب مطلوب',
            'book_category_id.required' => 'تصنيف الكتاب مطلوب',
            'price.required' => 'سعر الكتاب مطلوب',
            'image.required' => 'صورة الكتاب مطلوب',
            'image.image' => 'الملف المرفوع يجب أن يكون صورة',
            'image.max' => 'الصورة يجب أن لا تتجاوز 2 ميجابايت',
        ]);
    
        try {
            // Handle image upload
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->move(public_path('books'), $imageName);
        
            $book = Book::create(array_merge($valid, [
                'image' => $imageName,
            ]));
        
            $book->save();
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
            // Handle exception
            toast('حدث خطأ أثناء إضافة الكتاب', 'error');
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
    $book = Book::findOrFail($id);

    $valid = $request->validate([
        'name' => 'required',
        'book_category_id' => 'required',
        'price' => 'required',
        'image' => 'image|max:2048', // Update image validation rules
    ], [
        'name.required' => 'اسم الكتاب مطلوب',
        'book_category_id.required' => 'تصنيف الكتاب مطلوب',
        'price.required' => 'سعر الكتاب مطلوب',
        'image.image' => 'الملف المرفوع يجب أن يكون صورة',
        'image.max' => 'الصورة يجب أن لا تتجاوز 2 ميجابايت',
    ]);

    try {
        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->move(public_path('books'), $imageName);

            // Delete the old image if it exists
            if ($book->image) {
                $oldImagePath = public_path('books/' . $book->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $book->image = $imageName;
        }

        $book->name = $request->name;
        $book->book_category_id = $request->book_category_id;
        $book->price = $request->price;
        $book->save();

        toast('تمت العملية بنجاح', 'success');
    } catch (Exception $e) {
        // Handle exception
        toast('حدث خطأ أثناء تعديل الكتاب', 'error');
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
