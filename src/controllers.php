<?php
use ICFS\Model\Page;
use Symfony\Component\HttpFoundation\Response;
use ICFS\Model\Events;
use Silex\Application;

$app->get('/', function (Application $app) {
    return $app['twig']->render('index.html');
});