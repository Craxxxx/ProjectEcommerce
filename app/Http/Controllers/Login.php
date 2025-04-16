<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Login extends Controller
{
    //return the login view
    public function index()
    {
        return view('login');
    }
    

    
}
