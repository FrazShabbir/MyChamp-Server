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
Route::get("group/{id}/", [GroupAPIController::class, "showGroup"]);

Route::post("group/player/add", [GroupAPIController::class, "addPlayerToGroup"]);
Route::post("group/player/delete", [GroupAPIController::class, "removePlayerToGroup"]);
Route::get("all-groups/{id}", [GroupAPIController::class, "groupsOfHost"]);
Route::get("group/player/list/{id}", [GroupAPIController::class, "listPlayerInGroup"]);
Route::post("group/delete", [GroupAPIController::class, "deleteGroup"]);
Route::post("group/announcement/create/{id}", [GroupAPIController::class, "createAnnouncement"]);
Route::delete("group/announcement/delete/{id}", [GroupAPIController::class, "deleteAnnouncement"]);

// Auth APIs
Route::post("forget-password", [UserAuthAPIController::class, "forgetPassword"]);
Route::post("confirm-otp", [UserAuthAPIController::class, "confirm_otp"]);
Route::post("set-password", [UserAuthAPIController::class, "set_password"]);
Route::post("register", [apicontroller::class, "register"]);
Route::post("confirm-otp", [apicontroller::class, "confirmOtp"]);
Route::post("resend-otp", [apicontroller::class, "resendOtp"]);

Route::post("player_login", [apicontroller::class, "player_login"]);


// Tournament APIs
Route::get("player_profile/{id}", [apicontroller::class, "player_profile"]);
Route::post("update_player/{id}", [apicontroller::class, "update_player"]);

Route::get("player/invites/{id}", [apicontroller::class, "player_invite"]);

Route::post('/add_tournament',[apiController::class,'insert_tournament']);
Route::post('/tournament/{id}/delete',[apiController::class,'delete_tournament'])->name('tournament.delete');

Route::post('/tournament/player/{id}/delete',[apiController::class,'delete_tournament_player'])->name('tournament.player.delete');

Route::get('/tournament/{id}/edit',[apiController::class,'edit_tournament'])->name('api.tournament.edit');
Route::get('/tournament/{id}',[apiController::class,'show_tournament'])->name('api.tournament.show');
Route::post('/tournament/player/approval/response/{id}',[apiController::class,'hostResponse'])->name('api.tournament.hostResponse'); // id is tournament_player_id (row)

Route::put('/tournament/{id}/update',[apiController::class,'update_tournament'])->name('api.tournament.update');

Route::get('/host_tournament/{id}',[apiController::class,'host_tournament']);
Route::get('/tournaments',[apiController::class,'tournaments']);
Route::get('/tournaments_players/{id}',[apiController::class,'tournaments_players']);
Route::post('/insert_tournament_players',[apiController::class,'insert_tournament_players']); // insert players in tournament via invite
Route::post('/invite-response',[apiController::class,'inviteResponse']); // capture invite response


Route::post('/player_tournaments',[apiController::class,'player_tournaments']);
Route::post('/player_add_tournaments',[apiController::class,'player_add_tournaments']);

Route::get('/free_players/{id}',[apiController::class,'free_players']);








Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
