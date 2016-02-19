<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListM extends Model
{
    protected $table = 'lists';
    protected $fillable =  ['id', 'name'];
}
