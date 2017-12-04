<?php

namespace App\Controllers;

use App\Classes\Samples\SampleProducts;

/**
 * summary
 */
class SampleProductController extends Controller
{
    private $prodHandler;
    protected $c;

    public function __construct($c)
    {
        $this->c = $c;
        $this->prodHandler = new SampleProducts($this->c);
    }

    public function index($request, $response)
    {
        return $response->withJson(array('id'=>1,'name'=>'Joe'));
    }

    public function show($request, $response, $args)
    {
        $sqlLimit = $args['limit'];
        $result = $this->prodHandler->getProductsWithLimit($sqlLimit);
        return $response->withJson($result);
    }
}
