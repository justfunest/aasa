<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
    ]
]);

// Template engine
$container = $app->getContainer();

$container['view'] = function ($container) {
    $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../resources/views/');
    $view = new \Twig_Environment($loader);

    $view->addGlobal('router', $container->get('router'));

    return $view;
};

// Storage
$adapter = new \League\Flysystem\Adapter\Local(__DIR__ . '/../storage/');
$container['storage'] = new \League\Flysystem\Filesystem($adapter);

// Middlewares
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\PreviousRequestParamsMiddleware($container));

// Routes
require_once  __DIR__ . '/../routes/web.php';


return $app;