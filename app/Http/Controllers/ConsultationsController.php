<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Brand;
use App\Models\Consultation;
use App\Models\replies_consultations;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ConsultationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Con = Consultation::with('replies.user')->latest()->get();
        return view('admin.consultations.index', compact('Con'));
    }
    public function download($file)
    {
        $filePath = public_path('consultation/' . $file);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['error' => 'الملف غير موجود.'], 404);
        }
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
            'reply' => 'required',
            'consultation_id' => 'required',
           
        ], [
            'reply.required' => 'التعليق  مطلوب',


        ]);
 
      
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $imageName = $image->getClientOriginalName();
                $imagePath = $image->move(public_path('consultation'), $imageName);
                $replies = replies_consultations::create(array_merge($valid, [
                    'file' => $imageName,
                    'user_id' => auth()->id(),
                ]));
            
            }else{
                $replies = replies_consultations::create(array_merge($valid, [
                    'user_id' => auth()->id(),
                ]));
            }
           
            
            
          
            $replies->save();
            toast('تمت العملية بنجاح', 'success');
       
        
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $consultation = Consultation::findOrFail($id);

        // Pass the consultation data to the view
        return view('admin.consultations.show', compact('consultation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
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
            ],
            [
                'name.required' => 'الإسم مطلوب',
            ]
        );
        $id = Crypt::decrypt($id);
        try {
            $brand = Brand::findOrFail($id);

            $brand->update($valid);
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
        }
        return back();
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,closed,pending',
        ]);
    
        $consultation = Consultation::findOrFail($id);
        $consultation->status = $request->status;
        $consultation->save();
    
        return redirect()->back()->with('success', 'حالة الاستشارة تم تغييرها بنجاح.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $id =  Crypt::decrypt($id);
            $brand = Brand::findOrFail($id);
            $brand->destroy($id);
            toast('تم الحذف ', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ', 'error');
        }
        return back();
    }
}
