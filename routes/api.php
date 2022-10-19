<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RulesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});
Route::group(['middleware' => 'auth:api'], function() { 
  Route::group(['prefix' => 'auth'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
  });
});


Route::get('users/', [UsersController::class, 'index']);
Route::post('users/save/', [UsersController::class, 'save']);
Route::post('users/edit/multiple/', [UsersController::class, 'massEdit']);
Route::post('users/trash/multiple/', [UsersController::class, 'massTrash']);
Route::post('users/delete/multiple/', [UsersController::class, 'massDelete']);
Route::post('users/edit/', [UsersController::class, 'edit']);
Route::get('users/trash/{id}', [UsersController::class, 'trash']);
Route::get('users/delete/{id}', [UsersController::class, 'delete']);
Route::get('users/status/{id}/{status}', [UsersController::class, 'status']);
Route::post('users/import/', [UsersController::class, 'import']);
Route::post('users/export/', [UsersController::class, 'export']);
Route::get('users/gettrash/', [UsersController::class, 'getTrash']);
Route::get('users/{id}', [UsersController::class, 'getUserById']);

Route::get('rules/getselect/{description}', [RulesController::class, 'getSelect']);
