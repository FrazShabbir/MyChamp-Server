<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\Api\UserAuthAPIController;

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

// Route::get('/', function () {
//     return view('welcome');
// });



								// Login Session Start

								
Route::get('/dashbord',[indexController::class,'dashbord']);




Route::get('/',[logincontroller::class,'login']);
Route::post('/',[logincontroller::class,'admin_login']);


Route::get('/logout',[logincontroller::class,'logout']);



								// End Login Session 
													


								


								// Player Session Start
						




Route::get('/players',[indexController::class,'players']);
Route::get('/add_player',[indexController::class,'add_player']);
Route::post('/add_player',[indexController::class,'insert_player']);
Route::post('/user_status',[indexController::class,'user_status']);



Route::get('/edite_player/{id}',[indexController::class,'edite_player']);
Route::post('/edite_player/{id}',[indexController::class,'update_player']);

Route::post('/delete_player',[indexController::class,'delete_player']);



								

								// End Player Session 




								

								// host Session Start




Route::get('/hosts',[indexController::class,'hosts']);

Route::get('/add_host',[indexController::class,'add_host']);
Route::post('/add_host',[indexController::class,'insert_host']);

Route::post('/aproved',[indexController::class,'aproved']);

Route::get('/edite_host/{id}',[indexController::class,'edite_host']);
Route::post('/edite_host/{id}',[indexController::class,'update_host']);

Route::post('/delete_host',[indexController::class,'delete_host']);



			
								// end host Session 






Route::get('/tournament',[indexController::class,'tournament']);
Route::get('/add_tournament',[indexController::class,'add_tournament']);
Route::post('/add_tournament',[indexController::class,'insert_tournament']);

Route::get('/tournament/{id}',[indexController::class,'show_tournament'])->name('tournament.show');
Route::get('/tournament/{id}/edit',[indexController::class,'edit_tournament'])->name('tournament.edit');
Route::put('/tournament/{id}/update',[indexController::class,'update_tournament'])->name('tournament.update');



Route::get('/asign_players',[indexController::class,'asign_players']);


Route::get('/fetch_notification',[indexController::class,'fetch_notification']);


Route::post('/tournament_accepted',[indexController::class,'tournament_accepted']);









Route::get('/tournament_players/{id}',[indexController::class,'tournament_players']);

Route::get('/add_tournament_players/{id}',[indexController::class,'add_tournament_players']);
// Route::get('/insert_tournament_players/{id}/{tournament_id}',[indexController::class,'insert_tournament_players']);
Route::post('/insert_tournament_players/{tournament_id}',[indexController::class,'insert_tournament_players']);




								// prifile Session Start
						



Route::get('/profile',[logincontroller::class,'profile']);
Route::post('/profile',[logincontroller::class,'update_profile']);


Route::get('/change_password',[logincontroller::class,'change_password']);
Route::post('/change_password',[logincontroller::class,'update_password']);

								

								// end profile Session 
Route::post('/delete_notification',[indexController::class,'delete_notification']);



Route::post('/delete_tournament_players',[indexController::class,'delete_tournament_players']);





