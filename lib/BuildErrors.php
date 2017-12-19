<?php

namespace Lib;

use Lib\SqlModel;
use Crell\ApiProblem\ApiProblem;

/**
 * summary
 */
class BuildErrors
{
    private $sqlHandler;

    public function __construct(SqlModel $sqlHandler)
    {
        $this->sqlHandler = $sqlHandler;
    }

    public function getJsonError($response, $requestUri, $errorCode)
    {
        $errorData = $this->getErrorDetailsSql($errorCode);
        
        $errorType = $errorData['er_error_type'];
        $errorUrl = "https://errors.fiftyflowers.com/$errorCode";
        $errorMessage = $errorData['er_error_message'];
        $setStatus = (int)$errorData['er_status_code'];

        $problem = new ApiProblem($errorType, $errorUrl);
        $problem->setDetail($errorMessage);
        $problem->setInstance($requestUri);
        $newResponse = $response
          ->withHeader('Content-type', 'application/json')
          ->withStatus($setStatus);
        $newResponse->write($problem->asJson());

        return $newResponse;
    }

    private function getErrorDetailsSql($errorCode)
    {
        $sql = "SELECT * 
        FROM api_error_data 
        WHERE er_error_code = :errorCode";

        $bindValues = array('errorCode'=>$errorCode);
        $errorData = $this->sqlHandler->fetchFirstRow($sql, $bindValues);
        return $errorData;
    }
}
