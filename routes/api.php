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
Route::get('Get_Categories',[CrudController::class,'Get_Categories']);
Route::post('Add_To_Favorite', [CrudController::class, 'Add_To_Favorite']);
Route::delete('deletefavorite', [CrudController::class, 'Delete_From_Favorite']);
