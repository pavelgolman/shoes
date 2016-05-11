<?php

namespace Multiple\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;

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
                'Multiple\Frontend\Controllers' => '../apps/frontend/controllers/',
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

                if ($exception instanceof DispatchException) {
                    $dispatcher->forward(array(
                        'controller' => 'error',
                        'action'     => 'show404'
                    ));
                    return false;
                }

            });


            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Multiple\Frontend\Controllers");
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        });

        // Registering the view component
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir('../apps/frontend/views/');
            return $view;
        });
    }
}