<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apiController;
use App\Http\Controllers\Api\UserAuthAPIController;
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

// Route::post('/insert_host', [apiController::class , 'insert_host']);



Route::post("forget-password", [UserAuthAPIController::class, "forgetPassword"]);
Route::post("confirm-otp", [UserAuthAPIController::class, "confirm_otp"]);
Route::post("set-password", [UserAuthAPIController::class, "set_password"]);



Route::post("register", [apicontroller::class, "register"]);

Route::post("player_login", [apicontroller::class, "player_login"]);

Route::get("player_profile/{id}", [apicontroller::class, "player_profile"]);

Route::post("update_player/{id}", [apicontroller::class, "update_player"]);


Route::post('/add_tournament',[apiController::class,'insert_tournament']);
Route::post('/tournament/{id}/delete',[apiController::class,'delete_tournament'])->name('tournament.delete');
Route::put('/tournament/{id}/edit',[apiController::class,'edit_tournament'])->name('tournament.edit');

Route::get('/host_tournament/{id}',[apiController::class,'host_tournament']);

Route::get('/tournaments',[apiController::class,'tournaments']);


Route::get('/tournaments_players/{id}',[apiController::class,'tournaments_players']);


Route::get('/free_players/{id}',[apiController::class,'free_players']);




Route::post('/insert_tournament_players',[apiController::class,'insert_tournament_players']);


Route::post('/player_tournaments',[apiController::class,'player_tournaments']);


Route::post('/player_add_tournaments',[apiController::class,'player_add_tournaments']);





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
