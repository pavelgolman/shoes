<?php

namespace Models;

use Phalcon\Mvc\Model;
use Phalcon;

class AttributesGroups extends Model
{

    public $int;

    public $name;

    public $const;

    CONST MATERIAL = 'MATERIAL';
    CONST SEASON = 'SEASON';
    CONST COLLECTION = 'COLLECTION';
    CONST SIZE = 'SIZE';
    CONST BASE = 'BASE';
    CONST TYPE = 'TYPE';
    CONST IN_STOCK = 'IN STOCK';

    public function initialize()
    {
        $this->hasMany("id", "\Models\Attributes", "attributes_group_id",  array(
            'alias' => 'attributes'
        ));
    }
}