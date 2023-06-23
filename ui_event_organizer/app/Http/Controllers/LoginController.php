<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if(session()->has("client_id")){
            return redirect()->to("/home");
        }else if(session()->has("staff_id")){
            return redirect()->to("/staff");
        }
        return view('login');
    }
}
