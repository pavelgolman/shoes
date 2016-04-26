<?php

namespace Models;

use Phalcon\Mvc\Model;

class Shoes extends Model
{

    public $id;

    public $name;

    public $article;

    public $price;

    public $main_image_id;

    public function initialize()
    {
        //$this->hasMany("id", "\Models\ShoesImages", "shoes_id",  array(
        //    'alias' => 'shoesImages'
        //));
        $this->hasOne('main_image_id', "\Models\ShoesImages", 'shoes_id', array(
            'alias' => 'image'
        ));
    }
}