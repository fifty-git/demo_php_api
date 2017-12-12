<?php

namespace App;

use DI\ContainerBuilder;
use Interop\Container\ContainerInterface;

/**
 * summary
 */
class App extends \DI\Bridge\Slim\App
{
    protected function configureContainer(ContainerBuilder $builder)
    {
        $definitions = [
          \Monolog\Logger::class => function (ContainerInterface $container) {
              $logger = new \Monolog\Logger('demo_logger');
              // output to file - uncomment to use
              $logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/../logs/app.log', \Monolog\Logger::DEBUG));
              // output to browser console - this won't output arrays
              $logger->pushHandler(new \Monolog\Handler\BrowserConsoleHandler());
              return $logger;
          }

        ];

        $builder->addDefinitions($definitions);
        $builder->addDefinitions(__DIR__ . '/../bootstrap/settings.php');
    }
}
