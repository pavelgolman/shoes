<?php

namespace Models;

use Phalcon\Mvc\Model;
use Phalcon;

class ShoesDescriptions extends Model
{

    public $shoes_id;

    public $description;

    public function initialize(){
        $this->belongsTo("shoes_id", "\Models\Shoes", "id");

    }


}