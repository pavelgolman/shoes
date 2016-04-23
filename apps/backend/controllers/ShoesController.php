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
                $image = new Models\ShoesImages();
                $image->generateUniqueHash();
                $image->upload_date_year = date('Y');
                $image->upload_date_month = date('m');
                $image->upload_date_day = date('d');
                $image->extension = $upload->getExtension();
                $image->save();
                if (is_dir($image->originalPath()) == false)
                {
                    mkdir($image->originalPath(), 0777, true); // Create directory if it does not exist
                }
                //($result = $upload->moveTo($image->originalPath())) ? $isUploaded = true : $isUploaded = false;
error_reporting(E_ALL);
                ini_set('display_errors', 1);
                rename($upload->getTempName(), $image->originalPath());
            }
var_dump($upload->getName(), $upload->getTempName(), $image->originalPath());
            ($isUploaded) ? die('Files successfully uploaded.') : die('Some error ocurred.');
        }else{
            die('You must choose at least one file to send. Please try again.');
        }
    }

}
