<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'category' =>'',
            'member_no' =>'integer',
            'sex' =>'',
            'phone' =>'string',
            'birth_date' =>'date',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      dump($data);
        $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],

            'password' => Hash::make($data['password']),
            'category' => $data['category'],
            'member_no' => $data['member_no'],
            'sex' => $data['sex'],
            'phone' => $data['phone'],
            'birth_date' =>$data['birth_date'],
        ]);

         return $user;


    }

  public function index(Request $request)
  {
/*
    $user=User::create([

              'category' =>$request->input('category'),
              'member_no' =>$request->input('member_no'),
             'sex' =>$request->input('sex'),
             'phone' =>$request->input('phone'),
             'birth_date' =>$request->input('birth_date'),
    ]);
    dd($user);
    */

  }
}
