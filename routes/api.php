<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\ProductControllerApi;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Models\city;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//products
Route::get('orders/{user_id}/order_product', [OrderController::class, 'getOrderWithProducts']);

Route::resource('products', ApiProductController::class);
Route::resource('Consultation', ConsultationController::class);
Route::get('/getSections', [ApiProductController::class, 'getSections']);
Route::get('/getgender/{gender}', [ApiProductController::class, 'getgender']);
Route::get('/getmark/{mark}', [ApiProductController::class, 'getmark']);
Route::get('/getUserByToken', [AuthController::class, 'getUserByToken']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/userreport', [AuthController::class, 'userreport']);
Route::put('/profile', [AuthController::class, 'update']);

Route::post('/checkout', [ConsultationController::class, 'store']);
Route::post('/cart/add', [CartController::class, 'store']);
Route::get('/cities', function (Request $request) {
    $cities = city::all();

    return response()->json($cities);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
