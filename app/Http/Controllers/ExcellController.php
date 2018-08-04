<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tithe;
use Excel;
use Mail;
use Session;
use App\subscribe;
class ExcellController extends Controller
{
    public function usersexport(){


      $users=User::all();

      return Excel::download($users,'users.xlsx');

    }


    public function tithesexport(){
      return Excel::download(Tithe::all(),'Tithe.xlsx');
    }


    //send email function

    public function sendemail(Request $request){
         
         $data = array(
         	'name' => $request ->name,
         	'email' =>$request->email,
         	'subject' =>$request->subject,
         	'bodymessage' =>$request->message,

         	 );

         Mail::send('emails.messages', $data, function($message) use ($data){
         	$message -> from($data['email']);
         	$message -> to('info@servanthoodcentre.com');
         	$message -> subject($data['bodymessage']);


         } );


         Session::flash('success','Email sent Suceessfully. Thankyou');

         return redirect('/');
    }


    public function subscribe(Request $request){
        $name=$request->name;
        $email=$request->email;

        $storeSubscription=subscribe::create([
          'name' =>$name,
          'email' => $email,
        ]);

        if($storeSubscription){

            Session::flash('success','Subscription  sent Suceessfully. Thankyou');
            return redirect('/');
        }
    }

}


//https://www.youtube.com/watch?v=Qd6q22-ndxk
