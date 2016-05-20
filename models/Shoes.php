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
        $this->hasMany("id", "\Models\ShoesImages", "shoes_id",  array(
            'alias' => 'images'
        ));
        $this->hasOne('main_image_id', "\Models\ShoesImages", 'id', array(
            'alias' => 'mainImage'
        ));

        $this->belongsTo("id", "\Models\ShoesDescriptions", "shoes_id", array(
            'alias' => 'description'
        ));


        $this->hasMany("id", "\Models\AttributesShoes", "shoes_id",  array(
            'alias' => 'attributesShoes'
        ));

        $this->hasManyToMany(
            "id",
            "\Models\AttributesShoes",
            "shoes_id",
            "attributes_id",
            "\Models\Attributes",
            "id",
            array(
                'alias' => 'attributes'
            )
        );

        $this->hasManyToMany(
            "id",
            "\Models\PromoBlocksShoes",
            "shoes_id",
            "promo_blocks_id",
            "\Models\PromoBlocks",
            "id",
            array(
                'alias' => 'blocks'
            )
        );
    }

    public function hasAttribute(Attributes $attribute){
        return $this->hasAttributeId($attribute->id);
    }

    public function hasAttributeId($attribute_id){
        foreach($this->attributesShoes as $attributesShoes){
            if($attributesShoes->attributes_id == $attribute_id){
                return true;
            }
        }

        return false;
    }


    public function belongsToPromoBlock(PromoBlocks $block){
        return $this->belongsToPromoBlockId($block->id);
    }

    public function belongsToPromoBlockId($block_id){
        foreach($this->blocks as $block){
            if($block->promo_block_id == $block_id){
                return true;
            }
        }

        return false;
    }
}