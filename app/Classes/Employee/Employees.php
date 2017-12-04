<?php

namespace App\Classes\Employee;


/**
 * summary
 */
class Employees
{

  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;      
  }

  public function getAllEmployees()
  {
    $employees = $this->pdo->query('SELECT * FROM employees')->fetchAll($this->pdo::FETCH_ASSOC); 
    return $employees;
  }

  public function insertNewEmployee($dataArray)
  {
    $name = $dataArray['name'];
    $position = $dataArray['position'];

    $stmt = $this->pdo->prepare("INSERT INTO employees(name, position) 
      VALUES(:name, :position)"); 

    return $stmt->execute(array("name"=>$name, "position"=>$position));
  }
}