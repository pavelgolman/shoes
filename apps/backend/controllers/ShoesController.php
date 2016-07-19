<?php

namespace Multiple\Backend\Controllers;

use Models\AttributesShoes;
use Models\PromoBlocksShoes;
use Models\ShoesDescriptions;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Models\Shoes;
use Models\ShoesImages;
use Multiple\Backend\Forms\ShoesForm;

class ShoesController extends AdminController
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

    public function orderAction(){
        $shoes_id = $this->request->get('id');
        $order_index = $this->request->get('index');

        $shoes = Shoes::find(
            array(
                "conditions" => "order_index >= ".$order_index,
            )
        );
        foreach($shoes as $s){
            $s->order_index++;
            $s->save();
        }
        $shoes = Shoes::findFirst($shoes_id);
        $shoes->order_index = $order_index;
        $shoes->save();
    }

    public function saveAction()
    {
        $shoes = new Shoes();
        if ($this->request->isPost()) {
            if($this->request->getPost('id')){
                $shoes = Shoes::findFirst($this->request->getPost('id'));
            }else{
                $shoes->order_index = Shoes::maximum(
                    array(
                        "column" => "order_index"
                    )
                ) + 1;
            }
            $shoes->name = $this->request->getPost('name');
            $shoes->article = $this->request->getPost('article');
            $shoes->price = $this->request->getPost('price');
            $shoes->main_image_id = $this->request->getPost('main_image_id');

            if(!$shoes->description){
                $shoes->description = new \Models\ShoesDescriptions();
                $shoes->description->shoes_id = $shoes->id;
            }
            $shoes->description->description = $this->request->getPost('description');
            $shoes->description->save();

            $shoes->attributesShoes->delete();
            foreach($this->request->getPost('attributes') as $attribute_id => $value){
                $attribute = new AttributesShoes();
                $attribute->shoes_id = $shoes->id;
                $attribute->attributes_id = $attribute_id;
                $attribute->save();
            }

            $shoes->blocksShoes->delete();
            foreach($this->request->getPost('blocks') as $promo_blocks_id => $value){
                $block = new PromoBlocksShoes();
                $block->shoes_id = $shoes->id;
                $block->promo_blocks_id = $promo_blocks_id;
                $block->save();
            }

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
        foreach($shoes->images as $image){

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
