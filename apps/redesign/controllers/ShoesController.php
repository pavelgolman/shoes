<?php

namespace Multiple\Redesign\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ShoesController extends Controller
{

    public function indexAction()
    {
        $this->view->filter = $this->request->get('filter');
        $currentPage = 1;

        $shoes      = \Models\Shoes::find(array(
            "conditions" => "is_hidden = 0",
            'order' => 'order_index ASC'
        ));

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
        if($id > 198545){
            $id = $id - 198545;
        }

        $this->view->shoes = \Models\Shoes::findFirst($id);


        $this->view->featured = \Models\Shoes::find(array(
            "conditions" => "is_hidden = 0",
            'order' => 'RAND()',
            "limit" => 16
        ));

        $this->view->title_for_page = $this->view->shoes->name.' в Днепропетровск, цена — купить в интернет-магазине RUMI';

        $this->view->og_url = 'http://rumi.store'.$this->view->shoes->getURL();
        $this->view->og_title = $this->view->title_for_page;
        $this->view->og_image = 'http://rumi.store'.$this->view->shoes->mainImage->originalURL();

        $this->view->meta_description = $this->view->shoes->name.' по лучшей цене в Днепропетровске. Огромный выбор обуви ждет Вас в интернет-магазине RUMI. Доставка по всей Украине. Оформите заказ онлайн прямо сейчас!';
        $this->view->og_description = $this->view->meta_description;
    }

}
