<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model{
    protected $fillable = array('name', 'poster', 'season', 'series');
}
