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
    
    $request->validate([
        'phone' => 'required|string',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('phone', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('API Token')->accessToken;

        //$userRoles = $user->getRoleNames();

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            //'roles' => $userRoles,
            'token' => $token,
        ], 200);
    } else {
        return response()->json([
            'message' => 'Invalid phone number or password',
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
            'password' => 'required',
            'avatar' => 'nullable',
            'phone' => 'required|numeric',
          
        ],[
            'name.required' => 'الإسم مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب',
            'password.required' => 'الرمز السري مطلوب',
            
            'email.email' => 'البريد الالكتروني غير صالح',
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
   
    'phone' => $request->phone,

]);

 $tokenResult = $user->createToken('nour');
  $token = $tokenResult->accessToken;

return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
    }
public function update(Request $request, $userId)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'nullable|min:8',
        'avatar' => 'nullable',
        'phone' => 'required|numeric',
    ], [
        'name.required' => 'الإسم مطلوب',
        'email.required' => 'البريد الالكتروني مطلوب',
        'email.email' => 'البريد الالكتروني غير صالح',
        'password.min' => 'الرمز السري يجب أن يكون على الأقل 8 أحرف',
        'phone.required' => 'رقم الهاتف مطلوب',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $user = User::findOrFail($userId);

    if (!$user) {
        return response()->json(['message' => 'المستخدم غير موجود'], 404);
    }

    $userData = $request->all();

    // Hash the password if it's provided in the request
 if ($request->filled('password')) {
        $userData['password'] = bcrypt($request->password);
    } else {
        // إزالة مفتاح password من المصفوفة لتجنب تحديثه
        unset($userData['password']);
    }
    $user->update($userData);
        
        $token = $user->createToken('API Token')->accessToken;
  return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            //'roles' => $userRoles,
            'token' => $token,
        ], 200);

}
    }

