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
use Spatie\Permission\Models\Role;

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->accessToken;

            $userRoles = $user->getRoleNames();

            return response()->json([
                'message' => 'User logged in successfully',
                'user' => $user,
                'roles' => $userRoles,
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }
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
            'password' => 'nullable',
            'phone' => 'required|numeric',
           
        ],[
            'name.required' => 'الإسم مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'password.required' => 'الرمز السري مطلوب',
      
            'phone.required' => ' رقم الهاتف مطلوب',

        ]
    );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

$user = User::create([
    'name' => $request->name,
    'password' => $request->password,
    'email' => $request->email,

    //'phone' => $request->phone,

]);
$role = Role::where('name', 'USER')->first();
if (!$role) {
    $role = Role::create(['name' => 'USER']);
}
$user->assignRole($role);

 //$tokenResult = $user->createToken('nour');
  //$token = $tokenResult->accessToken;
  $token = $user->createToken('API Token')->accessToken;
  $userRoles = $user->getRoleNames();
  
  return response()->json([
    'message' => 'User registered successfully',
    'user' => $user,
    'token' => $token,
    'roles' => $userRoles,
], 201);

return response()->json([
                'user' => $user,
                //'token' => $token,
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

