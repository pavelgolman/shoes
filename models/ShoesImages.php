<?php

namespace Models;

use Phalcon\Mvc\Model;
use Phalcon;

class ShoesImages extends Model
{

    public $shoes_id;

    public $storage_id;

    public $extension;

    public $upload_date_year;

    public $upload_date_month;

    public $upload_date_day;

    public function initialize(){
        $this->belongsTo("shoes_id", "Shoes", "id");
    }

    public function originalPath($withName = true){
        $path = UNSORTED_IMAGES_PATH.$this->upload_date_year.'/'.$this->upload_date_month.'/'.$this->upload_date_day.'/';
        if($withName) {
            return $path.$this->storage_id . '.' . $this->extension;
        }
        return $path;
    }

    public function thumbnailURL($width, $height){
        //return APP_PATH."public/images/shoes/".$this->shoes_id.'/'.$this->storage_id.'/'.$width.'_'.$height.'.'.$this->extension;
        return PUBLIC_UPLOADS_PATH.$this->upload_date_year.'/'.$this->upload_date_month.'/'.$this->upload_date_day.'/'.$this->storage_id . '.' . $this->extension;
    }

    public function generateUniqueHash(){
        $this->storage_id = Phalcon\Text::random(Phalcon\Text::RANDOM_ALNUM, 8);
    }
}