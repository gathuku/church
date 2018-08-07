<?php
/**
 * Created by PhpStorm.
 * User: ayimdomnic
 * Date: 07/08/2018
 * Time: 16:07
 */

namespace App\Events;


use App\Transaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}