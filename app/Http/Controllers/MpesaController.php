<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\User;

class MpesaController extends Controller
{
    //

    //get user Information
    //phoneNumber=Auth::user()->phone;
   // userName=Auth::user()->name;


      public function runMpesa(){
       $this->get_access_token();
       }


//Fucnction for getting the acess token
    public function get_access_token(){
	$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

	   //   $consumerKey='aR7R09zePq0OSfOttvuQDrfdM4n37i0C';
	    //  $consumerSecret='F9AebI6azDlRjLiR';

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			$credentials = base64_encode('aR7R09zePq0OSfOttvuQDrfdM4n37i0C:F9AebI6azDlRjLiR');
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			
           curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        

			$curl_response = curl_exec($curl);

			$response= json_decode($curl_response);
			
			  $token=$response->access_token;

			
			//return($token);
			  $this->lipaNaMpesaOnline($token);


    }


    public function lipaNaMpesaOnline($acess_token){
      
       $lipaNaMpesapassKey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
       $partyA='254705112855';
       $partyB='174379';
       $amount='5';


       $timestamp  = date( 'YmdHis' );

        $Password=base64_encode($partyB.$lipaNaMpesapassKey.$timestamp);

		$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$acess_token)); //setting custom header


		$curl_post_data = array(
		  //Fill in the request parameters with valid values
		  'BusinessShortCode' => $partyB,
		  'Password' => $Password,
		  'Timestamp' => $timestamp,
		  'TransactionType' => 'CustomerPayBillOnline',
		  'Amount' => $amount,
		  'PartyA' => $partyA,
		  'PartyB' => $partyB,
		  'PhoneNumber' => $partyA,
		  'CallBackURL' => 'https://1fdbf705.ngrok.io/callback',
		  'AccountReference' => $partyA,
		  'TransactionDesc' => 'Tithe payment '
		);

		$data_string = json_encode($curl_post_data);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($curl, CURLOPT_HEADER, false);


		$curl_response = curl_exec($curl);
		//print_r($curl_response);

		//dump($curl_response);
         $response=json_decode($curl_response);

         $responsecode=$response->ResponseCode;
         $responsedesc=$response->ResponseDescription;

         if ($responsecode=0) {
         	//display a success message
         }

        // dump('completed proccessing');

         //event(new payRequestSent());

         $this->getDataFromCallback();
    }




 

    public function getDataFromCallback(){
    	//$data=json_decode(file_get_contents('https://1fdbf705.ngrok.io/callback'));
        $data=file_get_contents('php://input');

        //dump($data);
        dd($data);

       // Log::info("payload =>", $request->all());

    }
  
}
