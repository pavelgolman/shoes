<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;

require_once(dirname(__FILE__).'/../configs/constants.php');

$di = new FactoryDefault();

// Specify routes for modules
// More information how to set the router up https://docs.phalconphp.com/en/latest/reference/routing.html
$di->set('router', function () {

    $router = new Router();

    $router->setDefaultModule("frontend");

    $router->add(
        "/login",
        array(
            'module'     => 'backend',
            'controller' => 'login',
            'action'     => 'index'
        )
    );

    $router->add(
        "/admin/products/:action",
        array(
            'module'     => 'backend',
            'controller' => 'products',
            'action'     => 1
        )
    );

    $router->add(
        "/products/:action",
        array(
            'controller' => 'products',
            'action'     => 1
        )
    );

    return $router;
});

try {

    // Set the database service
    $di['db'] = function() {
        return new DbAdapter(array(
            "host"     => "localhost",
            "username" => "shoes",
            "password" => "shoes",
            "dbname"   => "shoes"
        ));
    };

    // Setting up the view component
    $di['view'] = function() {
        $view = new View();
        $view->setViewsDir('../app/views/');
        return $view;
    };

    // Setup a base URI so that all generated URIs include the "tutorial" folder
    $di['url'] = function() {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    };

    // Setup the tag helpers
    $di['tag'] = function() {
        return new Tag();
    };

    // Create an application
    $application = new Application($di);

    // Register the installed modules
    $application->registerModules(
        array(
            'frontend' => array(
                'className' => 'Multiple\Frontend\Module',
                'path'      => '../apps/frontend/Module.php',
            ),
            'backend'  => array(
                'className' => 'Multiple\Backend\Module',
                'path'      => '../apps/backend/Module.php',
            )
        )
    );

    // Handle the request
    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}