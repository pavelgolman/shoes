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
        $shoes_id = $image->shoes_id;
        if (!$image) {
            //$this->flashSession->error("Обувь не найдена");
            return $this->response->redirect("admin/shoes/edit/".$shoes_id);
        }
        if (!$image->delete()) {
            foreach($image->getMessages() as $message) {
                //$this->flashSession->error($message);
            }
        } else {
            //$this->flashSession->success("Обувь удалена");
        }
        return $this->response->redirect("admin/shoes/edit/".$shoes_id);
    }


}