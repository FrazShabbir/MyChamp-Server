<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class host extends Model
{
	protected $table = "host";
	protected $primaryKey = "id";
	
    use HasFactory;
	public function tournaments(){
		return this->hasMany('App\Models\tournament','host_id');
	}
}

