<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table='users';
    protected $fillable=[
      'name'
      'category',
      'member_no',
      'gender',
      'phone',
      'birth_date',
    ];

public function user(){
  return $this->hasOne('App\User');
}

}
