<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */

/**
 * Description of SupervisorUserRole
 *
 * @author Chameera Senarathna
 */
class SupervisorUserRole implements UserRoleInterface {

    protected $employeeService;

    public function getEmployeeService() {

        if (empty($this->employeeService)) {
            $this->employeeService = new EmployeeService();
        }
        return $this->employeeService;
    }

    public function setEmployeeService($employeeService) {
        $this->employeeService = $employeeService;
    }

    public function getAccessibleEmployeeIds($operation = null, $returnType = null) {

        $employeeIdArray = array();

        $empNumber = sfContext::getInstance()->getUser()->getEmployeeNumber();
        if (!empty($empNumber)) {
            $employeeIdArray = $this->getEmployeeService()->getSubordinateIdListBySupervisorId($empNumber);
        }

        return $employeeIdArray;
    }

    public function getAccessibleEmployeePropertyList($properties, $orderField, $orderBy) {

        $employeeProperties = array();

        $empNumber = sfContext::getInstance()->getUser()->getEmployeeNumber();
        if (!empty($empNumber)) {
            $employeeProperties = $this->getEmployeeService()->getSubordinatePropertyListBySupervisorId($empNumber, $properties, $orderField, $orderBy, false);
        }

        return $employeeProperties;
    }

    public function getAccessibleEmployees($operation = null, $returnType = null) {

        $employees = array();

        $empNumber = sfContext::getInstance()->getUser()->getEmployeeNumber();
        if (!empty($empNumber)) {
            $employees = $this->getEmployeeService()->getSubordinateList($empNumber, true);
        }

        $employeesWithIds = array();

        foreach ($employees as $employee) {
            $employeesWithIds[$employee->getEmpNumber()] = $employee;
        }

        return $employeesWithIds;
    }

    public function getAccessibleLocationIds($operation, $returnType) {

        return array();
    }

    public function getAccessibleOperationalCountryIds($operation, $returnType) {

        return array();
    }

    public function getAccessibleSystemUserIds($operation, $returnType) {

        return array();
    }

    public function getAccessibleUserRoleIds($operation, $returnType) {

        return array();
    }

}