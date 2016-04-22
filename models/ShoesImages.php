<?php

namespace Models;

use Phalcon\Mvc\Model;
use Phalcon\Text;

class ShoesImages extends Model
{

    public $shoes_id;

    public $image_original;

    public $storage_id;

    public $extension;

    public $upload_date_year;

    public $upload_date_month;

    public $upload_date_day;

    public function initialize(){
        $this->hasMany("id", "ShoesImages", "shoes_id");
    }

    public function originalPath(){
        return UNSORTED_IMAGES_PATH.$this->upload_date_year.'/'.$this->upload_date_month.'/'.$this->upload_date_day.'/'.$this->storage_id;
    }

    public function thumbnailURL($width, $height){
        return APP_PATH."public/images/shoes/".$this->shoes_id.'/'.$this->storage_id.'/'.$width.'_'.$height.'.'.$this->extension;
    }

    public function generateUniqueHash(){
        $this->storage_id = Phalcon\Text::random(Phalcon\Text::RANDOM_ALNUM, 8);
    }
}