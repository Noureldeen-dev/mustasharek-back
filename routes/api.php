<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannersController;
use App\Http\Controllers\Api\BooksApiController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ConsultationApiController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\ProductControllerApi;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Models\city;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use App\Models\Consultation;
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
Route::get('/migrate', function () {
    Artisan::call('migrate');
    return 'Migration executed successfully!';
});
Route::get('orders/{user_id}/order_product', [OrderController::class, 'getOrderWithProducts']);

Route::apiResource('transactions', TransactionController::class);
Route::resource('banners', BannersController::class);
Route::resource('categorys', CategoryApiController::class);
Route::resource('books', BooksApiController::class);

Route::get('consultations/{userId}', function ($userId) {
    return DB::table('consultations')
        ->join('consultations_categories', 'consultations.consultations_id', '=', 'consultations_categories.id')
        ->where('consultations.user_id', $userId)
        ->select('consultations.*', 'consultations_categories.name as category_name')
        ->get();
});

Route::get('getconsultations/{consultationId}', function ( $consultationId) {
    return DB::table('consultations')
        ->join('consultations_categories', 'consultations.consultations_id', '=', 'consultations_categories.id')
        ->where('consultations.id', $consultationId) 
        ->select('consultations.*', 'consultations_categories.name as category_name')
        ->first(); 
});
Route::get('mybooks/{user_id}', function ($user_id) {
    return DB::table('mybooks')
        ->join('users', 'users.id', '=', 'mybooks.user_id')
        ->join('books', 'books.id', '=', 'mybooks.book_id')
        ->where('users.id', $user_id)
        ->select('books.*', 'users.name as user_name')
        ->get();
});

Route::resource('products', ApiProductController::class);
Route::resource('Consultation', ConsultationApiController::class);
Route::resource('Order', OrderController::class);
Route::get('/getSections', [ApiProductController::class, 'getSections']);
Route::get('/getgender/{gender}', [ApiProductController::class, 'getgender']);
Route::get('/getmark/{mark}', [ApiProductController::class, 'getmark']);
Route::get('/getUserByToken', [AuthController::class, 'getUserByToken']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/userreport', [AuthController::class, 'userreport']);
Route::put('/profile/{id}', [AuthController::class, 'update']);


Route::post('/cart/add', [CartController::class, 'store']);
Route::get('/cities', function (Request $request) {
    $cities = city::all();

    return response()->json($cities);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
