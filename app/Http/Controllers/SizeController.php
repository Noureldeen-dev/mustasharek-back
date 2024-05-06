<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function sizeStore(Request $request, $id)
    {

        $request->validate([
            'List_Sizes.*.size' => 'required',
        ], [
            'List_Sizes.*.size.required' => 'اللون المقاس',
        ]);
        $list =  $request->List_Colors;
        try {
            foreach ($list as $li) {
                Size::create([
                    'size' => $li['size'],
                    'product' => $id,
                ]);
            }
            toast('تمت الاضافة بنجاح', 'success');
        } catch (Exception $e) {
        }
        return redirect()->back();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        //
    }
}
