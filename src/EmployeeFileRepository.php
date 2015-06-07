<?php

/**
 * Class EmployeeFileRepository
 */
class EmployeeFileRepository
{
    private $fileHandler;

    public function __construct($fileName)
    {
        $this->fileHandler = fopen($fileName, 'r');
        fgetcsv($this->fileHandler);
    }

    public function findAll()
    {
        $employees = [];
        while ($employeeData = fgetcsv($this->fileHandler, null, ',')) {
            $employeeData = array_map('trim', $employeeData);
            $employees[]  = new Employee($employeeData[1], $employeeData[0], $employeeData[2], $employeeData[3]);
        }

        return $employees;
    }
}
