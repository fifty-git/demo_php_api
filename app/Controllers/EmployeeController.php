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
    protected $c;
    protected $pdo;
    protected $logger;

    public function __construct($c)
    {
        $this->c = $c;
        $this->pdo = $this->c['db'];
        $this->logger = $this->c['logger'];
        $this->empHandler = new Employees($this->pdo);
    }

    public function index($request, $response)
    {
        $employees = $this->empHandler->getAllEmployees();
        $this->logger->info("All Employee Results", $employees);
        return $response->withJson($employees);
    }

    public function show()
    {
        // show specific employee
        $this->logger->info("Employee Results");
        echo 'you got one employee';
    }

    public function post($request, $response)
    {
        $reqData = $request->getParsedBody();
        if (!empty($reqData)) {
            $result = $this->empHandler->insertNewEmployee($reqData);
            $cookie = FigRequestCookies::get($request, 'TestCookie');
            error_log($cookie);
            $cookieValues = explode('=', $cookie);
      

            if ($result) {
                return $response->withJson(array('Response'=>'Success', 'token'=>$cookieValues[1]), 201);
            } else {
                return $response->withJson(array('Response'=>'Failed to Write'), 500);
            }
        } else {
            return $response->withJson(array('Response'=>'Failed Validation'), 409);
        }
    }
}
