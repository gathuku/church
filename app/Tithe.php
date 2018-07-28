<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tithe extends Model
{
    //

    protected $fillable=[
      'user_id',
      'amount',
      'mode',
    ];

    public function user(){
      return $this->hasMany('App\User');
    }
}
