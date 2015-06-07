<?php

/**
 * Interface EmployeeRepository
 *
 * @package ${NAMESPACE}
 */
interface EmployeeRepository
{
    /**
     * @return Employee[]|null
     */
    public function findAll();
}
