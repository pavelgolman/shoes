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
        $this->belongsTo("shoes_id", "\Models\Shoes", "id");

        $this->hasOne("id", "\Models\Shoes", "main_image_id", array(
            'alias' => 'mainImageIn'
        ));
    }

    public function originalPath($withName = true){
        $path = ORIGINALS_IMAGES_PATH.$this->shoes_id.'/';
        if($withName) {
            return $path.$this->storage_id . '.' . $this->extension;
        }
        return $path;
    }

    public function originalURL(){
        return PUBLIC_ORIGINALS_PATH.$this->shoes_id.'/'.$this->storage_id.'.'.$this->extension;
    }

    public function thumbnailURL($width, $height, $withName = true, $generateIfNotExists = true){
        $path = PUBLIC_THUMBNAILS_PATH.$this->shoes_id.'/'.$this->storage_id.'/';
        if($withName) {
            $path .= $width . '_' . $height . '.' . $this->extension;
        }
        if($generateIfNotExists && !file_exists(APP_PATH . 'public' . $path)){
            $this->reGenerateThumbnail($width, $height);
        }
        return $path;
    }

    public function generateUniqueHash(){
        $this->storage_id = Phalcon\Text::random(Phalcon\Text::RANDOM_ALNUM, 8);
    }

    public function reGenerateThumbnails(){
        global $SHOES_THUMBNAILS_MAP;
        foreach($SHOES_THUMBNAILS_MAP as $size){
            $this->reGenerateThumbnail($size['width'], $size['height']);
        }
    }

    public function reGenerateThumbnail($width, $height)
    {
        $image = new Phalcon\Image\Adapter\Imagick($this->originalPath());
        $image->resize($width, $height);

        $path = APP_PATH . 'public' . $this->thumbnailURL($width, $height, false);
        if (is_dir($path) == false) {
            mkdir($path, 0777, true);
        }
        if ($image->save(APP_PATH . 'public' . $this->thumbnailURL($width, $height, true, false))) {

        }
    }
}