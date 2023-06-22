<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class clientController extends Controller
{
    public function home()
    {
        return view('home');
    }
    public function add()
    {
        return view('/staff/addStaff');
    }
    public function edit()
    {
        return view('editProfile');
    }
    public function details()
    {
        return view('details');
    }
    public function makeOrder()
    {
        return view('makeOrder');
    }
    public function profile()
    {
        return view('profile');
    }
}
