<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthController::class,"register"]);
Route::post('login', [AuthController::class,"login"]);
Route::group(['middleware' => 'Auth'], function () {
    Route::get('getuser', [CrudController::class, 'get_user']);
});
Route::post('createproduct', [CrudController::class, 'Create_Product']);
Route::get('getproduct', [CrudController::class, 'Get_All_Product']);
Route::post('getproductdetille', [CrudController::class, 'Get_Product_Detille']);
Route::get('getDiscountedProducts',[CrudController::class, 'getDiscountedProducts']);
Route::post('search', [CrudController::class, 'Search']);
Route::get('Get_Categories',[CrudController::class,'Get_Categories']);
Route::post('Add_To_Favorite', [CrudController::class, 'Add_To_Favorite']);
Route::post('get_favorite_product', [CrudController::class, 'Get_Favorite_Product']);
Route::post('getUserCartProducts', [CrudController::class, 'getUserCartProducts']);
Route::delete('deletefavorite', [CrudController::class, 'Delete_From_Favorite']);
Route::post('Add_dellivery_location', [CrudController::class, 'Add_dellivery_location']);
Route::put('udate_dellivery_location', [CrudController::class, 'update_delivery_location']);
Route::post('Get_dellivery_location', [CrudController::class, 'Get_dellivery_location']);
Route::post('addToCart', [CrudController::class, 'addToCart']);
Route::get('getMostSoldProductsByQuantity', [CrudController::class, 'getMostSoldProductsByQuantity']);
Route::post('Add_Payment_Card',[CrudController::class, 'Add_Payment_Card'] );
Route::post('calculateTotalPrice',[CrudController::class, 'calculateTotalPrice'] );
Route::post('filterProducts',[CrudController::class, 'filterProducts'] );
Route::post('Get_Payment_Data',[CrudController::class, 'Get_Payment_Data'] );
