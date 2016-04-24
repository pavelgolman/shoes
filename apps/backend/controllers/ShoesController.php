<?php

namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;
use Models\Shoes;
use Multiple\Backend\Forms\ShoesForm;

class ShoesController extends Controller
{

    public function indexAction()
    {

    }

    public function editAction($id)
    {
        $shoes = Shoes::findFirst($id);
        if (!$shoes) {
            $this->flashSession->error("Обувь не найдена");

            return $this->forward("shoes/index");
        }

        $this->view->form = new ShoesForm($shoes);
    }

    public function createAction()
    {
        $shoes = new Shoes();
        $this->view->form = new ShoesForm($shoes);
    }

    public function saveAction()
    {
        $shoes = new Shoes();
        if ($this->request->isPost()) {
            $shoes->assign(array(
                'id' => $this->request->getPost('id'),
                'name' => $this->request->getPost('name'),
                'article' => $this->request->getPost('article'),
                'price' => $this->request->getPost('price'),
            ));
            if (!$shoes->save()) {
                foreach($shoes->getMessages() as $message) {
                    $this->flashSession->error($message);
                }
                if($shoes->id){
                    return $this->dispatcher->forward(array(
                        "action" => "edit",
                        "params" => array("id" => $shoes->id)
                    ));
                }
                return $this->dispatcher->forward(array(
                    "action" => "create"
                ));
            } else {
                $this->flashSession->success("Обувь сохранена");
                return $this->dispatcher->forward(array(
                    "action" => "edit",
                    "params" => array("id" => $shoes->id)
                ));
            }
        }
    }

    public function uploadAction()
    {
        if($this->request->hasFiles() == true){
            $uploads = $this->request->getUploadedFiles();
            $isUploaded = false;
            #do a loop to handle each file individually
            foreach($uploads as $upload){
                $image = new Models\ShoesImages();
                $image->generateUniqueHash();
                $image->upload_date_year = date('Y');
                $image->upload_date_month = date('m');
                $image->upload_date_day = date('d');
                $image->extension = $upload->getExtension();
                $image->save();
                if (is_dir($image->originalPath()) == false)
                {
                    mkdir($image->originalPath(false), 0777, true); // Create directory if it does not exist
                }
                ($result = $upload->moveTo($image->originalPath())) ? $isUploaded = true : $isUploaded = false;

            }
            ($isUploaded) ? die('Files successfully uploaded.') : die('Some error ocurred.');
        }else{
            die('You must choose at least one file to send. Please try again.');
        }
    }

}
