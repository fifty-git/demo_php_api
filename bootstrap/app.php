<?php
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Monolog\Handler\BrowserConsoleHandler;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap/settings.php';

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();

$container['logger'] = function ($c) {
    $logger = new Logger('demo_logger');
    // output to file - uncomment to use
    $logger->pushHandler(new StreamHandler('../logs/app.log', Logger::DEBUG));
    // output to browser console - this won't output arrays
    $logger->pushHandler(new BrowserConsoleHandler());
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO(
        "mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'],
        $db['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});



require __DIR__ . '/../routes/api.php';
