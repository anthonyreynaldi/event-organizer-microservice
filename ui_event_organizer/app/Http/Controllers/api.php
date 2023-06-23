<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
class api extends Controller
{
    public $url = "http://localhost:8001/login/";
    
    function curl($route,$data) {
        // $url = $this->url . $route;
        $username = $data['username'];
        $password = $data['password'];
        $url = $data['url'];
        // $username = "tipen-stafff";
        // $password = "budak1";
        $datas = [
            'username' => $username,
            'password' => $password
        ];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datas));
        curl_setopt($curl, CURLOPT_COOKIE, session_name() . '=' . session_id());

        $resp = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $header = ['Content-Type' => 'application/json'];

        return response($resp, $httpcode, $header);
    }

    // function init() {
    //     return $this->curl("/");
    // }

    function login(Request $request){
        $jsonData = $request->all();
        // return response()->json(['message' => $jsonData]);
        return $this->curl("staff",$jsonData);
    }
    function register(){
        //
    }
}
