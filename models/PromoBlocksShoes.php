<?php

namespace Models;

use Phalcon\Mvc\Model;
use Phalcon;

class PromoBlocksShoes extends Model
{

    public $shoes_id;

    public $promo_blocks_id;

    public function initialize(){
        $this->belongsTo("shoes_id", "Shoes", "id");
        $this->belongsTo("promo_blocks_id", "PromoBlocks", "id");
    }


}