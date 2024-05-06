<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = admin::latest()->get();
        return view('admin.admins.index', compact('admins'));
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
        try {

            $file = time() . uniqid() . $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('assets/Images/admins/'), $file);
            admin::create([
                'name' => $request->name,
                'password' => $request->password,
                'email' =>    $request->email,
                'avatar' =>    $file,
            ]);
            toast('تمت العملية بنجاح', 'success');
        } catch (admin $e) {
            toast('حدث خطأ غير متوقع', 'error');
        }
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {    $id = Crypt::decrypt($id);
        $admin = admin::findOrFail($id);
        try {

            if ($request->has('avatar')) {
                $file = time() . uniqid() . $request->avatar->getClientOriginalName();
                $request->avatar->move(public_path('assets/images/admins/'), $file);

            } else {
                $file = $admin->avatar;

            }
            $password = $request->filled('password') ? $request->password : $admin->password;

            $admin->update([
                'name' => $request->name,
                'password' => $password,
                'email' =>    $request->email,
                'avatar' =>    $file,
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
    public function destroy( $id)
    {
        $id = Crypt::decrypt($id);
        $admin = admin::findOrFail($id);
        try {
            $admin->delete($id);
            toast('تم الحذف بنجاح', 'success');
        } catch (Exception $e) {
            toast('حدث خطأ غير متوقع', 'error');
        }
        return back();
    }
}
