<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageID extends Model
{
    use HasFactory;

    protected $table = 'image_ids';

    public $timestamps = false;


    function saveImage($image_id){
        $image = new ImageID();
        $image->api_token = session()->get('api_token');
        $image->image_id = $image_id;
        $image->request_count = 0;
        $image->save();
    }
}
