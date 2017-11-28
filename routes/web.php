<?php
/** @var $app \Slim\App
 */

$app->get('/', function($request, $response) use ($app) {
    return $response->withRedirect($app->getContainer()->get('router')->pathFor('loans.create'));
});


$app->get('/loans/create', \App\Controllers\LoanController::class .':create')->setName('loans.create');
$app->post('/loans/store', \App\Controllers\LoanController::class .':store')->setName('loans.store');
$app->get('/loans', \App\Controllers\LoanController::class .':index')->setName('loans.index');