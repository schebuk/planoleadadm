<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\SegmentsController;
use App\Http\Controllers\QualitysController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\IntegrantsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClientsUserController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\CitysController;
use App\Http\Controllers\StatesController;
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
Route::get('segments/getselect/{description}', [SegmentsController::class, 'getSelect']);
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

Route::get('qualitys/', [QualitysController::class, 'index']);
Route::post('qualitys/save/', [QualitysController::class, 'save']);
Route::post('qualitys/edit/multiple/', [QualitysController::class, 'massEdit']);
Route::post('qualitys/trash/multiple/', [QualitysController::class, 'massTrash']);
Route::post('qualitys/restore/multiple/', [QualitysController::class, 'massRestore']);
Route::post('qualitys/delete/multiple/', [QualitysController::class, 'massDelete']);
Route::post('qualitys/edit/', [QualitysController::class, 'edit']);
Route::get('qualitys/trash/list', [QualitysController::class, 'getTrashList']);
Route::get('qualitys/trash/{id}', [QualitysController::class, 'trash']);
Route::get('qualitys/restore/{id}', [QualitysController::class, 'restore']);
Route::get('qualitys/delete/{id}', [QualitysController::class, 'delete']);
Route::get('qualitys/status/{id}/{status}', [QualitysController::class, 'status']);
Route::post('qualitys/import/', [QualitysController::class, 'import']);
Route::post('qualitys/export/template', [QualitysController::class, 'exportTemplate']);
Route::post('qualitys/export/', [QualitysController::class, 'export']);
Route::get('qualitys/gettrash/', [QualitysController::class, 'getTrash']);
Route::get('qualitys/getselect/{description}', [QualitysController::class, 'getSelect']);
Route::get('qualitys/{id}', [QualitysController::class, 'getById']);

Route::get('ads/', [AdsController::class, 'index']);
Route::post('ads/save/', [AdsController::class, 'save']);
Route::post('ads/edit/multiple/', [AdsController::class, 'massEdit']);
Route::post('ads/trash/multiple/', [AdsController::class, 'massTrash']);
Route::post('ads/restore/multiple/', [AdsController::class, 'massRestore']);
Route::post('ads/delete/multiple/', [AdsController::class, 'massDelete']);
Route::post('ads/edit/', [AdsController::class, 'edit']);
Route::get('ads/trash/list', [AdsController::class, 'getTrashList']);
Route::get('ads/trash/{id}', [AdsController::class, 'trash']);
Route::get('ads/restore/{id}', [AdsController::class, 'restore']);
Route::get('ads/delete/{id}', [AdsController::class, 'delete']);
Route::get('ads/status/{id}/{status}', [AdsController::class, 'status']);
Route::post('ads/import/', [AdsController::class, 'import']);
Route::post('ads/export/template', [AdsController::class, 'exportTemplate']);
Route::post('ads/export/', [AdsController::class, 'export']);
Route::get('ads/gettrash/', [AdsController::class, 'getTrash']);
Route::get('ads/getselect/{description}', [AdsController::class, 'getSelect']);
Route::get('ads/{id}', [AdsController::class, 'getById']);

Route::get('integrants/', [IntegrantsController::class, 'index']);
Route::post('integrants/save/', [IntegrantsController::class, 'save']);
Route::post('integrants/edit/multiple/', [IntegrantsController::class, 'massEdit']);
Route::post('integrants/trash/multiple/', [IntegrantsController::class, 'massTrash']);
Route::post('integrants/restore/multiple/', [IntegrantsController::class, 'massRestore']);
Route::post('integrants/delete/multiple/', [IntegrantsController::class, 'massDelete']);
Route::post('integrants/edit/', [IntegrantsController::class, 'edit']);
Route::get('integrants/trash/list', [IntegrantsController::class, 'getTrashList']);
Route::get('integrants/trash/{id}', [IntegrantsController::class, 'trash']);
Route::get('integrants/restore/{id}', [IntegrantsController::class, 'restore']);
Route::get('integrants/delete/{id}', [IntegrantsController::class, 'delete']);
Route::get('integrants/status/{id}/{status}', [IntegrantsController::class, 'status']);
Route::post('integrants/import/', [IntegrantsController::class, 'import']);
Route::post('integrants/export/template', [IntegrantsController::class, 'exportTemplate']);
Route::post('integrants/export/', [IntegrantsController::class, 'export']);
Route::get('integrants/gettrash/', [IntegrantsController::class, 'getTrash']);
Route::get('integrants/{id}', [IntegrantsController::class, 'getById']);

Route::get('clients/', [ClientsController::class, 'index']);
Route::post('clients/save/', [ClientsController::class, 'save']);
Route::post('clients/edit/multiple/', [ClientsController::class, 'massEdit']);
Route::post('clients/trash/multiple/', [ClientsController::class, 'massTrash']);
Route::post('clients/restore/multiple/', [ClientsController::class, 'massRestore']);
Route::post('clients/delete/multiple/', [ClientsController::class, 'massDelete']);
Route::post('clients/edit/', [ClientsController::class, 'edit']);
Route::get('clients/trash/list', [ClientsController::class, 'getTrashList']);
Route::get('clients/trash/{id}', [ClientsController::class, 'trash']);
Route::get('clients/restore/{id}', [ClientsController::class, 'restore']);
Route::get('clients/delete/{id}', [ClientsController::class, 'delete']);
Route::get('clients/status/{id}/{status}', [ClientsController::class, 'status']);
Route::post('clients/import/', [ClientsController::class, 'import']);
Route::post('clients/export/template', [ClientsController::class, 'exportTemplate']);
Route::post('clients/export/', [ClientsController::class, 'export']);
Route::get('clients/gettrash/', [ClientsController::class, 'getTrash']);
Route::get('clients/getselect/{description}', [ClientsController::class, 'getSelect']);
Route::get('clients/{id}', [ClientsController::class, 'getById']);

Route::get('clients-user/', [ClientsUserController::class, 'index']);
Route::post('clients-user/save/', [ClientsUserController::class, 'save']);
Route::post('clients-user/edit/multiple/', [ClientsUserController::class, 'massEdit']);
Route::post('clients-user/trash/multiple/', [ClientsUserController::class, 'massTrash']);
Route::post('clients-user/restore/multiple/', [ClientsUserController::class, 'massRestore']);
Route::post('clients-user/delete/multiple/', [ClientsUserController::class, 'massDelete']);
Route::post('clients-user/edit/', [ClientsUserController::class, 'edit']);
Route::get('clients-user/trash/list', [ClientsUserController::class, 'getTrashList']);
Route::get('clients-user/trash/{id}', [ClientsUserController::class, 'trash']);
Route::get('clients-user/restore/{id}', [ClientsUserController::class, 'restore']);
Route::get('clients-user/delete/{id}', [ClientsUserController::class, 'delete']);
Route::get('clients-user/status/{id}/{status}', [ClientsUserController::class, 'status']);
Route::post('clients-user/import/', [ClientsUserController::class, 'import']);
Route::post('clients-user/export/template', [ClientsUserController::class, 'exportTemplate']);
Route::post('clients-user/export/', [ClientsUserController::class, 'export']);
Route::get('clients-user/gettrash/', [ClientsUserController::class, 'getTrash']);
Route::get('clients-user/{id}', [ClientsUserController::class, 'getById']);
Route::get('clients-user/', [ClientsUserController::class, 'index']);
Route::post('clients-user/save/', [ClientsUserController::class, 'save']);

Route::post('leads/edit/multiple/', [LeadsController::class, 'massEdit']);
Route::post('leads/save/', [LeadsController::class, 'save']);
Route::post('leads/trash/multiple/', [LeadsController::class, 'massTrash']);
Route::post('leads/restore/multiple/', [LeadsController::class, 'massRestore']);
Route::post('leads/delete/multiple/', [LeadsController::class, 'massDelete']);
Route::post('leads/edit/', [LeadsController::class, 'edit']);
Route::get('leads/trash/list', [LeadsController::class, 'getTrashList']);
Route::get('leads/trash/{id}', [LeadsController::class, 'trash']);
Route::get('leads/restore/{id}', [LeadsController::class, 'restore']);
Route::get('leads/delete/{id}', [LeadsController::class, 'delete']);
Route::get('leads/status/{id}/{status}', [LeadsController::class, 'status']);
Route::post('leads/import/', [LeadsController::class, 'import']);
Route::post('leads/export/template', [LeadsController::class, 'exportTemplate']);
Route::post('leads/export/', [LeadsController::class, 'export']);
Route::get('leads/gettrash/', [LeadsController::class, 'getTrash']);
Route::get('leads/{id}', [LeadsController::class, 'getById']);

Route::get('city/getselect/{state}', [CitysController::class, 'getSelect']);
Route::get('state/getselect/', [StatesController::class, 'getSelect']);

Route::post('config/columns/save/', [ConfigurationsController::class, 'columnsSave']);
Route::post('config/columns/{page}', [ConfigurationsController::class, 'columns']);
Route::get('config/{table}', [ConfigurationsController::class, 'getColumns']);
