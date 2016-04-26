<?php

namespace Models;

use Phalcon\Mvc\Model;

class PromoBlocks extends Model
{

    public $int;

    public $name;

    public $const;

    CONST SALE_OFF = 'SALE_OFF';
    CONST FEATURED = 'FEATURED';
    CONST BESTSELLER = 'BESTSELLER';
    CONST CATEGORY_ = 'SALE_OFF';

    public function initialize()
    {
        $this->hasMany("id", "\Models\PromoBlocksShoes", "promo_blocks_id",  array('alias' => 'shoes'));
    }
}