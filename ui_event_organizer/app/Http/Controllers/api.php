<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
class api extends Controller
{
    // public $url = "http://localhost:8001/login/";
    public $baseUrl = "http://192.168.43.73";
    
    function curl($route, $method, $data) {
        // $url = $this->url . $route;
        $url = $this->baseUrl . $route;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_COOKIE, session_name() . '=' . session_id());

        if($method == "POST"){
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }else if($method == "PUT"){
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
    function setSession(Request $request){
        $jsonData = $request->all();

        session($jsonData);

        $header = ['Content-Type' => 'application/json'];

        return response(json_encode("session set"), 200, $header);
    }
    function getSession(){
        $header = ['Content-Type' => 'application/json'];

        $resp = json_encode(session()->all());

        return response($resp, 200, $header);
    }
    function destroySession(){
        session()->flush();

        return redirect()->to("/");
    }
}
