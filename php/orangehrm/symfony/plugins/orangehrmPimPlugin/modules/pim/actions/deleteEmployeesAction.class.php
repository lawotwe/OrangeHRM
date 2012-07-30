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
 * delete employees list action
 */
class deleteEmployeesAction extends basePimAction {

    /**
     * Delete action. Deletes the employees with the given ids
     */
    public function execute($request) {
        
        $allowedToDeleteActive = $this->getContext()->getUserRoleManager()->isActionAllowed(PluginWorkflowStateMachine::FLOW_EMPLOYEE, 
                Employee::STATE_ACTIVE, PluginWorkflowStateMachine::EMPLOYEE_ACTION_DELETE_ACTIVE);
        $allowedToDeleteTerminated = $this->getContext()->getUserRoleManager()->isActionAllowed(PluginWorkflowStateMachine::FLOW_EMPLOYEE, 
                Employee::STATE_TERMINATED, PluginWorkflowStateMachine::EMPLOYEE_ACTION_DELETE_TERMINATED);
        

        if ($allowedToDeleteActive || $allowedToDeleteTerminated) {
            $ids = $request->getParameter('chkSelectRow');

            $userRoleManager = $this->getContext()->getUserRoleManager();
            if (!$userRoleManager->areEntitiesAccessible('Employee', $ids)) {
                $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
            }

            $employeeService = $this->getEmployeeService();               
            $count = $employeeService->deleteEmployees($ids);

            if ($count == count($ids)) {
                $this->getUser()->setFlash('templateMessage', array('success', __(TopLevelMessages::DELETE_SUCCESS)));
            } else {
                $this->getUser()->setFlash('templateMessage', array('failure', __('A Problem Occured When Deleting The Selected Employees')));
            }

            $this->redirect('pim/viewEmployeeList');
        } else {
            $this->getUser()->setFlash('templateMessage', array('warning', __('Contact Admin for delete Credentials')));
            $this->redirect('pim/viewEmployeeList');
        }
    }


}
