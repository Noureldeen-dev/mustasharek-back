<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Exception;
use App\Models\color;
use App\Models\product;
use App\Models\section;
use App\Models\productImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {



        $products = product::latest()->get();
        $sections = section::latest()->get();
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        return view('admin.products.index', compact('products', 'sections','categories','brands'));
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
            'section' => 'required',
            'price' => 'required|numeric',
            'price2' => 'nullable|numeric',
            'count' => 'required',
            'category_id' => 'required',
            'desc' => 'required',
            'type' => 'required',
            'pic' => 'required',
            'sex' => 'required',
            'brand_id' => 'required',

            // 'video' => 'mimes:mp4',
        ], [
            'name.required' => 'الإسم مطلوب',
            'section.required' => 'القسم مطلوب',
            'price.required' => 'السعر مطلوب',
            'count.required' => 'العدد مطلوب',
            'category_id.required' => 'الفئة مطلوبة',
            'desc.required' => 'التفاصيل مطلوبة',
            'video.mimes' => 'صيغة الفيديو غير مقبولة',
            'pic.required' => 'الصورة مطلوبة',
            'pic.mimes' => 'صيغة الصورة غير مقبولة',
            'sex.required' => 'الجنس مطلوب',
            'brand_id.required' => 'العلامة التجارية مطلوبة',
        ]);
        $valid['price2']  =  $valid['price2'] == null ? 0 : $valid['price2'];
        try {
            unset($valid["pic"]);
            $valid['video'] = $request->video;




            $product =  product::create($valid);
            foreach ($request->pic as $pic) {
                $pic = str_replace(array('[', ']', '"'), '', $pic);
                productImage::create([
                    'product' => $product->id,
                    'img' => $pic,
                ]);
            }

            $list =  $request->List_Colors;
            foreach ($list as $li) {
                color::create([
                    'color' => $li['color'],
                    'product' => $product->id,
                ]);
            }

            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $id = Crypt::decrypt($id);
        $sections = section::latest()->get();
        $product = product::findOrFail($id);
        $imgs = productImage::where('product', $id)->get();
        return view('admin.products.show', compact('product', 'sections', 'imgs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = product::findOrFail($id);
        return view('admin.products.video', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $valid = $request->validate([
            'name' => 'required',
            'section' => 'required',
            'price' => 'required',
            'price2' => 'nullable|numeric',
            'count' => 'required',
            'category' => 'required',
            'desc' => 'required',
            'type' => 'required',
            'sex' => 'required',
            'mark' => 'required',
            // 'video' => 'mimes:mp4',
        ], [
            'name.required' => 'الإسم مطلوب',
            'section.required' => 'القسم مطلوب',
            'price.required' => 'السعر مطلوب',
            'count.required' => 'العدد مطلوب',
            'category.required' => 'الفئة مطلوبة',
            'desc.required' => 'التفاصيل مطلوبة',
            'sex.required' => 'الجنس مطلوب',
            'mark.required' => 'العلامة التجارية مطلوبة',
            // 'video.mimes' => 'صيغة الفيديو غير مقبولة',
        ]);
        $valid['price2']  =  $valid['price2'] == null ? 0 : $valid['price2'];

        $id = Crypt::decrypt($id);
        try {
            $product = product::findOrFail($id);
            if ($request->video == null) {
                $valid['video'] = $product->video;
            } else {
                File::delete(public_path('assets/videos/products/' . $product->video));
                $valid['video'] = $request->video;
            }




            $product->update($valid);
            if ($request->deleteImgs != null) {
                $fileNames =   productImage::where('product', $id)->pluck('img');
                productImage::where('product', $id)->delete();
                foreach ($fileNames as $fileName) {
                    File::delete(public_path('assets/images/products/' . $fileName));
                }
            }
            if ($request->pic != null) {
                foreach ($request->pic as $pic) {
                    $pic = str_replace(array('[', ']', '"'), '', $pic);
                    productImage::create([
                        'product' => $product->id,
                        'img' => $pic,
                    ]);
                }
            }

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
            $product = product::findOrFail($id);
            $fileNames =   productImage::where('product', $id)->pluck('img');
            foreach ($fileNames as $fileName) {
                File::delete(public_path('assets/images/products/' . $fileName));
            }
            File::delete(public_path('assets/videos/products/' . $product->video));
            $product->destroy($id);
            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }


    public function editColor($id)
    {
        $id = Crypt::decrypt($id);
        $product = product::findOrFail($id);
        return view('admin.products.colorChange', compact('product'));
    }
}
