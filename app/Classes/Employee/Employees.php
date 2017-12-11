<?php

namespace App\Classes\Employee;

use App\Classes\Employee\EmployeeModel;

/**
 * summary
 */
class Employees
{
    private $c;
    private $logger;
    private $emplModel;

    public function __construct($c)
    {
        $this->c = $c;
        $this->logger = $this->c['logger'];
        $this->emplModel = new EmployeeModel($this->c);
    }

    public function getAllEmployees()
    {
        $employees = $this->emplModel->getAllEmployeesSql();
        return $employees;
    }

    public function insertNewEmployee($dataArray)
    {
        $result = $this->emplModel->insertNewEmployeeSql($dataArray);
        return $result;
    }
}
