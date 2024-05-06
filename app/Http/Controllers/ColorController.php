<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function colorStore(Request $request, $id)
    {

        $request->validate([
            'List_Colors.*.color' => 'required',
        ], [
            'List_Colors.*.color.required' => 'اللون مطلوب',
        ]);
        $list =  $request->List_Colors;
        try {
            foreach ($list as $li) {
                color::create([
                    'color' => $li['color'],
                    'product' => $id,
                ]);
            }
            toast('تمت الاضافة بنجاح', 'success');
        } catch (Exception $e) {
        }
        return redirect()->back();
    }


    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(color $color)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $id = Crypt::decrypt($id);
        $color = color::findOrFail($id);
        $request->validate([
            'color' => 'required',
        ], [
            'color' => 'اللون مطلوب',
        ]);
        try {

            $color->update([
                'color' => $request->color,
            ]);

            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $id =  Crypt::decrypt($id);
            $color = color::findOrFail($id);
            $color->destroy($id);
            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
