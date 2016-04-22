<?php

namespace Multiple\Backend\Models;

use Phalcon\Mvc\Model;

class Categories extends Model
{

    public $int;

    public $name;

    public $parent_id;

    public $order_number;
}