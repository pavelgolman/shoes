<?php

namespace Multiple\Backend\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Check;
use Models\Shoes;

class ShoesForm extends Form
{
    public function initialize(Shoes $shoes)
    {
        $this->add(new Hidden("id"));

        $this->add(new Text("name"));

        $this->add(new Text("price"));

        $this->add(new Check("is_hidden"));
    }
}
