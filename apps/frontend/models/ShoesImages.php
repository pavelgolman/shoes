<?php

namespace Multiple\Frontend\Models;

use Phalcon\Mvc\Model;

class ShoesImages extends Model
{

    public $shoes_id;

    public $image_original;

    public $storage_id;

    public $extension;

    public function initialize()
    {
        $this->hasMany("id", "ShoesImages", "shoes_id");
    }

    public function thumbnailURL($width, $height){
        return APP_PATH."public/images/shoes/".$this->shoes_id.'/'.$this->storage_id.'/'.$width.'_'.$height.'.'.$this->extension;
    }
}