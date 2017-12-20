<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Classes\Samples\SampleProducts;
use Lib\BuildErrors;

/**
 * summary
 */
class SampleProductController
{
    private $prodHandler;
    private $buildErrors;

    public function __construct(
        SampleProducts $sampleProducts,
        BuildErrors $buildErrors
    ) {
        $this->prodHandler = $sampleProducts;
        $this->buildErrors = $buildErrors;
    }

    public function index(Request $request, Response $response)
    {
        return $response->withJson(array('id'=>1,'name'=>'Joe'));
    }

    public function show(Request $request, Response $response, $limit = 10)
    {
        $result = $this->prodHandler->getProductsWithLimit($limit);
        $status = $response->getStatusCode();
        if ($status == 200) {
            if (!empty($result)) {
                return $response->withJson($result);
            } else {
                $reqUri = $_SERVER['REQUEST_URI'];
                $errorCode = 'data_100'; // no records found
                return $this->buildErrors->getJsonError($response, $reqUri, $errorCode);
            }
        } else {
            $reqUri = $_SERVER['REQUEST_URI'];
            return $this->buildErrors->getJsonError($response, $reqUri, $errorCode);
        }
    }
}
