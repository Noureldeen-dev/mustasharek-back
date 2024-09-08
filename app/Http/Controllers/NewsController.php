<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('admin.news.index', compact('news'));
    }
    public function store(Request $request)
    {
        $valid = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'picture' => 'required|image|max:2048', // Add image validation rules
        ], [
            'title.required' => 'عنوان الخبر مطلوب',

            'content.required' => 'محتوي الخبر مطلوب',
            'picture.required' => 'صورة الخبر مطلوب',
            'picture.image' => 'الملف المرفوع يجب أن يكون صورة',
            'picture.max' => 'الصورة يجب أن لا تتجاوز 2 ميجابايت',
        ]);
    
        try {
            // Handle image upload
            $image = $request->file('picture');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->move(public_path('news'), $imageName);
        
            $news = News::create(array_merge($valid, [
                'picture' => $imageName,
            ]));
        
            $news->save();
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
            // Handle exception
            toast('حدث خطأ أثناء إضافة الخبر', 'error');
        }
        
        return back();
    }
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $news = News::findOrFail($id);
    
        $valid = $request->validate([
            'title' => 'required',
            'content' => 'required',
           
        ], [
            'title.required' => 'عنوان الخبر مطلوب',

            'content.required' => 'محتوي الخبر مطلوب',
       
        ]);
    
        try {
            // Handle image upload if a new image is provided
            if ($request->hasFile('picture')) {
               
                $image = $request->file('picture');
                $imageName = $image->getClientOriginalName();
                $imagePath = $image->move(public_path('news'), $imageName);


                $news->title = $request->title;
             
            $news->content = $request->content;
            $news->picture =$imageName;
            }else{
                $news->title = $request->title;
             
                $news->content = $request->content;
            }
    
           
   
            $news->save();
    
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
            $news = News::findOrFail($id);
            $news->destroy($id);

            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
