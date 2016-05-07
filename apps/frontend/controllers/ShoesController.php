<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ShoesController extends Controller
{

    public function indexAction()
    {
        $this->view->filter = $this->request->getPost('filter');

        $currentPage = 1;

        $shoes      = \Models\Shoes::find();

        $paginator   = new PaginatorModel(
            array(
                "data"  => $shoes,
                "limit" => 100,
                "page"  => $currentPage
            )
        );

        $this->view->shoes = $paginator->getPaginate();
    }

}
