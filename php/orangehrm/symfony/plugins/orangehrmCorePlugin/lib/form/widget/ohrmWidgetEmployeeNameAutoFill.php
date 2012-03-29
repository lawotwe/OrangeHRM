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
 * @todo Handle past employees
 * @todo Showing/not showing duplicate names
 * @todo If full name is pasted, hideen ID is not set
 * @todo Array or ajax switch
 * @todo Validating inside the widget
 */

class ohrmWidgetEmployeeNameAutoFill extends sfWidgetFormInput {
    
    public function configure($options = array(), $attributes = array()) {

        $this->addOption('employeeList', '');
        $this->addOption('jsonList', '');
        
    }    

    public function render($name, $value = null, $attributes = array(), $errors = array()) {

        $empNameValue   = isset($value['empName'])?$value['empName']:'';
        $empIdValue     = isset($value['empId'])?$value['empId']:'';        
        
        $html           = parent::render($name . '[empName]', $empNameValue, $attributes, $errors);
        $typeHint       = __('Type for hints') . '...';
        $hiddenFieldId  = $this->getHiddenFieldId($name);

        $javaScript     = sprintf(<<<EOF
        <script type="text/javascript">

            var employees = %s;

            $(document).ready(function() {
            
                var nameField = $("#%s");
                var idStoreField = $("#%s");
                var typeHint = '%s';
                var hintClass = 'inputFormatHint';
            
                if (nameField.val() == '') {
                    nameField.val(typeHint).addClass(hintClass);
                }

                nameField.one('focus', function() {

                    if ($(this).hasClass(hintClass)) {
                        $(this).val("");
                        $(this).removeClass(hintClass);
                    }
                    
                });

                nameField.autocomplete(employees, {

                        formatItem: function(item) {
                            return item.name;
                        }
                        ,matchContains:true
                    }).result(function(event, item) {
                        idStoreField.val(item.id);
                    }
                    
                );
                
            }); // End of $(document).ready

        </script>
EOF
                        ,
                        $this->getEmployeeListAsJson($this->getEmployeeList()),
                        $this->getHtmlId($name),
                        $hiddenFieldId,
                        $typeHint);

        return "\n\n" . $html . "\n\n" . $this->getHiddenFieldHtml($name, $empIdValue) . "\n\n" . $javaScript . "\n\n";
        
    }
    
    protected function getHiddenFieldHtml($name, $value) {
        
        //$hiddenName = substr($name, 0, strlen($name) - 1) . '_id]';
        $hiddenName = $name . '[empId]';
        $hiddenId   = $this->getHiddenFieldId($name);
        
        return "<input type=\"hidden\" name=\"$hiddenName\" id=\"$hiddenId\" value=\"$value\" />";
        
    }
    
    protected function getHiddenFieldId($name) {
        
        return $this->generateId($name) . '_empId';
        
    }

    protected function getHtmlId($name) {
        
        if (isset($this->attributes['id'])) {
            return $this->attributes['id'];
        }
        
        return $this->generateId($name) . '_empName';
        
    }
    
    protected function getEmployeeList() {
        
        $employeeList = $this->getOption('employeeList'); 
        
        if (is_array($employeeList)) {
            return $employeeList;
        }
        
        $employees = UserRoleManagerFactory::getUserRoleManager()->getAccessibleEntities('Employee');
        return $employees;
        
    }

    protected function getEmployeeListAsJson($employeeList) {
        
        $jsonList = $this->getOption('jsonList');
        
        if (!empty($jsonList)) {
            return $jsonList;
        }

        $jsonArray = array();        
        
        foreach ($employeeList as $employee) {

            $jsonArray[] = array('name' => $employee->getFullName(), 'id' => $employee->getEmpNumber());
            
        }
        
        usort($jsonArray, array($this, 'compareByName'));

        return json_encode($jsonArray);

    }
    
    protected function compareByName($employee1, $employee2) {
        return strcmp($employee1['name'], $employee2['name']);
    }

}

