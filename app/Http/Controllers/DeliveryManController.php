<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\deliveryMan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;

class DeliveryManController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mans = deliveryMan::latest()->get();
        return view('admin.mans.index', compact('mans'));
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
            'email' => 'required|email',
            'password' => 'required',
            'avatar' =>    'required|mimes:png,jpg,jpeg',
            'phone' => 'required|numeric',
            'address' => 'required',
        ], [
            'name.required' => 'الإسم مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'password.required' => 'الرمز السري مطلوب',
            'avatar.required' => 'الصورة مطلوبة',
            'email.email' => 'البريد الالكتروني غير صالح',
            'phone.required' => ' رقم الهاتف مطلوب',
            'avatar.mimes' => 'صيغة الصورة غير صالحة',
        ]);
        try {

            $file = time() . uniqid() . $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('assets/Images/mans/'), $file);

            deliveryMan::create([
                'name' => $request->name,
                'password' => $request->password,
                'email' =>    $request->email,
                'avatar' =>    $file,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            toast('تمت العملية بنجاح', 'success');
        } catch (deliveryMan $e) {
            toast('حدث خطأ غير متوقع', 'error');
        }
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(deliveryMan $man)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(deliveryMan $man)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $valid = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'avatar' =>    'mimes:png,jpg,jpeg',
            'phone' => 'required|numeric',
            'address' => 'required',
        ], [
            'name.required' => 'الإسم مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.email' => 'البريد الالكتروني غير صالح',
            'phone.required' => ' رقم الهاتف مطلوب',
            'avatar.mimes' => 'صيغة الصورة غير صالحة',
        ]);
        $id = Crypt::decrypt($id);
        $man = deliveryMan::findOrFail($id);
        try {

            if ($request->has('avatar')) {
                $file = time() . uniqid() . $request->avatar->getClientOriginalName();
                $request->avatar->move(public_path('assets/images/mans/'), $file);
            } else {
                $file = $man->avatar;
            }
            $password = $request->filled('password') ? $request->password : $man->password;

            $man->update([
                'name' => $request->name,
                'password' => $password,
                'email' =>    $request->email,
                'avatar' =>    $file,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            toast('تمت العملية بنجاح', 'success');
        } catch (Exception $e) {
            toast('حدث خطأ غير متوقع', 'error');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $man = deliveryMan::findOrFail($id);
        try {
            $man->delete($id);
            toast('تم الحذف بنجاح', 'success');
        } catch (Exception $e) {
            toast('حدث خطأ غير متوقع', 'error');
        }
        return back();
    }
}
