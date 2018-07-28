<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=[
      'commentable_id',
      'commented_by',
      'comment_body',
    ];
}
