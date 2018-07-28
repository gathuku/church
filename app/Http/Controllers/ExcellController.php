<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tithe;
use Excel;

class ExcellController extends Controller
{
    public function usersexport(){


      $users=User::all();

      return Excel::download($users,'users.xlsx');

    }

    public function tithesexport(){
      return Excel::download(Tithe::all(),'Tithe.xlsx');
    }
}


//https://www.youtube.com/watch?v=Qd6q22-ndxk
