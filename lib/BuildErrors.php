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
        
        $errorType = $errorData['error_type'];
        $errorUrl = "https://errors.fiftyflowers.com/$errorCode";
        $errorMessage = $errorData['error_message'];
        $setStatus = (int)$errorData['status_code'];

        $problem = new ApiProblem($errorType, $errorUrl);
        $problem['error'] = true;
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
        $sql = "SELECT
        api_error_data.er_error_code as error_code,
        api_error_data.er_status_code as status_code,
        api_error_data.er_error_message as error_message,
        api_error_types.et_error_type as error_type
        FROM
        api_error_data
        JOIN api_error_types
        ON api_error_data.er_error_type_id = api_error_types.et_id
        WHERE api_error_data.er_error_code = :errorCode";

        $bindValues = array('errorCode'=>$errorCode);
        $errorData = $this->sqlHandler->fetchFirstRow($sql, $bindValues);
        return $errorData;
    }
}
