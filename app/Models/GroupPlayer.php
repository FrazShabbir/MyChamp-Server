<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPlayer extends Model
{
    protected $guarded = [];

    use HasFactory;
    
    public function group()
    {
        return $this->belongsTo(Group::class,'group_id');
    }
    public function player()
    {
        return $this->belongsTo(host::class,'player_id');
    }
}
