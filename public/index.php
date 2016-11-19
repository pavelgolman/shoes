<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as Session;


require_once(dirname(__FILE__).'/../configs/constants.php');

$di = new FactoryDefault();

// Specify routes for modules
// More information how to set the router up https://docs.phalconphp.com/en/latest/reference/routing.html
$di->set('router', function () {

    $router = new Router();


    $router->setDefaultModule("frontend");

    $router->add('/:controller/:action', array(
        'module' => 'frontend',
        'controller' => 1,
        'action' => 2,
    ));

    $router->add('/sitemap.xml', array(
        'module' => 'frontend',
        'controller' => "sitemap",
        'action' => "xml",
    ));

    $router->add(
        "/login",
        array(
            'module'     => 'backend',
            'controller' => 'login',
            'action'     => 'index'
        )
    );

    $router->add(
        "/admin/:controller/:action/",
        array(
            'module'     => 'backend',
            'controller' => 1,
            'action'     => 2
        )
    );

    $router->add(
        "/admin/:controller/:action/:params",
        array(
            'module'     => 'backend',
            'controller' => 1,
            'action'     => 2,
            "params"     => 3
        )
    );



    $router->add(
        "/redesign/:controller/:action/",
        array(
            'module'     => 'redesign',
            'controller' => 1,
            'action'     => 2
        )
    );

    $router->add(
        "/redesign/:controller/:action/:params",
        array(
            'module'     => 'redesign',
            'controller' => 1,
            'action'     => 2,
            "params"     => 3
        )
    );


    return $router;
});

$di->set('url', function() {
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri( '/' );
    return $url;
});

try {

    // Set the database service
    $di['db'] = function() {
        return new DbAdapter(array(
            "host"     => "localhost",
            "username" => "shoes",
            "password" => "shoes",
            "dbname"   => "shoes",
            'charset'   =>'utf8'
        ));
    };

    // Сессии запустятся один раз, при первом обращении к объекту
    $di->setShared('session', function () {
        $session = new Session();
        $session->start();
        return $session;
    });

    // Create an application
    $application = new Application($di);

    // Register the installed modules
    $application->registerModules(
        array(
            'frontend' => array(
                'className' => 'Multiple\Frontend\Module',
                'path'      => '../apps/frontend/Module.php',
            ),
            'redesign' => array(
                'className' => 'Multiple\Redesign\Module',
                'path'      => '../apps/redesign/Module.php',
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