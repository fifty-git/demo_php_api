<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap/settings.php';

$app = new \App\App;

// turn off Slim's error handling - we will do this ourself
// unset($app->getContainer()['errorHandler']);
// unset($app->getContainer()['phpErrorHandler']);

// enable CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8181')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});



require __DIR__ . '/../routes/api.php';
