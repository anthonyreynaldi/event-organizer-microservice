<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
class api extends Controller
{
    public $url = "http://localhost:8001/login/";
    
    function curl($route) {
        $url = $this->url . $route;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_COOKIE, session_name() . '=' . session_id());

        $resp = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $header = ['Content-Type' => 'application/json; charset=utf-8'];

        return response($resp, $httpcode, $header);
    }

    function init() {
        return $this->curl("/");
    }

    function login(){
        return $this->curl("/staff");
    }
    function register(){
        //
    }
}
