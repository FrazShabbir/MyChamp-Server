<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tournament_players extends Model
{
	protected $table = "tournament_players";
	protected $primaryKey = "id";
    use HasFactory;
	public function tournament()
    {
        return $this->belongsTo(tournament::class,'tournament_id');
    }
    public function player()
    {
        return $this->belongsTo(host::class,'player_id');
    }
}


