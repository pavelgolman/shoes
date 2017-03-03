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

$si = ShoesImages::findFirst(364);

if(empty($si->storage_id)){
    $si->save();
}

$image = new Phalcon\Image\Adapter\Imagick("/var/www/html/domtkani.dp.ua/public/images/shoes/".$si->shoes_id.'/'.$si->image_original);
$image->resize(90, 90);
if ($image->save($si->thumbnailURL(90, 90, false))) {
    echo 'success';
}
