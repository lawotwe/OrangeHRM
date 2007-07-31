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


// Call TimeEventTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "TimeEventTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

require_once 'TimeEvent.php';

require_once ROOT_PATH."/lib/confs/Conf.php";

/**
 * Test class for TimeEvent.
 * Generated by PHPUnit_Util_Skeleton on 2007-03-20 at 11:24:22.
 */
class TimeEventTest extends PHPUnit_Framework_TestCase {
	public $classTimeEvent = null;
    public $connection = null;
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("TimeEventTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$this->classTimeEvent = new TimeEvent();

    	$conf = new Conf();

    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
    	mysql_query("INSERT INTO `hs_hr_employee` VALUES ('010', NULL, 'Arnold', 'Subasinghe', '', 'Arnold', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', 'AF', '', '', '', '', '', '', NULL, '0000-00-00', '')");

    	mysql_query("INSERT INTO `hs_hr_customer` (`customer_id`, `name`, `description`, `deleted`) ".
    				"VALUES (10, 'OrangeHRM', 'Implement OrangeHRM', 0)");
    	mysql_query("INSERT INTO `hs_hr_project` (`project_id`, `customer_id`, `name`, `description`, `deleted`) ".
    				"VALUES (10, 10, 'OrangeHRM', 'Implement OrangeHRM', 0)");
    	mysql_query("INSERT INTO `hs_hr_project_activity` (`activity_id`, `project_id`, `name`) VALUES (10, 10, 'Test');");

    	mysql_query("INSERT INTO `hs_hr_timesheet_submission_period` (`timesheet_period_id`, `name`, `frequency`, `period`, `start_day`, `end_day`, `description`) ".
    				"VALUES (10, 'Permanent', 7, 1, ".date('N').", ".date('N', time()+3600*24*6).", 'Testing')");
    	mysql_query("INSERT INTO `hs_hr_timesheet` (`timesheet_id`, `employee_id`, `timesheet_period_id`, `start_date`, `end_date`, `status`) ".
    				"VALUES (10, 10, 10, '".date('Y-m-d')."', '".date('Y-m-d', time()+3600*24*6)."', 0)");
		mysql_query("INSERT INTO `hs_hr_timesheet` (`timesheet_id`, `employee_id`, `timesheet_period_id`, `start_date`, `end_date`, `status`) ".
    				"VALUES (11, 10, 10, '".date('Y-m-d', time()+3600*24*7)."', '".date('Y-m-d', time()+3600*24*13)."', 0)");
		mysql_query("INSERT INTO `hs_hr_timesheet` (`timesheet_id`, `employee_id`, `timesheet_period_id`, `start_date`, `end_date`, `status`) ".
    				"VALUES (11, 10, 10, '".date('Y-m-d', time()*3600*24*7)."', '".date('Y-m-d', time()*3600*24*14)."', 0)");

		mysql_query("INSERT INTO `hs_hr_time_event` (`time_event_id`, `project_id`, `activity_id`, `employee_id`, `timesheet_id`, `start_time`, `end_time`, `reported_date`, `duration`, `description`) ".
    				"VALUES (10, 10, 10, 10, 10, '".date('Y-m-d H:i')."', '".date('Y-m-d H:i', time()+3600)."', '".date('Y-m-d')."', 60, 'Testing')");
    	mysql_query("INSERT INTO `hs_hr_time_event` (`time_event_id`, `project_id`, `activity_id`, `employee_id`, `timesheet_id`, `start_time`, `end_time`, `reported_date`, `duration`, `description`) ".
    				"VALUES (11, 10, 10, 10, 10, '".date('Y-m-d H:i', time()+3600)."', '".date('Y-m-d H:i', time()+3600*2)."', '".date('Y-m-d')."', 60, 'Testing1')");
		mysql_query("INSERT INTO `hs_hr_time_event` (`time_event_id`, `project_id`, `activity_id`, `employee_id`, `timesheet_id`, `start_time`, `end_time`, `reported_date`, `duration`, `description`) ".
    				"VALUES (12, 10, 10, 10, 10, '".date('Y-m-d H:i', time()+3600*2)."', NULL, '".date('Y-m-d')."', NULL, 'Testing2')");

    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	mysql_query("DELETE FROM `hs_hr_time_event` WHERE `time_event_id` IN (10, 11, 12, 13)", $this->connection);

    	mysql_query("DELETE FROM `hs_hr_timesheet` WHERE `timesheet_id` IN (10, 11, 12)", $this->connection);

    	mysql_query("DELETE FROM `hs_hr_timesheet_submission_period` WHERE `timesheet_period_id` = 10", $this->connection);

		mysql_query("DELETE FROM `hs_hr_project_activity` WHERE `activity_id` = 10", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_project` WHERE `project_id` = 10", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_customer` WHERE `customer_id` = 10", $this->connection);
    }

    public function testFetchTimeEvents() {
    	$eventObj = $this->classTimeEvent;

		$eventObj->setTimesheetId(50);

    	$res = $eventObj->fetchTimeEvents();

    	$this->assertEquals($res, false, "Returned non existing record");
    }

    public function testFetchTimeEvents2() {
    	$eventObj = $this->classTimeEvent;

		$eventObj->setTimesheetId(10);

    	$res = $eventObj->fetchTimeEvents();

		$expected[0] = array(10, 10, 10, 10, 10, date('Y-m-d H:i'), date('Y-m-d H:i', time()+3600), date('Y-m-d'), 60, 'Testing');
		$expected[1] = array(11, 10, 10, 10, 10, date('Y-m-d H:i', time()+3600), date('Y-m-d H:i', time()+3600*2), date('Y-m-d'), 60, 'Testing1');
		$expected[2] = array(12, 10, 10, 10, 10, date('Y-m-d H:i', time()+3600*2), null, date('Y-m-d'), null, 'Testing2');

		$this->assertNotNull($res, "Returned nothing");

		$this->assertEquals(count($res), count($expected), "Didn't return the expected number of records");

		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimeEventId(), "Invalid time event id");
		 	$this->assertEquals($expected[$i][1], $res[$i]->getProjectId(), "Invalid project id");
		 	$this->assertEquals($expected[$i][2], $res[$i]->getActivityId(), "Invalid activity id");
		 	$this->assertEquals($expected[$i][3], $res[$i]->getEmployeeId(), "Invalid employee id");
		 	$this->assertEquals($expected[$i][4], $res[$i]->getTimesheetId(), "Invalid timesheet id");
		 	$this->assertEquals($expected[$i][5], $res[$i]->getStartTime(), "Invalid start time");
		 	$this->assertEquals($expected[$i][6], $res[$i]->getEndTime(), "Invalid end time");
		 	$this->assertEquals($expected[$i][7], $res[$i]->getReportedDate(), "Invalid reported date");
		 	$this->assertEquals($expected[$i][8], $res[$i]->getDuration(), "Invalid duration");
		 	$this->assertEquals($expected[$i][9], $res[$i]->getDescription(), "Invalid description");
		}
    }

    public function testFetchTimeEvents3() {
    	$eventObj = $this->classTimeEvent;

		$eventObj->setTimesheetId(10);

    	$res = $eventObj->fetchTimeEvents(true);

		$expected[0] = array(12, 10, 10, 10, 10, date('Y-m-d H:i', time()+3600*2), null, date('Y-m-d'), null, 'Testing2');

		$this->assertNotNull($res, "Returned nothing");

		$this->assertEquals(count($res), count($expected), "Didn't return the expected number of records");

		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimeEventId(), "Invalid time event id");
		 	$this->assertEquals($expected[$i][1], $res[$i]->getProjectId(), "Invalid project id");
		 	$this->assertEquals($expected[$i][2], $res[$i]->getActivityId(), "Invalid activity id");
		 	$this->assertEquals($expected[$i][3], $res[$i]->getEmployeeId(), "Invalid employee id");
		 	$this->assertEquals($expected[$i][4], $res[$i]->getTimesheetId(), "Invalid timesheet id");
		 	$this->assertEquals($expected[$i][5], $res[$i]->getStartTime(), "Invalid start time");
		 	$this->assertEquals($expected[$i][6], $res[$i]->getEndTime(), "Invalid end time");
		 	$this->assertEquals($expected[$i][7], $res[$i]->getReportedDate(), "Invalid reported date");
		 	$this->assertEquals($expected[$i][8], $res[$i]->getDuration(), "Invalid duration");
		 	$this->assertEquals($expected[$i][9], $res[$i]->getDescription(), "Invalid description");
		}
    }

    public function testAddTimeEvent() {
    	mysql_query("DELETE FROM `hs_hr_time_event` WHERE `time_event_id` IN (12)", $this->connection);

		$eventObj = $this->classTimeEvent;

		$expected[0] = array(13, 10, 10, 10, 10, date('Y-m-d H:i', time()+3600*3), date('Y-m-d H:i', time()+3600*4.5), date('Y-m-d'), 90, "Testing2");

		$eventObj->setProjectId($expected[0][1]);
		$eventObj->setActivityId($expected[0][2]);
		$eventObj->setEmployeeId($expected[0][3]);
		$eventObj->setTimesheetId($expected[0][4]);
		$eventObj->setStartTime($expected[0][5]);
		$eventObj->setEndTime($expected[0][6]);
		$eventObj->setReportedDate($expected[0][7]);
		$eventObj->setDuration($expected[0][8]);
		$eventObj->setDescription($expected[0][9]);

		$res = $eventObj->addTimeEvent();

		$this->assertTrue($res, "Adding failed");

		$expected[0][0] = $eventObj->getTimeEventId();

		$res = $eventObj->fetchTimeEvents();

		$this->assertNotNull($res, "Returned nothing");

		$this->assertEquals(count($res), count($expected), "Didn't return the expected number of records");

		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimeEventId(), "Invalid time event id");
		 	$this->assertEquals($expected[$i][1], $res[$i]->getProjectId(), "Invalid project id");
		 	$this->assertEquals($expected[$i][2], $res[$i]->getActivityId(), "Invalid activity id");
		 	$this->assertEquals($expected[$i][3], $res[$i]->getEmployeeId(), "Invalid employee id");
		 	$this->assertEquals($expected[$i][4], $res[$i]->getTimesheetId(), "Invalid timesheet id");
		 	$this->assertEquals($expected[$i][5], $res[$i]->getStartTime(), "Invalid start time");
		 	$this->assertEquals($expected[$i][6], $res[$i]->getEndTime(), "Invalid end time");
		 	$this->assertEquals($expected[$i][7], $res[$i]->getReportedDate(), "Invalid reported date");
		 	$this->assertEquals($expected[$i][8], $res[$i]->getDuration(), "Invalid duration");
		 	$this->assertEquals($expected[$i][9], $res[$i]->getDescription(), "Invalid description");
		}
    }

    public function testEditTimeEvent() {
		$eventObj = $this->classTimeEvent;

		$expected[0] = array(11, 10, 10, 10, 10, date('Y-m-d H:i', time()-3600), date('Y-m-d H:i', time()-3600*0.5), date('Y-m-d'), 30, "Testing12");

		$eventObj->setTimeEventId($expected[0][0]);
		$eventObj->setProjectId($expected[0][1]);
		$eventObj->setActivityId($expected[0][2]);
		$eventObj->setEmployeeId($expected[0][3]);
		$eventObj->setTimesheetId($expected[0][4]);
		$eventObj->setStartTime($expected[0][5]);
		$eventObj->setEndTime($expected[0][6]);
		$eventObj->setReportedDate($expected[0][7]);
		$eventObj->setDuration($expected[0][8]);
		$eventObj->setDescription($expected[0][9]);

		$res = $eventObj->editTimeEvent();

		$this->assertTrue($res, "Editing failed");

		$res = $eventObj->fetchTimeEvents();

		$this->assertNotNull($res, "Returned nothing");

		$this->assertEquals(count($res), count($expected), "Didn't return the expected number of records");

		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimeEventId(), "Invalid time event id");
		 	$this->assertEquals($expected[$i][1], $res[$i]->getProjectId(), "Invalid project id");
		 	$this->assertEquals($expected[$i][2], $res[$i]->getActivityId(), "Invalid activity id");
		 	$this->assertEquals($expected[$i][3], $res[$i]->getEmployeeId(), "Invalid employee id");
		 	$this->assertEquals($expected[$i][4], $res[$i]->getTimesheetId(), "Invalid timesheet id");
		 	$this->assertEquals($expected[$i][5], $res[$i]->getStartTime(), "Invalid start time");
		 	$this->assertEquals($expected[$i][6], $res[$i]->getEndTime(), "Invalid end time");
		 	$this->assertEquals($expected[$i][7], $res[$i]->getReportedDate(), "Invalid reported date");
		 	$this->assertEquals($expected[$i][8], $res[$i]->getDuration(), "Invalid duration");
		 	$this->assertEquals($expected[$i][9], $res[$i]->getDescription(), "Invalid description");
		}
    }

    public function testPendingTimeEvents() {
		$eventObj = $this->classTimeEvent;

		$eventObj->setTimeEventId(11);

    	$res = $eventObj->pendingTimeEvents();

		$this->assertNull($res, "Returned completed time event");
    }

    public function testPendingTimeEvents2() {
    	$eventObj = $this->classTimeEvent;

		$eventObj->setTimeEventId(12);

    	$res = $eventObj->pendingTimeEvents();

		$expected[0] = array(12, 10, 10, 10, 10, date('Y-m-d H:i', time()+3600*2), null, date('Y-m-d'), null, 'Testing2');

		$this->assertNotNull($res, "Returned nothing");

		$this->assertEquals(count($res), count($expected), "Didn't return the expected number of records");

		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimeEventId(), "Invalid time event id");
		 	$this->assertEquals($expected[$i][1], $res[$i]->getProjectId(), "Invalid project id");
		 	$this->assertEquals($expected[$i][2], $res[$i]->getActivityId(), "Invalid activity id");
		 	$this->assertEquals($expected[$i][3], $res[$i]->getEmployeeId(), "Invalid employee id");
		 	$this->assertEquals($expected[$i][4], $res[$i]->getTimesheetId(), "Invalid timesheet id");
		 	$this->assertEquals($expected[$i][5], $res[$i]->getStartTime(), "Invalid start time");
		 	$this->assertEquals($expected[$i][6], $res[$i]->getEndTime(), "Invalid end time");
		 	$this->assertEquals($expected[$i][7], $res[$i]->getReportedDate(), "Invalid reported date");
		 	$this->assertEquals($expected[$i][8], $res[$i]->getDuration(), "Invalid duration");
		 	$this->assertEquals($expected[$i][9], $res[$i]->getDescription(), "Invalid description");
		}
    }

    public function testPendingTimeEvents3() {
    	$eventObj = $this->classTimeEvent;

		$res = $eventObj->pendingTimeEvents();

		$expected[0] = array(12, 10, 10, 10, 10, date('Y-m-d H:i', time()+3600*2), null, date('Y-m-d'), null, 'Testing2');

		$this->assertNotNull($res, "Returned nothing when no id was specified");

		$this->assertEquals(count($res), count($expected), "Didn't return the expected number of records");

		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimeEventId(), "Invalid time event id");
		 	$this->assertEquals($expected[$i][1], $res[$i]->getProjectId(), "Invalid project id");
		 	$this->assertEquals($expected[$i][2], $res[$i]->getActivityId(), "Invalid activity id");
		 	$this->assertEquals($expected[$i][3], $res[$i]->getEmployeeId(), "Invalid employee id");
		 	$this->assertEquals($expected[$i][4], $res[$i]->getTimesheetId(), "Invalid timesheet id");
		 	$this->assertEquals($expected[$i][5], $res[$i]->getStartTime(), "Invalid start time");
		 	$this->assertEquals($expected[$i][6], $res[$i]->getEndTime(), "Invalid end time");
		 	$this->assertEquals($expected[$i][7], $res[$i]->getReportedDate(), "Invalid reported date");
		 	$this->assertEquals($expected[$i][8], $res[$i]->getDuration(), "Invalid duration");
		 	$this->assertEquals($expected[$i][9], $res[$i]->getDescription(), "Invalid description");
		}
    }

    public function testDeleteTimeEvent() {
    	$eventObj = $this->classTimeEvent;

    	$eventObj->setTimeEventId(10);

    	$res = $eventObj->deleteTimeEvent();

    	$this->assertTrue($res, "Deletion failed");

    	$res = $eventObj->fetchTimeEvents();

    	$this->assertNull($res, "Found deleted records");
    }

    public function testResolveTimesheet() {
    	$timesheetObj = new Timesheet();

    	$eventObj = $this->classTimeEvent;

    	$expected[0] = array(11, 10, 10, 10, 10, date('Y-m-d H:i', time()+3600), date('Y-m-d H:i', time()+3600*1.5), date('Y-m-d'), 30, "Testing12");

		$eventObj->setProjectId($expected[0][1]);
		$eventObj->setEmployeeId($expected[0][3]);
		$eventObj->setStartTime($expected[0][5]);
		$eventObj->setEndTime($expected[0][6]);

		$eventObj->resolveTimesheet(10);

		$this->assertNotNull($eventObj->getTimesheetId(), "Timesheet id was not resolved");
		$this->assertEquals($eventObj->getTimesheetId(), $expected[0][4], "Timesheet id is invalid");
    }

     public function testResolveTimesheet2() {
    	$eventObj = $this->classTimeEvent;

    	$expected[0] = array(11, 10, 10, 10, 12, date('Y-m-d H:i', time()+3600*24*15), date('Y-m-d H:i', (time()+3600*24*15)+1800), date('Y-m-d'), 30, "Testing12");

		$eventObj->setProjectId($expected[0][1]);
		$eventObj->setEmployeeId($expected[0][3]);
		$eventObj->setStartTime($expected[0][5]);
		$eventObj->setEndTime($expected[0][6]);

		$eventObj->resolveTimesheet(10);

		$this->assertNotNull($eventObj->getTimesheetId(), "Timesheet id was not resolved");
		$this->assertEquals($eventObj->getTimesheetId(), $expected[0][4], "Timesheet id is invalid");
    }

    public function testTimeReport() {
		$eventObj = $this->classTimeEvent;

    	$eventObj->setEmployeeId(10);

    	$res = $eventObj->timeReport(date('Y-m-d', time()+3600*24), date('Y-m-d', time()+3600*47));

    	$this->assertNull($res, "Empty report received");
    }

    public function testTimeReport2() {
		$eventObj = $this->classTimeEvent;

    	$expected[10][10] = array(120);

    	$eventObj->setEmployeeId(10);

    	$res = $eventObj->timeReport(date('Y-m-d'), date('Y-m-d', time()+3600*2));

    	$this->assertNotNull($res, "Empty report received");

    	$this->assertType("array", $res, "Results are not an array");

    	foreach ($res as $projectId=>$projectDetails) {
    		$this->assertType("array", $expected[$projectId], "Wrong result format");
    		foreach ($projectDetails as $activityId=>$timeSpent) {
    			$this->assertType("array", $expected[$projectId][$activityId], "Results are not an array");
				$this->assertEquals($expected[$projectId][$activityId][0], $timeSpent, "Timespent wrong");
    		}
    	}
    }
}

// Call TimeEventTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "TimeEventTest::main") {
    TimeEventTest::main();
}
?>
