<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messsage extends Model
{
    //
    protected $table='messages';
    protected $fillable=[
      'sent_by',
      'sent_to',
      'message',
    ];

  
}
