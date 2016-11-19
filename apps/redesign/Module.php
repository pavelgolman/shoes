<?php

namespace Multiple\Redesign;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use Phalcon\Events\Manager as EventsManager;

class Module implements ModuleDefinitionInterface
{
    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            array(
                'Multiple\Redesign\Controllers' => '../apps/redesign/controllers/',
                'Models'      => '../models/',
            )
        );

        $loader->register();
    }

    /**
     * Register specific services for the module
     */
    public function registerServices(DiInterface $di)
    {
        // Registering a dispatcher
        $di->set('dispatcher', function () {
            $eventsManager = new EventsManager();
            $eventsManager->attach("dispatch:beforeException", function($event, $dispatcher, $exception) {

                $logger = new \Phalcon\Logger\Adapter\File('/tmp/error-'.date('Ymd').'.log', array(
                    'mode' => 'a+'
                ));
                $logger->error(get_class($exception). '['.$exception->getCode().']: '. $exception->getMessage());
                $logger->info($exception->getFile().'['.$exception->getLine().']');
                $logger->debug("Trace: \n".$exception->getTraceAsString()."\n");
                $logger->close();

                //if ($exception instanceof DispatchException) {
                //    $dispatcher->forward(array(
                //        'controller' => 'error',
                //        'action'     => 'show404'
                //    ));
                //    return false;
                //}

            });


            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Multiple\Redesign\Controllers");
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        });

        // Registering the view component
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir('../apps/redesign/views/');
            return $view;
        });
    }
}