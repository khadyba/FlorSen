<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\CommentaireController;
use App\Http\Controllers\API\MessageriesController;
use App\Http\Controllers\API\NewlettresController;
use App\Http\Controllers\API\ProduitsController;

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
    Route::post('SupprimerNewlettes/{id}', 'supprimer');
    Route::get('ListerProduit','listeProduits');
    Route::get('rechercheParCategorie/{id}','filter');
    Route::get('ListJardiniers','listeJardiniers');
});

Route::middleware(['is_connecte'])->group(function () {
    Route::controller(CommentaireController::class)->group(function (){
        Route::post('AjouterCommentaire/{article}', 'create');
        Route::post('ModifierCommentaire/{article}', 'update');
        Route::delete('SupprimerCommentaire/{commentaire}', 'destroy');
        Route::get('ConsulterProfile/{jardinier}','edit');
        Route::post('ContacterJardinier/{id}', 'contacter');
        Route::get('VoirDetailProduits/{produits}','show');
        Route::get('VoirDetailProduits/{produits}','show');
        Route::get('ListerCommentaires/{article}', 'index');
        
    });
});

Route::middleware(['is_jardinier'])->group(function () {
    Route::controller(ProduitsController::class)->group(function (){
        Route::post('PublierProduits', 'create');
        Route::post('VoirDetailProduits', 'show');
        Route::post('ModifierProduits/{produits}', 'update');
        Route::delete('SupprimerProduits/{produits}', 'destroy');
        Route::delete('RetirerProduits/{produits}', 'retirer');
        Route::get('ListerProduits','index');
        Route::get('VoirDetailProduits/{produits}','edit');
    });
});

Route::middleware(['is_jardinier'])->group(function (){
    Route::controller(CategoriesController::class)->group(function (){
        Route::put('ModifierCategorie/{id}', 'update');
        Route::post('AjouterCategorie', 'store');
        Route::delete('SupprimerCategorie/{id}', 'destroy');

    });
});

Route::controller(MessageriesController::class)->group(function (){
    Route::post('EnvoyerMessage/{id}', 'sendMessage');
    Route::post('RepondreMessage/{message_id}', 'repondreMessage');
    Route::get('RecupererMessage/{message_id}', 'getMessages');

});