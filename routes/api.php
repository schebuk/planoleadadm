<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\SegmentsController;
use App\Http\Controllers\ConfigurationsController;

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
Route::post('users/restore/multiple/', [UsersController::class, 'massRestore']);
Route::post('users/delete/multiple/', [UsersController::class, 'massDelete']);
Route::post('users/edit/', [UsersController::class, 'edit']);
Route::get('users/trash/list', [UsersController::class, 'getTrashList']);
Route::get('users/trash/{id}', [UsersController::class, 'trash']);
Route::get('users/restore/{id}', [UsersController::class, 'restore']);
Route::get('users/delete/{id}', [UsersController::class, 'delete']);
Route::get('users/status/{id}/{status}', [UsersController::class, 'status']);
Route::post('users/import/', [UsersController::class, 'import']);
Route::post('users/export/template', [UsersController::class, 'exportTemplate']);
Route::post('users/export/', [UsersController::class, 'export']);
Route::get('users/gettrash/', [UsersController::class, 'getTrash']);
Route::get('users/{id}', [UsersController::class, 'getById']);

Route::get('segments/', [SegmentsController::class, 'index']);
Route::post('segments/save/', [SegmentsController::class, 'save']);
Route::post('segments/edit/multiple/', [SegmentsController::class, 'massEdit']);
Route::post('segments/trash/multiple/', [SegmentsController::class, 'massTrash']);
Route::post('segments/restore/multiple/', [SegmentsController::class, 'massRestore']);
Route::post('segments/delete/multiple/', [SegmentsController::class, 'massDelete']);
Route::post('segments/edit/', [SegmentsController::class, 'edit']);
Route::get('segments/trash/list', [SegmentsController::class, 'getTrashList']);
Route::get('segments/trash/{id}', [SegmentsController::class, 'trash']);
Route::get('segments/restore/{id}', [SegmentsController::class, 'restore']);
Route::get('segments/delete/{id}', [SegmentsController::class, 'delete']);
Route::get('segments/status/{id}/{status}', [SegmentsController::class, 'status']);
Route::post('segments/import/', [SegmentsController::class, 'import']);
Route::post('segments/export/template', [SegmentsController::class, 'exportTemplate']);
Route::post('segments/export/', [SegmentsController::class, 'export']);
Route::get('segments/gettrash/', [SegmentsController::class, 'getTrash']);
Route::get('segments/{id}', [SegmentsController::class, 'getById']);

Route::get('rules/', [RulesController::class, 'index']);
Route::post('rules/save/', [RulesController::class, 'save']);
Route::post('rules/edit/multiple/', [RulesController::class, 'massEdit']);
Route::post('rules/trash/multiple/', [RulesController::class, 'massTrash']);
Route::post('rules/restore/multiple/', [RulesController::class, 'massRestore']);
Route::post('rules/delete/multiple/', [RulesController::class, 'massDelete']);
Route::post('rules/edit/', [RulesController::class, 'edit']);
Route::get('rules/trash/list', [RulesController::class, 'getTrashList']);
Route::get('rules/trash/{id}', [RulesController::class, 'trash']);
Route::get('rules/restore/{id}', [RulesController::class, 'restore']);
Route::get('rules/delete/{id}', [RulesController::class, 'delete']);
Route::get('rules/status/{id}/{status}', [RulesController::class, 'status']);
Route::post('rules/import/', [RulesController::class, 'import']);
Route::post('rules/export/template', [RulesController::class, 'exportTemplate']);
Route::post('rules/export/', [RulesController::class, 'export']);
Route::get('rules/gettrash/', [RulesController::class, 'getTrash']);
Route::get('rules/getselect/{description}', [RulesController::class, 'getSelect']);
Route::get('rules/{id}', [RulesController::class, 'getById']);

Route::post('config/columns/save/', [ConfigurationsController::class, 'columnsSave']);
Route::post('config/columns/{page}', [ConfigurationsController::class, 'columns']);
Route::get('config/{table}', [ConfigurationsController::class, 'getColumns']);
