<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apiController;
use App\Http\Controllers\Api\UserAuthAPIController;
use App\Http\Controllers\Api\GroupAPIController;

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


// Groups APIs
Route::post("group/create", [GroupAPIController::class, "createGroup"]);
Route::put("group/{id}/edit", [GroupAPIController::class, "editGroup"]);
Route::post("group/player/add", [GroupAPIController::class, "addPlayerToGroup"]);
Route::post("group/player/delete", [GroupAPIController::class, "removePlayerToGroup"]);
Route::get("all-groups/{id}", [GroupAPIController::class, "groupsOfHost"]);
Route::get("group/player/list/{id}", [GroupAPIController::class, "listPlayerInGroup"]);
Route::post("group/delete", [GroupAPIController::class, "deleteGroup"]);


// Tournament APIs
Route::post("player_login", [apicontroller::class, "player_login"]);
Route::get("player_profile/{id}", [apicontroller::class, "player_profile"]);
Route::post("update_player/{id}", [apicontroller::class, "update_player"]);
Route::post('/add_tournament',[apiController::class,'insert_tournament']);
Route::post('/tournament/{id}/delete',[apiController::class,'delete_tournament'])->name('tournament.delete');

Route::post('/tournament/player/{id}/delete',[apiController::class,'delete_tournament_player'])->name('tournament.player.delete');

Route::get('/tournament/{id}/edit',[apiController::class,'edit_tournament'])->name('api.tournament.edit');
Route::put('/tournament/{id}/update',[apiController::class,'update_tournament'])->name('api.tournament.update');

Route::get('/host_tournament/{id}',[apiController::class,'host_tournament']);
Route::get('/tournaments',[apiController::class,'tournaments']);
Route::get('/tournaments_players/{id}',[apiController::class,'tournaments_players']);
Route::post('/insert_tournament_players',[apiController::class,'insert_tournament_players']);
Route::post('/player_tournaments',[apiController::class,'player_tournaments']);
Route::post('/player_add_tournaments',[apiController::class,'player_add_tournaments']);

Route::get('/free_players/{id}',[apiController::class,'free_players']);

// Auth APIs
Route::post("forget-password", [UserAuthAPIController::class, "forgetPassword"]);
Route::post("confirm-otp", [UserAuthAPIController::class, "confirm_otp"]);
Route::post("set-password", [UserAuthAPIController::class, "set_password"]);
Route::post("register", [apicontroller::class, "register"]);






Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
