<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\color;
use App\Models\product;
use App\Models\productImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('products')
            ->join('sections', 'products.section', '=', 'sections.id')
            ->join('product_images', 'products.id', '=', 'product_images.product')
            ->select('products.*', 'sections.name AS section_name','product_images.img');

        // تطبيق الترتيب
        if ($request->has('sort')) {
            $query->orderBy($request->sort, $request->sort === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('products.name', 'asc');
        }

        // تطبيق البحث
        if ($request->has('search')) {
            $query->where('products.name', 'like', '%' . $request->search . '%');
        }
         if ($request->has('type')) {
            $query->where('products.type', $request->type);
        }
        if ($request->has('section')) {
            $query->where('products.section', $request->section);
        }

        // تطبيق الترقيم
        $products = $query->paginate(10);

        return response()->json($products);
    }
    public function getSections()
{
    $sections = DB::table('sections')->get();

    return response()->json($sections);
}
public function getgender(Request $request, $gender)
{

    $query = DB::table('products')
        ->join('sections', 'products.section', '=', 'sections.id')
        ->join('product_images', 'products.id', '=', 'product_images.product')
        ->select('products.*', 'sections.name AS section_name','product_images.img')


        ->where('products.sex', '=', $gender);

    // تطبيق الترتيب
    if ($request->has('sort')) {
        $query->orderBy($request->sort, $request->sort === 'asc' ? 'asc' : 'desc');
    } else {
        $query->orderBy('products.name', 'asc');
    }

    // تطبيق البحث
    if ($request->has('search')) {
        $query->where('products.name', 'like', '%' . $request->search . '%');
    }

    // تطبيق الترقيم
    $products = $query->paginate(10);

    return response()->json($products);
}

public function getmark(Request $request, $mark)
{

    $query = DB::table('products')
        ->join('sections', 'products.section', '=', 'sections.id')
        ->join('product_images', 'products.id', '=', 'product_images.product')
        ->select('products.*', 'sections.name AS section_name','product_images.img')
        ->where('products.mark', '=', $mark);

    // تطبيق الترتيب
    if ($request->has('sort')) {
        $query->orderBy($request->sort, $request->sort === 'asc' ? 'asc' : 'desc');
    } else {
        $query->orderBy('products.name', 'asc');
    }

    // تطبيق البحث
    if ($request->has('search')) {
        $query->where('products.name', 'like', '%' . $request->search . '%');
    }

    // تطبيق الترقيم
    $products = $query->paginate(10);

    return response()->json($products);
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

public function show(string $id)
{
    $product = DB::table('products')
        ->join('brands', 'products.brand_id', '=', 'brands.id')
        ->select('products.*', 'brands.name as mark')
        ->where('products.id', $id)
        ->first();

    $colors = DB::table('colors')->where('product', $product->id)->get();
    $sizes = DB::table('sizes')->where('product', $product->id)->get();
    $image = DB::table('product_images')->where('product', $product->id)->get();

    return response()->json([
        'product' => $product,
        'colors' => $colors,
        'image' => $image,
        'sizes' => $sizes
    ]);
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
