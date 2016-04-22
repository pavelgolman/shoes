<?php

use Phalcon\Loader;
use Phalcon\Tag;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

// Register an autoloader
$loader = new Loader();
$loader->registerDirs(
    array(
        '../app/controllers/',
        '../app/models/'
    )
)->register();

/*
 * Images path:
 *
 * /images/shoes/<shoes id>/original.png
 * /images/shoes/<shoes id>/<image storage id>/<width>_<height>.png
 *
 */

$images = ShoesImages::find();
foreach($images as $si){
    if(empty($si->storage_id)){
        $si-
        $si->save();
    }

    $image = new Phalcon\Image\Adapter\Imagick("/var/www/html/domtkani.dp.ua/public/images/shoes/".$si->shoes_id.'/'.$si->image_original);
    $image->resize(125, 125);
    if ($image->save($si->thumbnailURL(125, 125))) {
        echo 'success';
    }
}