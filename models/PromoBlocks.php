<?php

namespace Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;

class PromoBlocks extends Model
{

    public $int;

    public $name;

    public $const;

    CONST SALE_OFF = 'SALE_OFF';
    CONST FEATURED = 'FEATURED';
    CONST BESTSELLER = 'BESTSELLER';

    CONST SPRING_SUMMER = 'SPRING_SUMMER';
    CONST AUTUMN_WINTER = 'AUTUMN_WINTER';

    //САНДАЛИИ
    CONST CATEGORY_SANDALS = 'CATEGORY_SANDALS';
    //ТУФЛИ
    CONST CATEGORY_SHOES = 'CATEGORY_SHOES';
    //БОТИНКИ
    CONST CATEGORY_BOOTS = 'CATEGORY_BOOTS';
    //КРОССОВКИ, КЕДЫ
    CONST CATEGORY_SNEAKERS = 'CATEGORY_SNEAKERS';
    //САБО
    CONST CATEGORY_SABO = 'CATEGORY_SABO';
    //САПОГИ
    CONST CATEGORY_HIGH_BOOT = 'CATEGORY_HIGH_BOOT';

    public function initialize()
    {
        $this->hasManyToMany(
            "id",
            "\Models\PromoBlocksShoes",
            "promo_blocks_id",
            "shoes_id",
            "\Models\Shoes",
            "id",
            array(
                'alias' => 'shoes',
                'params' => array(
                    //'order' => 'order_index ASC'
                )
            )
        );
    }
}