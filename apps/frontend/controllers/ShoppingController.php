<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ShoppingController extends Controller
{

    public function buyAction($id){
        $shoes = \Models\Shoes::findFirst($id);

        $to      = 'arseniy.golman@gmail.com';
        $subject = "Сделан заказ на '{$shoes->name}'";
        $message = "Заказ: '{$shoes->name}', артикул '{$shoes->article}'.";
        $headers = 'From: sale@rumi.store' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

}
