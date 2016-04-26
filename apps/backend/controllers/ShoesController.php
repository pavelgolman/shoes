<?php

namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Models\Shoes;
use Models\ShoesImages;
use Multiple\Backend\Forms\ShoesForm;

class ShoesController extends Controller
{

    public function indexAction()
    {
        $this->view->shoes = Shoes::find();
    }

    public function editAction($id)
    {
        $shoes = Shoes::findFirst($id);
        if (!$shoes) {
            $this->flashSession->error("Обувь не найдена");

            return $this->forward("shoes/index");
        }

        $this->view->shoes = $shoes;
        $this->view->form = new ShoesForm($shoes);
    }

    public function createAction()
    {
        $shoes = new Shoes();

        $this->view->shoes = $shoes;
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
                        "params" => array($shoes->id)
                    ));
                }
                return $this->dispatcher->forward(array(
                    "action" => "create"
                ));
            } else {
                $this->flashSession->success("Обувь сохранена");
                return $this->response->redirect("admin/shoes/edit/".$shoes->id);
            }
        }
    }

    public function thumbnailsAction($id){
        $shoes = Shoes::findFirst($id);
        foreach($shoes->shoesImages as $image){

        }
        return $this->response->redirect("admin/shoes/edit/".$shoes->id);
    }

    public function imageAction($id)
    {
        $shoes = Shoes::findFirst($id);

        if($this->request->hasFiles() == true){
            $uploads = $this->request->getUploadedFiles();
            $isUploaded = false;
            #do a loop to handle each file individually
            foreach($uploads as $upload){
                $image = new ShoesImages();
                $image->generateUniqueHash();
                $image->shoes_id = $shoes->id;
                $image->upload_date_year = date('Y');
                $image->upload_date_month = date('n');
                $image->upload_date_day = date('d');
                $image->extension = $upload->getExtension();
                $image->save();
                if (is_dir($image->originalPath()) == false)
                {
                    mkdir($image->originalPath(false), 0777, true); // Create directory if it does not exist
                }
                ($result = $upload->moveTo($image->originalPath())) ? $isUploaded = true : $isUploaded = false;

                if($isUploaded){
                    $image->reGenerateThumbnails();
                }

            }
            ($isUploaded) ? die('Files successfully uploaded.') : die('Some error ocurred.');
        }else{
            die('You must choose at least one file to send. Please try again.');
        }
    }

    public function deleteAction($id)
    {
        $shoes = Shoes::findFirstById($id);
        if (!$shoes) {
            //$this->flashSession->error("Обувь не найдена");
            return $this->dispatcher->forward(array(
                'action' => 'index'
            ));
        }
        if (!$shoes->delete()) {
            foreach($shoes->getMessages() as $message) {
                //$this->flashSession->error($message);
            }
        } else {
            //$this->flashSession->success("Обувь удалена");
        }
        return $this->dispatcher->forward(array(
            'action' => 'index'
        ));
    }


}
