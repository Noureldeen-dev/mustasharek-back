<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;


class FilesController extends Controller
{

    function store(Request $request)
    {
        $request->validate([
            'pic.*' => 'required|mimes:png,jpg,jpeg',
            'video' => 'mimes:mp4'
        ], [
            'pic.*.required' => 'الصورة مطلوبة',
            'pic.*.mimes' => 'صيغة الصورة غير مقبولة',
            'video.required' => 'الفيديو مطلوب',
            'video.mimes' => 'صيغة الفيديو غير مقبولة',
        ]);
        $imageFiles = array();
        $videoName = '';
        if ($request->hasFile('pic')) {
            foreach ($request->file('pic') as $image) {
                $imageName = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/images/products/'), $imageName);
                $imageFiles[] = $imageName;
            }
            return  $imageFiles;
        } elseif ($request->hasFile('video')) {
            $videoName = time() . uniqid() .  '.' . $request->video->getClientOriginalExtension();
            $request->video->move(public_path('assets/videos/products'), $videoName);
            return  $videoName;
        }
    }
    function vedioStore(Request $request)
    {
        $request->validate([
            'vedio' => 'mimes:mp4'
        ], [
            'vedio.mimes' => 'صيغة الملف غير مقبولة',
        ]);
        $file = time() . uniqid() . $request->vedio->getClientOriginalName();
        $request->vedio->move(public_path('assets/images/products/'), $file);
        return $file;
    }
}
