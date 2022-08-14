<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tournament_players extends Model
{
	protected $table = "tournament_players";
	protected $primaryKey = "id";
    use HasFactory;
}
