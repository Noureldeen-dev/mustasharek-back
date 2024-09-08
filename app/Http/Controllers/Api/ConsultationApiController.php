<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\order;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationApiController  extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getOrderWithProducts($user_id)
    {
        $order = Order::where('user', $user_id)
            ->with(['products' => function ($query) {
                $query->select( 'products.name');
            }])
            ->get();

        return response()->json($order);
    }
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
    
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'value' => 'required|numeric',
        ]);
    
        if ($request->hasFile('file')) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            $file = $request->file('file');
            $fileExtension = $file->getClientOriginalExtension();
    
            if (!in_array($fileExtension, $allowedExtensions)) {
                return response()->json(['error' => 'السماح بملفات الصور (JPG، JPEG، PNG) وملفات PDF فقط.'], 422);
            }
    
            $maxSize = 10 * 1024 * 1024; // 10 ميجا بايت
            if ($file->getSize() > $maxSize) {
                return response()->json(['error' => 'يجب ألا يتجاوز حجم الملف 10 ميجا بايت.'], 422);
            }
    
            $imageName = $file->getClientOriginalName();
            $file->move(public_path('consultation'), $imageName);
    
            $consultation = Consultation::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'consultations_id' => $request->consultations_id,
                'content' => $request->content,
                'file' => $imageName, // Store only the file name
                'status' => 'pending',
                'value' => $request->value,
            ]);
    
            return response()->json($consultation, 201);
        } else {
            $consultation = Consultation::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'content' => $request->content,
                'consultations_id' => $request->consultations_id,
                'status' => 'pending',
                'value' => $request->value,
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'تم انشاء الطلب بنجاح',
                'consultation' => $consultation,
            ], 201);
        }
    }

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
