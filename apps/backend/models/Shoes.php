<?php

namespace Multiple\Backend\Models;

use Phalcon\Mvc\Model;

class Shoes extends Model
{

    public $id;

    public $image_original;



    public function initialize()
    {
        $this->belongsTo("shoes_id", "Shoes", "id");
    }
}