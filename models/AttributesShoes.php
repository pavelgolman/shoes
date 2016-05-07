<?php

namespace Models;

use Phalcon\Mvc\Model;
use Phalcon;

class AttributesShoes extends Model
{

    public $id;

    public $shoes_id;

    public $attributes_id;

    public function initialize(){
        $this->belongsTo("shoes_id", "Shoes", "id");
        $this->belongsTo("attributes_id", "Attributes", "id");
    }


}