<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Controllers\EmployeeController;
use \App\Controllers\SampleProductController;

$app->get('/api2[/]', function (Request $request, Response $response) {
    $this->logger->info("IN BASE ENDPOINT");
    $response->getBody()->write("Hello World!");
    return $response;
});

$app->get('/api2/products[/{limit}]', SampleProductController::class . ':show');

$app->group('/api2/employees', function () {
    $this->get('/', EmployeeController::class . ':index');
    $this->get('/{id}', EmployeeController::class . ':show');
    $this->post('/', EmployeeController::class . ':post');
});
