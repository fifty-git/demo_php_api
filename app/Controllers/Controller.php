<?php


namespace App\Controllers;

use Interop\Container\ContainerInterface;

abstract class Controller 
{
  protected $c;
  protected $pdo;

  public function __construct(ContainerInterface $c)
  {
    $this->c = $c;
  } 
}
