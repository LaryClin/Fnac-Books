<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();
Route::get("/permission", "HomeController@permissionError")->middleware('auth')->name('permissionError');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/modif', 'ModificationCompteController@modif')->name('modif')->middleware('auth');
Route::post('/modify', 'ModificationCompteController@modify')->middleware('auth');

Route::group(["prefix" => "genre", "middleware" => "sale_service"], function() {
	Route::get('/', 'GenreController@index')->name('genre');
	Route::post('/', 'GenreController@save');
	Route::get('check/{id}', 'GenreController@genreStillUsed');
	Route::post('delete/{id}', 'GenreController@deleteGenre');
	Route::post('modify', 'GenreController@modifyGenre');
});

// Commande routes
Route::group(["prefix" => "commande", "middleware" => "auth"], function() {
	Route::get('/', 'CommandeController@consulterAll')->name('commande');
	Route::get('livrer/{id}', 'CommandeController@passerEnLivre');
	Route::get('list/{id}', 'CommandeController@listCommandesUser');
	Route::get('confirmation', 'CommandeController@confirmationCommande')->middleware('auth');
	Route::post('validate', 'CommandeController@validateCommande')->middleware('auth');
	Route::get('consulterCommande','CommandeController@consulterAdhID')->name('listCommandesUser')->middleware('auth');
	Route::get('{id}', 'CommandeController@consulterID')->middleware('auth'); // dernière route

});
// End commandes

// Search routes
Route::prefix('search')->group(function (){
	Route::get("/", "RechercheController@index")->name('search');
	Route::get("rubrique", "RechercheController@search_by_rubrique");
	Route::get("rubrique/{id}", "RechercheController@display_rubrique");
	Route::get("genre", "RechercheController@search_by_genre");
	Route::get("genre/{id}", "RechercheController@display_genre");
	Route::get("auteur", "RechercheController@search_by_auteur");
	Route::get("auteur/results", "RechercheController@display_auteur");
	Route::get("editeur", "RechercheController@search_by_editeur");
	Route::get("editeur/{id}", "RechercheController@display_editeur");
	Route::get("format", "RechercheController@search_by_format");
	Route::get("format/{id}", "RechercheController@display_format");
});
// End search

//Consulter routes
Route::get("/consulter/{id}","LivreController@consulter");
//End consulter

//Avis routes
Route::prefix('avis')->group(function (){
	Route::get("all/{id}", "AvisController@index");
	Route::get("fetch_data/{id}", "AvisController@fetch_data");
	Route::get("signaler/{id}","AvisController@signaler")->middleware('auth');
	Route::get("all-abusif", "AvisAbusifController@showAll")->middleware('communication_service')->name('avis-abusif');
	Route::get("delete/{id}", "AvisAbusifController@delete")->middleware('auth');
	Route::get("deleteSignalement", "AvisAbusifController@deleteSignalement")->middleware('communication_service');
	Route::post("add", "AvisController@add")->middleware('auth');
	Route::get("utile/add", "AvisController@avisUtile")->middleware('auth');
});
//End avis

// Comparateur routes
Route::prefix('comparateur')->group(function (){
	Route::get("/", "ComparateurController@show")->name('comparateur');
	Route::get("get", "ComparateurController@get");
	Route::get("add/{id}", "ComparateurController@add");
	Route::get("remove/{id}", "ComparateurController@remove");
	Route::get("empty", "ComparateurController@empty");
});
// End comparateur

//Panier routes
Route::prefix('panier')->group(function (){
	Route::get("/","PanierController@consulterPanier")->name('panier');
	Route::get("sessionToDb", "PanierController@sessionToDb")->middleware('auth');
	Route::get("addPanier/", "PanierController@addPanier");
	Route::post("remove/{id}","PanierController@removePanier");
	Route::get("empty", "PanierController@empty")->middleware('admin');
	Route::post('modifyQte/{liv_id}/{new_qte}', "PanierController@modifyQte");
});
//End

//Favoris
Route::group(["prefix" => "favoris", "middleware" => "auth"], function() {
	Route::get("/", "FavoriController@index")->name('favoris');
	Route::get("add/{id}", "FavoriController@add");
	Route::get("remove/{id}", "FavoriController@remove");
});

//End

// Route Photos
Route::group(["prefix" => "photos", "middleware" => "sale_service"], function() {
	Route::get('/', "PhotoController@showListBooks")->name('photos');
	Route::post("add/{id}", "PhotoController@add");
	Route::post("delete/{id}", "PhotoController@delete");
	Route::get("debug", "PhotoController@debug");
	Route::get("{id}", "PhotoController@showPhotos");
});
// End photos

//TEST ADMIN
Route::prefix('admin')->group(function () {
	Route::get("/", "AdminController@index")->middleware('employee')->name("admin");
	Route::get('/moderate', 'AdminController@listUsers')->middleware('admin')->name("admin_moderate");
	Route::post('/moderate/update/{adh_id}/{rol_id}', 'AdminController@updateRole')->middleware('admin');
});
//END

//
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
})->middleware('admin');
//