<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

	public function indexAction()
	{
        $this->view->title_for_page = 'Интернет-магазин обуви mnogoobuvi — купить обувь недорого онлайн в наличии и под заказ';

        $this->view->meta_description = 'Обувь по выгодным ценам. Коллекции модной обуви ждут Вас в интернет-магазине mnogoobuvi. Доставка по всей Украине. Оформите заказ онлайн прямо сейчас!';
	}

}
