<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ShoppingController extends Controller
{

    public function buyAction($id){
        $shoes = \Models\Shoes::findFirst($id);

        $to      = 'rumi.shoes@gmail.com, pavelgolman@gmail.com';

        $subject = "Сделан заказ на '{$shoes->name}'";
        $message = "Заказ: '{$shoes->name}'. Телефон: ".$this->request->getPost('phone');
        $headers = 'From: rumi.shoes@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        die();
    }

}
