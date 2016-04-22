<?php

namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;
use Models;

class ShoesController extends Controller
{

    public function indexAction()
    {

    }

    public function addAction()
    {

    }

    public function uploadAction()
    {
        if($this->request->hasFiles() == true){
            $uploads = $this->request->getUploadedFiles();
            $isUploaded = false;
            #do a loop to handle each file individually
            foreach($uploads as $upload){
                $image = new ShoesImages();
                $image->generateUniqueHash();
                $image->upload_date_year = date('Y');
                $image->upload_date_month = date('m');
                $image->upload_date_day = date('d');
                $image->save();

                ($upload->moveTo($image->originalPath())) ? $isUploaded = true : $isUploaded = false;
            }

            ($isUploaded) ? die('Files successfully uploaded.') : die('Some error ocurred.');
        }else{
            die('You must choose at least one file to send. Please try again.');
        }
    }

}
