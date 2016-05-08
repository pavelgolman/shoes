<?php

namespace Models;

use Phalcon\Mvc\Model;
use Phalcon;

class ShoesDescriptions extends Model
{

    public $shoes_id;

    public $description;

    public function initialize(){

        $this->hasOne('shoes_id', "\Models\Shoes", 'id', array(
            'alias' => 'shoes'
        ));

    }


}