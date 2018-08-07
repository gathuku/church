<?php

namespace App\Http\Controllers;

use App\Gateways\Mpesa;
use App\Jobs\PaymentReceived;


class MpesaController extends Controller
{

    protected $mpesa;

    /**
     * MpesaController constructor.
     * @param Mpesa $mpesa
     */
    public function __construct(Mpesa $mpesa)
    {
        $this->mpesa = $mpesa;
    }

    /**
     * Excecute an LNMO request
     *
     * @return mixed
     * @throws \Exception
     */
    public function stk()
    {
        $rules = [
            "phone" => "required",
            "amount" => "required",
        ];

        $data = [
            "phone" => \request('phone'),
            "amount" => \request('amount')
        ];

        $validator = validator()->make($rules, $data);

        if ($validator->fails()) {
            throw new \Exception($validator->errors());
        }

        return $this->mpesa->stk($data['phone'], $data['amount'])->send();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function stk_callback()
    {
        $payload = \request()->all();

        $processed = $this->mpesa::process_stk($payload);

        $this->dispatch(new PaymentReceived($processed));

        return response()->json([
            "message" => "success",
            "code" => 0
        ]);
    }


    public function validation_url()
    {

    }

    public function confirmation_url()
    {

    }

    /**
     * @return Mpesa
     * @throws \Exception
     */
    public function simulate_c2b()
    {
        $rules = [
            "phone" => "required",
            "amount" => "required",
            "bill_ref_no" => "required",
        ];

        $data = [
            "phone" => \request("phone"),
            "amount" => \request("amount"),
            "bill_ref_no" => \request("bill_ref_no")
        ];

        $validator = validator()->make($rules, $data);

        if ($validator->fails()) {
            throw new \Exception($validator->errors());
        }

        return $this->mpesa->c2b_simulate($data['amount'], $data['phone'], $data['bill_ref_no']);
    }


}
