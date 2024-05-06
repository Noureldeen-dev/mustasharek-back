<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\UserReport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $UserReports = UserReport::latest()->get();
        return view('admin.UserReports.index', compact('UserReports'));
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
    public function show(UserReport $UserReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserReport $UserReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserReport $UserReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserReport $UserReport)
    {
        try {
            $UserReport->delete();
            toast('تم الحذف بنجاح', 'success');
        } catch (Exception $e) {
            toast('حدث خطأ غير متوقع', 'error');
        }
        return back();
    }
}
