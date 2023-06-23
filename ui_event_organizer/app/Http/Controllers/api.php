<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
class api extends Controller
{
    // public $url = "http://localhost:8001/login/";
    public $baseUrl = "http://localhost";
    
    function curl($route, $method, $data) {
        // $url = $this->url . $route;
        $url = $this->baseUrl . $route;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_COOKIE, session_name() . '=' . session_id());

        if($method == "post"){
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }else if($method == "put"){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $resp = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $header = ['Content-Type' => 'application/json'];

        return response($resp, $httpcode, $header);
    }

    function index(Request $request){
        $jsonData = $request->all();
        $route = $jsonData['url'];
        $method = $request->method();

        unset($jsonData['url']);
        return $this->curl($route, $method, $jsonData);
    }
}
