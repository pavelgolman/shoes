<?php

namespace Models;

use Phalcon\Mvc\Model;

class Shoes extends Model
{

    public $id;

    public $name;

    public $article;

    public $price;

    public function initialize()
    {
        //$this->belongsTo("shoes_id", "Shoes", "id");
    }
}