<?php

namespace App\Classes\Employee;

use App\Classes\Employee\EmployeeModel;

/**
 * summary
 */
class Employees
{
    private $emplModel;

    public function __construct(EmployeeModel $emplModel)
    {
        $this->emplModel = $emplModel;
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
