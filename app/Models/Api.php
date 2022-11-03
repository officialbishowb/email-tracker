<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Api extends Model
{
    use HasFactory;


    protected $table = 'tokens';

    /**
     * Check if $date_two is greater than $date_one
     * @param string $date_one the first date in format Y-m-d H:i:s
     * @param string $date_two the second date in format Y-m-d H:i:s to check if it is greater
     * @return boolean true if the second date is greater than the first date else false
     */
    function compareDate($date_one, $date_two){


        if ($date_one == null) $date_one = date("Y-m-d H:i:s");

        $date_one = strtotime($date_one);
        $date_two = strtotime($date_two);

        if($date_two > $date_one){
            return true;
        }
        return false;
    }

    /**
     *  Generate an unique API token
     * @param string $type the type of token it should generate free/premium
     * @return string the unique token
     */
    function genApiToken($type){
        $signature = $type == "free" ? "ZnJlZXN1Yg" : "cHJlbWl1bXN1Yg";
        $token = $signature.bin2hex(random_bytes(20));
        $token_info = Api::where('token',$token)->first();
        if($token_info){
            $this->genApiToken($type);
        }
        return $token;
    }




    /**
     * Validate the give token
     */
    function validateToken($token){
        $token_info = Api::where('token',$token)->first();
        if($token_info){
            if($this->compareDate(date("Y-m-d H:i:s"), $token_info->valid_until)){
                session()->put(["api_token"=>$token_info->token]); // Set the api token in session for future use
                return ['success'=>true,'message'=>"The given API token is valid!"];
            }else{
                return ['success'=>false,'message'=>"The given API token has expired!"];
            }
        }
        return ['success'=>false,'message'=>"The given API token is invalid!"];;
    }

    /**
     * Generate an unique image id
     */
    function generateImageId($api_token){
        $token_info = Api::where('token',$api_token)->first();
        if($token_info){
            $image_id = bin2hex(random_bytes(20));
            $image_id_info = ImageID::where('image_id',$image_id)->first();
            if($image_id_info){
                $this->genImageId($api_token);
            }
            $image = new ImageID();
            $image->saveImage($image_id); // Save the new generated image ID
            return ['success'=>true,'message'=>'Generating an image with it...','image_id'=>$image_id];
        }
        return ['success'=>false,'message'=>"Invalid token. Please clear your cookies, refresh the page and try it again!"];
    }


    /**
     * Update the count of the image id
     * @param string $image_id the id of the image whose request_count should be updated to +1
     */

    function updateCount($imageID){
        $image_id_info = ImageID::where('image_id',$imageID)->first();
        if($image_id_info){
            $image_id_info->request_count = $image_id_info->request_count + 1;
            $image_id_info->updated_at = now();
            $image_id_info->save();
        }
    }

    /**
     * Start the counter by reseting the request_count to 0
     * @param string $imageID the imageId whose request_count should be set to 0
     */
    function startTracking($imageID){
        Log::info($imageID);
        $image_id_info = ImageID::where('image_id',$imageID)->first();
        Log::info($image_id_info);
        if($image_id_info){
            $image_id_info->request_count = 0;
            $image_id_info->updated_at = now();
            $image_id_info->save();
        }
    }
}
