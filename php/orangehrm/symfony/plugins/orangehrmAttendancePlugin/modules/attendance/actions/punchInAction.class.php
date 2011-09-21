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
class punchInAction extends sfAction {

    private $attendanceService;

    public function getAttendanceService() {

        if (is_null($this->attendanceService)) {

            $this->attendanceService = new AttendanceService();
        }

        return $this->attendanceService;
    }

    public function setAttendanceService(AttendanceService $attendanceService) {

        $this->attendanceService = $attendanceService;
    }

    public function execute($request) {

        $this->editmode = null;
        $this->userObj = $this->getContext()->getUser()->getAttribute('user');
        $this->employeeId = $this->userObj->getEmployeeNumber();
        $actions = array(PluginWorkflowStateMachine::ATTENDANCE_ACTION_PUNCH_OUT);
        $actionableStatesList = $this->userObj->getActionableAttendanceStates($actions);
        $timeZoneOffset = $this->userObj->getUserTimeZoneOffset();
        print_r($timeZoneOffset);
        $timeStampDiff = $timeZoneOffset * 3600 - date('Z');
        $this->currentDate = date('Y-m-d', time() + $timeStampDiff);
        $this->currentTime = date('H:i', time() + $timeStampDiff);
        $this->timezone = $timeZoneOffset * 3600;


        if ($this->getUser()->hasFlash('templateMessage')) {
            list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
        }
        $attendanceRecord = $this->getAttendanceService()->getLastPunchRecord($this->employeeId, $actionableStatesList);


        if (is_null($attendanceRecord)) {

            $this->allowedActions = $this->userObj->getAllowedActions(WorkflowStateMachine::FLOW_ATTENDANCE, AttendanceRecord::STATE_INITIAL);
        } else {

            $this->redirect("attendance/punchOut");
        }


        $this->punchInTime = null;
        $this->punchInUtcTime = null;
        $this->punchInNote = null;
        $this->actionPunchOut = null;

        $this->form = new AttendanceForm();
        $this->actionPunchIn = $this->getActionName();
        $this->attendanceFormToImplementCsrfToken = new AttendanceFormToImplementCsrfToken();


        if ($request->isMethod('post')) {

            $accessFlowStateMachineService = new AccessFlowStateMachineService();
            $attendanceRecord = new AttendanceRecord();
            $attendanceRecord->setEmployeeId($this->employeeId);


            if (!(in_array(PluginWorkflowStateMachine::ATTENDANCE_ACTION_EDIT_PUNCH_IN_TIME, $this->allowedActions)) && (in_array(PluginWorkflowStateMachine::ATTENDANCE_ACTION_PUNCH_IN, $this->allowedActions))) {
                $this->attendanceFormToImplementCsrfToken->bind($request->getParameter('attendance'));
           
                if ($this->attendanceFormToImplementCsrfToken->isValid()) {

  
                    $punchInDate = $this->request->getParameter('date');
                    $punchIntime = $this->request->getParameter('time');
                    $punchInNote = $this->request->getParameter('note');
                    $timeZoneOffset = $this->request->getParameter('timeZone');

                    $nextState = $this->userObj->getNextState(WorkflowStateMachine::FLOW_ATTENDANCE, AttendanceRecord::STATE_INITIAL, WorkflowStateMachine::ATTENDANCE_ACTION_PUNCH_IN);

                    $punchIndateTime = strtotime($punchInDate . " " . $punchIntime);
//                $attendanceRecord->setPunchInUtcTime(date('Y-m-d H:i', time() + $timeStampDiff - $timeZoneOffset * 3600));
//                $attendanceRecord->setPunchInNote($punchInNote);
//                $attendanceRecord->setPunchInUserTime(date('Y-m-d H:i', time() + $timeStampDiff));
//                $attendanceRecord->setPunchInTimeOffset($timeZoneOffset);
//                $attendanceRecord->setstate($nextState);
//
//                $this->getAttendanceService()->savePunchRecord($attendanceRecord);z

                    $attendanceRecord = $this->setAttendanceRecord($attendanceRecord, $nextState, date('Y-m-d H:i', $punchIndateTime - $timeZoneOffset), date('Y-m-d H:i', $punchIndateTime), $timeZoneOffset / 3600, $punchInNote);

                    $this->redirect("attendance/punchOut");

//                $clientTimeZone = $this->getAttendanceService()->getLocalTimezone($timeZoneOffset);
//                date_default_timezone_set($clientTimeZone);
//
//                $punchInDate = $this->request->getParameter('date');
//                $punchIntime = $this->request->getParameter('time');
//                $punchInNote = $this->request->getParameter('note');
//                $nextState = $this->userObj->getNextState(WorkflowStateMachine::FLOW_ATTENDANCE, AttendanceRecord::STATE_INITIAL, WorkflowStateMachine::ATTENDANCE_ACTION_PUNCH_IN);
//
//                $this->setAttendanceRecord($attendanceRecord, $nextState, gmdate('Y-m-d H:i', time()), date('Y-m-d H:i', strtotime($punchInDate . " " . $punchIntime)), $timeZoneOffset, $punchInNote);
//
//                $this->redirect("attendance/punchOut");
                }
            } else {

                $this->form->bind($request->getParameter('attendance'));

                if ($this->form->isValid()) {

                    $punchInDate = $this->form->getValue('date');
                    $punchIntime = $this->form->getValue('time');
                    $punchInNote = $this->form->getValue('note');
                    $timeZoneOffset = $this->request->getParameter('timeZone');

                    $punchInEditModeTime = mktime(date('H', strtotime($punchIntime)), date('i', strtotime($punchIntime)), 0, date('m', strtotime($punchInDate)), date('d', strtotime($punchInDate)), date('Y', strtotime($punchInDate)));

//                    print_r(date('Y-m-d H:i',$punchInEditModeTime));
//                    die;
//                    if ($punchInDate != date('Y-m-d', time() + $timeStampDiff)) {
//                        $userDateTime = new DateTime($punchIntime);
//                        $userDateTime->setDate(date('Y', strtotime($punchInDate)), date('m', strtotime($punchInDate)), date('d', strtotime($punchInDate)));
//
//                    } else {
//                        $userDateTime = new DateTime($punchIntime);
//                    }


                    $nextState = $this->userObj->getNextState(WorkflowStateMachine::FLOW_ATTENDANCE, AttendanceRecord::STATE_INITIAL, WorkflowStateMachine::ATTENDANCE_ACTION_PUNCH_IN);
//                    $attendanceRecord->setState($nextState);
//                    $attendanceRecord->setPunchInUtcTime(date('Y-m-d H:i', $punchInEditModeTime - $timeZoneOffset * 3600));
//                    $attendanceRecord->setPunchInNote($punchInNote);
//                    $attendanceRecord->setPunchInUserTime(date('Y-m-d H:i', $punchInEditModeTime));
//                    $attendanceRecord->setPunchInTimeOffset($timeZoneOffset);
                    $attendanceRecord = $this->setAttendanceRecord($attendanceRecord, $nextState, date('Y-m-d H:i', $punchInEditModeTime - $timeZoneOffset), date('Y-m-d H:i', $punchInEditModeTime), $timeZoneOffset / 3600, $punchInNote);
//                    $this->getAttendanceService()->savePunchRecord($attendanceRecord);
                    $this->redirect("attendance/punchOut");





//                    $clientTimeZone = $this->getAttendanceService()->getLocalTimezone($timeZoneOffset);
//                    date_default_timezone_set($clientTimeZone);
//                    $punchInDate = $this->form->getValue('date');
//                    $punchIntime = $this->form->getValue('time');
//                    $punchInNote = $this->form->getValue('note');
//
//                    $punchInEditModeTime = mktime(date('H', strtotime($punchIntime)), date('i', strtotime($punchIntime)), 0, date('m', strtotime($punchInDate)), date('d', strtotime($punchInDate)), date('Y', strtotime($punchInDate)));
//                    $nextState = $this->userObj->getNextState(WorkflowStateMachine::FLOW_ATTENDANCE, AttendanceRecord::STATE_INITIAL, WorkflowStateMachine::ATTENDANCE_ACTION_PUNCH_IN);
//
//                    $attendanceRecord = $this->setAttendanceRecord($attendanceRecord, $nextState, gmdate('Y-m-d H:i', $punchInEditModeTime), date('Y-m-d H:i', $punchInEditModeTime), $timeZoneOffset, $punchInNote);
//
//                    $this->redirect("attendance/punchOut");
                }
            }
        }

        $this->setTemplate("punchTime");
    }

    public function setAttendanceRecord($attendanceRecord, $state, $punchInUtcTime, $punchInUserTime, $punchInTimezoneOffset, $punchInNote) {

        $attendanceRecord->setState($state);
        $attendanceRecord->setPunchInUtcTime($punchInUtcTime);
        $attendanceRecord->setPunchInUserTime($punchInUserTime);
        $attendanceRecord->setPunchInNote($punchInNote);
        $attendanceRecord->setPunchInTimeOffset($punchInTimezoneOffset);
        return $this->getAttendanceService()->savePunchRecord($attendanceRecord);
    }

}

?>
