<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest; // استيراد LoginRequest
use App\Models\User;
use App\Models\UserReport;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function userreport(Request $request)
    {

        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'user_report' => 'required|max:256',
        ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ في تحقق الصحة',
            'errors' => $validator->errors(),
        ], 400);
    }


    $rep = new UserReport();
    $rep->user_id  = $user->id;
    $rep->user_report =$request->user_report;
    $rep->save();
    if (!$rep->save()) {
        return response()->json([
            'success' => false,
            'message' => 'فشل في انشاء الطلب',
        ], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'تم انشاء الطلب بنجاح',
        'order' => $rep,
    ], 201);


    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $tokenResult = $user->createToken('nour');
            $token = $tokenResult->accessToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    public function getUserByToken(Request $request)
    {
        $user = Auth::guard('api')->user();
        return  $user;
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token.',
            ], 401);
        }

        $accessToken = Token::where('id', $token)->first();

        if (!$accessToken) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token.',
            ], 401);
        }

        $user = $accessToken->user;

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'avatar' => 'nullable',
            'phone' => 'required|numeric',
            'address' => 'required',
        ],[
            'name.required' => 'الإسم مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'password.required' => 'الرمز السري مطلوب',
            'avatar.required' => 'الصورة مطلوبة',
            'email.email' => 'البريد الالكتروني غير صالح',
            'phone.required' => ' رقم الهاتف مطلوب',
            'avatar.mimes' => 'صيغة الصورة غير صالحة',
        ]
    );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

$user = User::create([
    'name' => $request->name,
    'password' => $request->password,
    'email' => $request->email,
    'avatar' => $request->avatar,
    'phone' => $request->phone,
    'address' => $request->address,
]);

 $tokenResult = $user->createToken('nour');
  $token = $tokenResult->accessToken;

return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
    }
    public function update(Request $request)
{

    $validator = Validator::make($request->all(), [
        'name' => 'nullable',
        'email' => 'nullable',
        'password' => 'nullable',
        'avatar' => 'nullable|mimes:jpeg,png,jpg,gif',
        'phone' => 'nullable|numeric',
        'address' => 'nullable',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }
    $user = Auth::guard('api')->user();


    if (!$user) {
        return response()->json(['message' => 'المستخدم غير موجود'], 404);
    }




    $user->update($request->all());

    return response()->json(['message' => 'تم تحديث المستخدم بنجاح'], 200);
}
    }

