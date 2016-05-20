<?php

namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Models\Shoes;
use Models\ShoesImages;

class ShoesImagesController extends Controller
{

    public function deleteAction($image_id){
        $image = ShoesImages::findFirstById($image_id);
        if (!$image) {
            //$this->flashSession->error("Обувь не найдена");
            return $this->dispatcher->forward(array(
                'controller' => 'shoes',
                'action' => 'index'
            ));
        }
        if (!$image->delete()) {
            foreach($image->getMessages() as $message) {
                //$this->flashSession->error($message);
            }
        } else {
            //$this->flashSession->success("Обувь удалена");
        }
        return $this->dispatcher->forward(array(
            'controller' => 'shoes',
            'action' => 'index'
        ));
    }


}