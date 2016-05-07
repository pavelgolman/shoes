<?php

namespace Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;

class Attributes extends Model
{

    public $int;

    public $name;

    public $attributes_group_id;

    public function initialize()
    {
        $this->belongsTo("attributes_group_id", "AttributesGroups", "id",
            array(
                'alias' => 'group'
            ));

        $this->hasManyToMany(
            "id",
            "\Models\AttributesShoes",
            "attributes_id",
            "shoes_id",
            "\Models\Shoes",
            "id",
            array(
                'alias' => 'shoes'
            )
        );
    }


}