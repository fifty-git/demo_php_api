<?php


namespace App\Controllers;

use Interop\Container\ContainerInterface;
use Lib\BuildErrors;

abstract class Controller
{
    protected $c;
    protected $logger;
    protected $errorHandler;

    public function __construct(ContainerInterface $c)
    {
        $this->c = $c;
        $this->logger = $this->c['logger'];
        $this->errorHandler = new BuildErrors();
    }
}
