<?php

namespace App\Classes\Employee;

use Lib\SqlModel;

/**
 * summary
 */
class EmployeeModel
{
    private $sqlHandler;

    public function __construct(SqlModel $sqlModel)
    {
        $this->sqlHandler = $sqlModel;
    }

    public function getAllEmployeesSql()
    {
        $sql = "SELECT * FROM employees";
        
        $bindValues = array();
        $resultArray = $this->sqlHandler->fetchAll($sql, $bindValues);
        return $resultArray;
    }

    public function insertNewEmployeeSql($dataArray)
    {
        $name = $dataArray['name'];
        $position = $dataArray['position'];
      
        $sql = "INSERT INTO employees(name, position) VALUES(:name, :position)";

        $bindValues = array('name' => $name, 'position' => $position);
        $result = $this->sqlHandler->perform($sql, $bindValues);
        $empId = $this->sqlHandler->insertId();
        return $empId;
    }
}
