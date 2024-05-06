<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = section::latest()->get();
        return view('admin.sections.index', compact('sections'));
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

            $section = section::create($valid);
            if($request->hasfile('icon'))
            {
                $fileName = time() . '.' . $request->icon->extension();
                $request->icon->storeAs('public/icons/sections', $fileName);

                $section->icon = $fileName;
                $section->save();
            }
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
            $section = section::findOrFail($id);

            $section->update($valid);
            if($request->hasfile('icon'))
            {
                
                $fileName = time() . '.' . $request->icon->extension();
                $request->icon->storeAs('public/icons/sections', $fileName);

                $section->icon = $fileName;
                $section->save();
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
            $section = section::findOrFail($id);
            $section->destroy($id);
            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
