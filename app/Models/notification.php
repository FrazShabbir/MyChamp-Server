<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
	protected $table = "notification";
	protected $primaryKey = "id";
    use HasFactory;
}
