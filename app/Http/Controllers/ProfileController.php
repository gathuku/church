<?php
namespace App\Http\Controllers\ProfileController;
namespace App\Http\Controllers;
Use App\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


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
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {

        if (Auth::check()) {
          //$profile=Profile::where('user_id',Auth::user()->id)->get();
          $user=Profile::where('id', Auth::user()->id)->get();
          return view('profile.edit',['users'=>$user]);
        }

        return view('auth.login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {

      $userupdate=User::where('id',Auth::user()->id)->update([
        'name' =>$request->input('name'),
        'member_no' =>$request->input('member_no'),
        'category' =>$request->input('category'),
        'gender' =>$request->input('gender'),
        'phone' =>$request->input('phone'),
         'birth_date' =>$request->input('birth_date'),
      ]);


      if ($userupdate) {
        return redirect()->route('profile.show',['profiles'=>$profile])
        ->with('sucess','Details Updated Successfully');
      }
      return back()->withInput()->with('error',"Details couldn't be updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
