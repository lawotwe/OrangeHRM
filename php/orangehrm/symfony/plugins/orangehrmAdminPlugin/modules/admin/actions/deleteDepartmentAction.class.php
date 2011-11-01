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
 *
 */

class deleteDepartmentAction extends sfAction{

    private $departmentService;

    public function getDepartmentService() {
        if (is_null($this->departmentService)) {
            $this->departmentService = new DepartmentService();
            $this->departmentService->setDepartmentDao(new DepartmentDao());
        }
        return $this->departmentService;
    }

    public function setDepartmentService(DepartmentService $departmentService) {
        $this->departmentService = $departmentService;
    }

    public function execute($request) {
        $id = trim($request->getParameter('departmentId'));

        try {
            $department = $this->getDepartmentService()->readDepartment($id);
            $result = $this->getDepartmentService()->deleteDepartment($department);

            if ($result) {
                $object->messageType = 'success';
                $object->message = 'Department was deleted successfully';
            } else {
                $object->messageType = 'failure';
                $object->message = 'Failed to delete department';
            }
        } catch (Exception $e) {
            $object->message = 'Failed to load instituion.';
            $object->messageType = 'failure';
        }

        @ob_clean();
        echo json_encode($object);
        exit;
    }
}

