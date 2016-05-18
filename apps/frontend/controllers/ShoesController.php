<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ShoesController extends Controller
{

    public function indexAction()
    {
        $this->view->filter = $this->request->get('filter');
        $GLOBALS['filter'] = $this->view->filter;
        $currentPage = 1;

        $shoes      = \Models\Shoes::find()->filter(
            function ($s) {
                foreach($GLOBALS['filter'] as $filter_attribute_id => $v){
                    $exists = false;
                    foreach($s->attributesShoes as $attribute){
                        if($filter_attribute_id == $attribute->id){
                            $exists = true;
                            break;
                        }
                    }
                    if(!$exists){
                        return null;
                    }
                }
                return $s;
            }
        );

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
