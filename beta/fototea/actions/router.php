<?php

require '../vendor/autoload.php';
use Fototea\App\App;

ini_set('display_errors', 1);
error_reporting(E_ERROR);

$app = new App();

//Router cavernicola :D
$actionsDir = $app->getConfig()->getBasePath() . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR;
$actionName = $app->getRequest()->get('action');

$target = $actionsDir . $actionName;
$result = include "$target";

$app->shutdown();
