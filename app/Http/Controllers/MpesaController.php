<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


use App\User;
use App\Transaction;

use Session;

class MpesaController extends Controller
{
    //

    //get user Information
    public $partyA;
    public $userName;
    public $amount;

   //Constructor

	public function __construct(){
		//Assingn constants
     
	}

	//Get initiatio data
    public function runMpesa(Request $request){

    	/* $this->partyA=Auth::user()->phone;
         $this->userName=Auth::user()->name;
         $this->amount=$request->amount;

         //validate Phone Numer and Amount;
         if ($this->amount<0) {
         	Session::flash('error','Amount must Be Greater Than 1');
         }*/

       $this->get_access_token();

           //return back()->withInput();
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

			
			
			 // $this->lipaNaMpesaOnline($token);
			  $this->registerC2BUrls($token);
			  $this->simulateC2B($token);


    }


    public function lipaNaMpesaOnline($acess_token){
      
       $lipaNaMpesapassKey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
      // $partyA='254705112855';
       $partyB='174379';
      // $amount='1';


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
		  'Amount' => $this->amount,
		  'PartyA' => $this->partyA,
		  'PartyB' => $partyB,
		  'PhoneNumber' => $this->partyA,
		  'CallBackURL' => 'https://e679b7ff.ngrok.io/api/callback',
		  'AccountReference' => $this->partyA,
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
          
          Session::flash('success',$responsedesc);

      // return back();
    }




 

    public function getDataFromCallback(Request $request){
    	\Log::info('receiving call back');
     \Log::info($request->getContent());

     $data=$request->getContent();
    // $this->callBackCode=$data->ResultCode;
   	$data = json_decode($data);
	$tmp = $data->Body->stkCallback;
	$master = array();
	foreach($data->Body->stkCallback->CallbackMetadata->Item as $item){
		$item = (array) $item;
		$master[$item['Name']] = ((isset($item['Value'])) ? $item['Value'] : NULL);
		
	}
	$master = (object) $master;
	$master->ResultCode = $tmp->ResultCode;
	$master->MerchantRequestID = $tmp->MerchantRequestID;
	$master->CheckoutRequestID = $tmp->CheckoutRequestID;
	$master->ResultDesc = $tmp->ResultDesc;

	//get data from master array
	$resultcode=$master->ResultCode;
	$resultDesc=$master->ResultDesc;
	$amount=$master->Amount;
	$MpesaReceiptNumber=$master->MpesaReceiptNumber;
	$TransactionDate=$master->TransactionDate;
	$PhoneNumber=$master->PhoneNumber;

      if ($resultcode==0) {
      	//save to database
      	 $this->saveTransaction($amount,$MpesaReceiptNumber,$TransactionDate,$PhoneNumber);
      	 Session::flash('success','Sucessful, Saving to Database');
      }
         
      //return a description to views
     
    }

    public function saveTransaction($amount,$MpesaReceiptNumber,$TransactionDate,$phoneNumber){
       //\Log::info('Ready to cancel Transaction');
        
        //Logic to save to database Using Eloquent ORM

        $savetransaction=Transaction::create([
             'amount' => $amount,
             'receipt_no' =>$MpesaReceiptNumber,
             'transaction_date' =>$TransactionDate,
             'phone_no' =>$phoneNumber
        ]);

        if ($savetransaction) {
            Session::flash('success','Completed Saving to Database');
        }
    }


    public function registerC2BUrls($acess_token){
    	$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$acess_token)); //setting custom header


			$curl_post_data = array(
			  //Fill in the request parameters with valid values
			  'ShortCode' => '174379',
			  'ResponseType' => 'Completed',
			  'ConfirmationURL' => 'https://a12c6853.ngrok.io/api/confirmationurl',
			  'ValidationURL' => 'https://a12c6853.ngrok.io/api/validationurl'
			);

			$data_string = json_encode($curl_post_data);

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

			$curl_response = curl_exec($curl);
			print_r($curl_response);

         echo $curl_response;
    }


    public function simulateC2B($acess_token){

			  $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

			  $curl = curl_init();
			  curl_setopt($curl, CURLOPT_URL, $url);
			  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$acess_token)); //setting custom header


			  $curl_post_data = array(
			          //Fill in the request parameters with valid values
			         'ShortCode' => '174379',
			         'CommandID' => 'CustomerPayBillOnline',
			         'Amount' => '1',
			         'Msisdn' => '254705112855',
			         'BillRefNumber' => '00000'
			  );

			  $data_string = json_encode($curl_post_data);

			  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			  curl_setopt($curl, CURLOPT_POST, true);
			  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

			  $curl_response = curl_exec($curl);
			  print_r($curl_response);

			  echo $curl_response;
			  \Log::info('waiting for response');
	 }


	 public function receiveresponse(Request $request){
	 	return response()->json([
       'C2BPaymentConfirmationResult' => 'Success'
     ]);
	 }
  
}
