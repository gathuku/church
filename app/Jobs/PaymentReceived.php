<?php
/**
 * Created by PhpStorm.
 * User: ayimdomnic
 * Date: 07/08/2018
 * Time: 16:00
 */

namespace App\Jobs;


use App\Events\TransactionReceived;
use App\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PaymentReceived implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payload;


    /**
     * PaymentReceived constructor.
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function handle()
    {
        $data = $this->payload;

        $transaction = Transaction::create($data);

        event(new TransactionReceived($transaction));

    }

}