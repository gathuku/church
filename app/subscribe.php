<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscribe extends Model
{
    //

    //protected $table='subscibes;

    protected $fillable=[
    	'name',
    	'email',
    ];
}
