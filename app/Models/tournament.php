<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tournament extends Model
{
	protected $table = "tournament";
	protected $primaryKey = "id";
    use HasFactory;
	protected $guarded = [];

	public function player(){
		return $this->hasMany(tournament_players::class,'tournament_id');
	}

	public function host(){
		return $this->belongsTo(host::class,'host_id');
	}
	public function invites(){
		return $this->hasMany(TournamentInvite::class,'tournament_id');
	}
	
}
