<?php

use Fototea\Util\ImageHelper;

ini_set('display_errors', 0);
//error_reporting(E_ALL);
define('DS', DIRECTORY_SEPARATOR);
$basePath = __DIR__ . DS;
$thumbExtension = 'jpg';

require $basePath .'vendor/autoload.php';

$imageUrl = strip_tags($_GET['url']);

//Generate thumbnail name
$thumbFileName = str_replace("/", "_",$imageUrl);
$thumbInfo = pathinfo($thumbFileName);
$thumbFileName = $thumbInfo['filename'] . "." . $thumbExtension;

$width = intval($_GET['w']);
$height = intval($_GET['h']);

if ($height == 0) {
    echo 'stop here';
}

$cacheFolder = $basePath . 'profiles' . DS . 'cache' . DS . $width . "x" . $height . DS;

if ($_GET['refresh'] != 'true'){
    //USAR LA CACHE
    if (file_exists($cacheFolder . $thumbFileName)) {
        header('Content-Type: image/jpeg');
        echo file_get_contents($cacheFolder . $thumbFileName);
        exit;
    }
}

if (!file_exists($cacheFolder)) {
    $old = umask(0);
    mkdir($cacheFolder, 0777, true);
    umask($old);
}

$availableModes = array(ImageHelper::MODE_CROP_CENTER, ImageHelper::MODE_RESIZE);

$mode = ImageHelper::MODE_RESIZE;

if (in_array($_GET['mode'], $availableModes)) {
    $mode = $_GET['mode'];
}

ImageHelper::generateThumb($basePath . $imageUrl, $cacheFolder . $thumbFileName, $width, $height, $mode);
header('Content-Type: image/jpeg');
echo file_get_contents($cacheFolder . $thumbFileName);