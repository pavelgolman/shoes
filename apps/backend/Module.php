<?php

namespace Multiple\Backend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
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
                'Multiple\Backend\Controllers' => '../apps/backend/controllers/',
                'Models'      => '../models/',
                'Multiple\Backend\Forms' => '../apps/backend/forms/',
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
            // Create an EventsManager
            $eventsManager = new EventsManager();

            // Attach a listener
            $eventsManager->attach("dispatch:beforeDispatchLoop", function ($event, $dispatcher) {
                $realm = 'Restricted area';

                $users = array('admin' => 'admingolman');

                if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
                    header('HTTP/1.1 401 Unauthorized');
                    header('WWW-Authenticate: Digest realm="'.$realm.
                        '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');

                    die('Text to send if user hits Cancel button');
                }

// analyze the PHP_AUTH_DIGEST variable
                if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
                    !isset($users[$data['username']]))
                    die('Wrong Credentials!');


// generate the valid response
                $A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
                $A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
                $valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

                if ($data['response'] != $valid_response)
                    die('Wrong Credentials!');

                $keyParams = array();
                $params    = $dispatcher->getParams();

                // Use odd parameters as keys and even as values
                foreach ($params as $number => $value) {
                    if ($number & 1) {
                        $keyParams[$params[$number - 1]] = $value;
                    }
                }

                // Override parameters
                $dispatcher->setParams($keyParams);
            });

            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers");
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        });

        // Registering the view component
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir('../apps/backend/views/');
            return $view;
        });
    }
}

function http_digest_parse($txt)
{
    // protect against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}