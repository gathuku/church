<?php

namespace App\Http\Controllers;
use App\User;
use Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (Auth::check()) {
        //$profile=Profile::where('user_id',Auth::user()->id)->get();
        $user=User::where('id', Auth::user()->id)->get();
        return view('profile.show',['users'=>$user]);
      }
      return view('auth.login');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      if (Auth::check()) {
        //$profile=Profile::where('user_id',Auth::user()->id)->get();
        $user=User::where('id', Auth::user()->id)->get();
        return view('profile.show',['users'=>$user])
        ->with('success','Details Updated Successfully');
      }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update_avatar(Request $request)
     {


       //https://www.youtube.com/watch?v=jy2SUxx6uHc
            if ($request->hasFile('avatar')) {
              $avatar=$request->file('avatar');
              $filename=time().'.'.$avatar->getClientOriginalExtension();
              Image::make($avatar)->resize('300,300')->save(public_path('/uploads/avatars/'.$filename));

              $user=Auth::user();
              $user->avatar=$filename;
              $user->save();


            Session::flash('success','Image changed Successfully');
            }
          $userprofile=User::where('id', Auth::user()->id)->get();

          return view('profile.edit',['users'=>$userprofile]);
     }

    public function edit($id)
    {
      if (Auth::check()) {

        $user=User::where('id', Auth::user()->id)->get();
        return view('profile.edit',['users'=>$user]);
      }

      return view('auth.login');
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
      $userupdate=User::where('id',Auth::user()->id)->update([
        'name' =>$request->input('name'),
        'member_no' =>$request->input('member_no'),
        'category' =>$request->input('category'),
        'sex' =>$request->input('gender'),
        'phone' =>$request->input('phone'),
         'birth_date' =>$request->input('birth_date'),
      ]);


      if ($userupdate) {
        return redirect()->back()->with('success','Details Updated Successfully');
        //return redirect()->route('profile.show','id');

      }
      return back()->withInput()->with('error',"Details couldn't be updated");
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
