<?php

namespace App\Http\Controllers;
use App\Messsage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

     $user= User::all();
     $message= DB::table('messages')
                  ->join('users','users.id','=','messages.sent_by')
                  ->select('messages.message','users.name','messages.created_at')
                  ->where('sent_to',Auth::User()->id)
                  ->get();
  
        return view('messages.index',['users' => $user],['messages'=> $message]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storemessage = Messsage::create([
          'sent_by' => $request->input('sent_by'),
          'sent_to' =>$request->input('sent_to'),
          'message' =>$request->input('message'),
        ]);
        if ($storemessage) {
         return back()->with('success','Message sent Successfully');
        }
        return back()->withInput()->with('error','Message not Sent');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
