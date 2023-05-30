<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Head extends Model
{
    protected $fillable = ['head_name', 'parent_id'];

    public function parentHeads(){
        return $this->belongsTo(Head::class, 'parent_id', 'id');
    }

    public function subhead(){
        return $this->hasMany(Head::class, 'parent_id', 'id');
    }
}
