<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\NewlettresController;

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



Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
       
});

Route::controller(UserController::class)->group(function () {
    Route::post('blockUser/{id}','blockUser')->middleware('checkadmin');
    Route::post('debloquerUser/{id}','debloquerUser')->middleware('checkadmin');
    Route::get('listJardinier','listJardinier')->middleware('checkadmin');
    Route::get('listClients','listClients')->middleware('checkadmin');
    Route::post('modifierProfil/{id}', 'update');
});

Route::controller(ArticleController::class)->group(function () {
    Route::post('createArticle', 'create')->middleware('checkadmin');
    Route::post('updateArticle/{id}', 'update')->middleware('checkadmin');
    Route::delete('destroyArticle/{id}', 'destroy')->middleware('checkadmin');
    Route::get('ListeArticle', 'index');
    Route::get('VoirDetailArticle/{id}', 'show');


});

Route::controller(NewlettresController::class)->group(function (){
    Route::post('AjouterNewletters', 'store');
});
