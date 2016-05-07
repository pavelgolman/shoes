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
            'alias' => 'shoesImages'
        ));
        $this->hasOne('main_image_id', "\Models\ShoesImages", 'id', array(
            'alias' => 'mainImage'
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
    }

    public function hasAttribute(Attribute $attribute){
        foreach($attribute->group->attributes as $attr){
            foreach($attr->shoes as $shoes){
                if($shoes->id == $this->id){
                    return true;
                }
            }
        }

        return false;
    }
}