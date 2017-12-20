<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Classes\Employee\Employees;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Monolog\Logger as Logger;
use Lib\BuildErrors;

/**
 * summary
 */
class EmployeeController
{
    private $empHandler;
    private $logger;

    public function __construct(
        Employees $employeeHandler,
        Logger $logger,
        BuildErrors $buildErrors
    ) {
        $this->empHandler = $employeeHandler;
        $this->logger = $logger;
        $this->buildErrors = $buildErrors;
    }

    public function index(Request $request, Response $response)
    {
        $employees = $this->empHandler->getAllEmployees();
        $status = $response->getStatusCode();
        if ($status == 200) {
            if (!empty($employees)) {
                return $response->withJson($employees);
            } else {
                $this->logger->info('Returned empty employee list');
                $reqUri = $_SERVER['REQUEST_URI'];
                $errorCode = 'val_100'; // no records found
                return $this->buildErrors->getJsonError($response, $reqUri, $errorCode);
            }
        } else {
            $this->logger->info('NON-200 Status Code: ' . $status);
            $reqUri = $_SERVER['REQUEST_URI'];
            return $this->buildErrors->getJsonError($response, $reqUri, $errorCode);
        }
    }

    public function show($request, $response)
    {
        // show specific employee
        $this->logger->info("Employee Results");
        echo 'you got one employee';
    }

    public function post($request, $response)
    {
        $reqData = $request->getParsedBody();
        if (!empty($reqData)) {
            $empId = $this->empHandler->insertNewEmployee($reqData);
            $cookie = FigRequestCookies::get($request, 'TestCookie');
            $cookieValues = explode('=', $cookie);

            if ($empId) {
                return $response->withJson(array('Response'=>'Success', 'token'=>$cookieValues[1], 'empID'=>$empId), 201);
            } else {
                return $response->withJson(array('Response'=>'Failed to Write'), 500);
            }
        } else {
            return $response->withJson(array('Response'=>'Failed Validation'), 409);
        }
    }
}
