<?php
/**
 * Created by PhpStorm.
 * User: ayimdomnic
 * Date: 07/08/2018
 * Time: 13:26
 */

namespace App\Gateways;


class Mpesa
{
    protected $payload = [];
    protected $access_token;
    protected $response;
    protected $transaction_type;
    protected $expires_in = null;
    protected $authed_at = null;

    const CONFIRMATION_URL = "https://someurl.com/api/confirm";
    const VALIDATION_URL = "https://someurl.com/api/validate";

    /**
     * Always boot the class with checking the auth status before any process
     * if the token is valid the excecute the required method
     *
     * Mpesa constructor.
     * @param bool $auth
     * @throws \Exception
     */
    public function __construct($auth = true)
    {
        if ($auth)
            $this->auth();
    }

    /**
     * Get the Mpesa Auth TOken
     * Todo::find away to persist it on cache storage or session
     * @return $this
     * @throws \Exception
     */
    public function auth()
    {
        if ($this->is_authed()) {
            return $this;
        }

        $url = $this->get_url_for('auth');

        $credentials = base64_encode( env('consumer_key') . ':' . env('consumer_secret'));

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "authorization: Basic {$credentials}",
                "cache-control: no-cache",
            ]
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err)
            throw new \Exception($err);

        try {
            $result = json_decode($response, true);
            $this->authed_at = time();
            $this->access_token = $result['access_token'];
            $this->expires_in = $result['expires_in'];

            return $this;
        } catch (\Exception $e) {
            throw $e;
        }
    }


    /**
     * When registering the Mpesa Urls Get the urls
     * This function prepares the payload
     *
     * @param string $validation_url
     * @param string $confirmation_url
     * @return Mpesa
     */
    public function register_url($validation_url = Mpesa::VALIDATION_URL, $confirmation_url = Mpesa::CONFIRMATION_URL)
    {
        $this->transaction_type = __FUNCTION__;
        $this->payload = [
            "ShortCode" => env('c2b_shortcode', 00000),
            "ResponseType" => "Cnacelled",
            "ConfirmationURL" => $confirmation_url,
            "ValidationURL" => $validation_url,
        ];

        return $this;
    }


    /**
     *
     * Simulate a C2B transaction
     * @param $amount
     * @param $msisdn
     * @param $bill_ref_number
     * @return $this
     */
    public function c2b_simulate($amount, $msisdn, $bill_ref_number)
    {
        $this->transaction_type = __FUNCTION__;
        $this->payload = [
            'ShortCode' => env("c2b_shortcode"),
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'Msisdn' => $msisdn,
            'BillRefNumber' => $bill_ref_number
        ];

        return $this;
    }


    /**
     * Send All Requests to Safaricom for processing
     *
     * @return mixed
     */
    public function send()
    {
        $url = $this->get_url_for($this->transaction_type);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl,
            CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            "Authorization:Bearer {$this->access_token}"
        ]); //setting custom header


        $curl_post_data = $this->payload;

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);

        return json_decode($curl_response, true);
    }

    /**
     * Fetch a url for the API Action Required
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get_url_for($key, $default = null)
    {
        if (!env('application_status')) {
            $urls = [
                'auth' => 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials',
                'register_url' => 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl',
                'c2b_simulate' => 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate'
            ];
        } else {
            $urls = [
                'auth' => 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials',
                'register_url' => 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl',
                'c2b_simulate' => 'https://api.safaricom.co.ke/mpesa/c2b/v1/simulate'
            ];
        }

        return array_get($urls, $key, $default);
    }

    public function getTransactionType()
    {
        return $this->transaction_type;
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Check if the generated Token is still Valid
     * @return bool
     */
    public function is_authed() : bool
    {
        if(!$this->access_token)
            return false;

        return time() < ($this->authed_at + $this->expires_in);
    }

    /**
     * @param $msisdn
     * @param $amount
     * @return Mpesa
     */
    public function stk($msisdn, $amount)
    {
        $this->transaction_type = __FUNCTION__;
        $this->payload = [
            'BusinessShortCode' => env('c2b_shortcode'),
            'Password' => env("passkey"),
            'Timestamp' => time(),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $msisdn,
            'PartyB' => env("c2b_shortcode"),
            'PhoneNumber' => $msisdn,
            'CallBackURL' => 'https://e679b7ff.ngrok.io/api/callback',
            'AccountReference' => $msisdn,
            'TransactionDesc' => 'Tithe payment '
        ];

        return $this;
    }

}