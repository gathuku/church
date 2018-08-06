<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    
    protected $fillable=[
       'amount',
       'receipt_no',
       'transaction_date',
       'phone_no'
    ];
}
