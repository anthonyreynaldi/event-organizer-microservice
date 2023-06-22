<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class staffController extends Controller
{
    public function home()
    {
        return view('staff/home');
    }
    public function add()
    {
        return view('/staff/addStaff');
    }
    public function edit()
    {
        return view('/staff/editProfile');
    }
    public function details()
    {
        return view('/staff/details');
    }
    public function profile()
    {
        return view('staff/profile');
    }
}
