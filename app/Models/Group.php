<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function host()
    {
        return $this->belongsTo(host::class,'host_id');
    }
    public function players()
    {
        return $this->hasMany(GroupPlayer::class,'group_id');
    }

}
