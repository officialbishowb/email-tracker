<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Api;
class ApiController extends Controller
{
    function validateToken(Request $request){
        $api = new Api();
        $token = $request->input('api_token');
        $response = $api->validateToken($token);
        return response()->json([$response]);
    }

    function generateImageId(){
        $api = new Api();
        $token = session()->get('api_token');
        $response = $api->generateImageId($token);
        return response()->json([$response]);
    }

    function viewImage(Request $request){
        $imageID = $request->input('imageID');
        $api = new Api();
        $imageID != "" ? $api->updateCount($imageID) : "";
        return view('image');
    }

    function startTracking(Request $request){
        $imageID = $request->input('imageID');
        $api = new Api();
        $api->startTracking($imageID);
        return response()->json(["Tracking started!"]);
    }
}
