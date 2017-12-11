<?php
namespace App\Controllers;

use App\Classes\Employee\Employees;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;

/**
 * summary
 */
class EmployeeController extends Controller
{
    private $empHandler;

    public function __construct($c)
    {
        parent::__construct($c);
        $this->empHandler = new Employees($this->c);
    }

    public function index($request, $response)
    {
        $status = $response->getStatusCode();
        if ($status == 200) {
            $employees = $this->empHandler->getAllEmployees();
            return $response->withJson($employees);
        } else {
            $error = $this->errorHandler->getJsonError($response);
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
