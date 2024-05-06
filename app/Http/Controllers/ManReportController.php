<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ManReport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ManReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ManReports = ManReport::latest()->get();
        return view('admin.ManReports.index', compact('ManReports'));
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
    public function show(ManReport $ManReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManReport $ManReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ManReport $ManReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManReport $ManReport)
    {
        try {
            $ManReport->delete();
            toast('تم الحذف بنجاح', 'success');
        } catch (Exception $e) {
            toast('حدث خطأ غير متوقع', 'error');
        }
        return back();
    }
}
