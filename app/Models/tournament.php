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
}
