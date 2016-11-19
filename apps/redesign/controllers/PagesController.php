<?php

namespace Multiple\Redesign\Controllers;

use Phalcon\Mvc\Controller;

class PagesController extends Controller
{

    public function contactAction()
    {
        if ($this->request->isPost()) {
            //
            mail ( 'rumi.shoes@gmail.com' , 'Сообщение от: '.$this->request->getPost('name').' '.$this->request->getPost('email') , $this->request->getPost('message'));
        }
    }

}
