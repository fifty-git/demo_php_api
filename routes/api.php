<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Controllers\EmployeeController;
use \App\Controllers\SampleProductController;

$app->get('/api2[/]', function (Request $request, Response $response) {
    $response->getBody()->write("Hello World!");
    return $response;
});

$app->get('/api2/products[/{limit}]', ['\App\Controllers\SampleProductController', 'show']);

$app->group('/api2/employees', function () {
    $this->get('/', ['\App\Controllers\EmployeeController', 'index']);
    $this->get('/{id}', ['\App\Controllers\EmployeeController', 'show']);
    $this->post('/', ['\App\Controllers\EmployeeController', 'post']);
});
