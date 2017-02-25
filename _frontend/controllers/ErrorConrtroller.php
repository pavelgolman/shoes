<?php


namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ErrorController extends Controller
{
    public function indexAction()
    {

    }

    public function show404Action()
    {
        $this->response->setStatusCode(404, "Not Found");
        $this->response->send();
    }

}