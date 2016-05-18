<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ShoesController extends Controller
{

    public function indexAction()
    {
        $this->view->filter = $this->request->get('filter');
        $currentPage = 1;

        $shoes      = \Models\Shoes::find();

        $paginator   = new PaginatorModel(
            array(
                "data"  => $shoes,
                "limit" => 999,
                "page"  => $currentPage
            )
        );

        $this->view->shoes = $paginator->getPaginate();
    }

    public function viewAction($id){
        $this->view->shoes = \Models\Shoes::findFirst($id);


        $this->view->featured = \Models\Shoes::find(array(
            'order' => 'RAND()',
            "limit" => 16
        ));
    }

}
