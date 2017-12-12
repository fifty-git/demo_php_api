<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Classes\Samples\SampleProducts;

/**
 * summary
 */
class SampleProductController
{
    private $prodHandler;

    public function __construct(SampleProducts $sampleProducts)
    {
        $this->prodHandler = $sampleProducts;
    }

    public function index(Request $request, Response $response)
    {
        return $response->withJson(array('id'=>1,'name'=>'Joe'));
    }

    public function show($limit = 10, Request $request, Response $response)
    {
        $sqlLimit = (!empty($limit)) ? $limit : 10;
        $result = $this->prodHandler->getProductsWithLimit($sqlLimit);
        return $response->withJson($result);
    }
}
