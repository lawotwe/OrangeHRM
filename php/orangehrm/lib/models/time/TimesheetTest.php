<?php
// Call TimesheetTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "TimesheetTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'Timesheet.php';

/**
 * Test class for Timesheet.
 * Generated by PHPUnit_Util_Skeleton on 2007-03-22 at 12:56:54.
 */
class TimesheetTest extends PHPUnit_Framework_TestCase {
	public $classTimesheet = null;
    public $connection = null;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("TimesheetTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$this->classTimesheet = new Timesheet();

    	$conf = new Conf();

    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);

    	mysql_query("INSERT INTO `hs_hr_employee` VALUES ('010', NULL, 'Arnold', 'Subasinghe', '', 'Arnold', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', 'AF', '', '', '', '', '', '', NULL, '0000-00-00', '')");

		mysql_query("INSERT INTO `hs_hr_customer` (`customer_id`, `name`, `description`, `deleted`) ".
    				"VALUES (10, 'OrangeHRM', 'Implement OrangeHRM', 0)");
    	mysql_query("INSERT INTO `hs_hr_project` (`project_id`, `customer_id`, `name`, `description`, `deleted`) ".
    				"VALUES (10, 10, 'OrangeHRM', 'Implement OrangeHRM', 0)");
    	mysql_query("INSERT INTO `hs_hr_timesheet_submission_period` (`timesheet_period_id`, `name`, `frequency`, `period`, `start_day`, `end_day`, `description`) ".
    				"VALUES (10, 'Permanent', 'Weekly', 1, '".date('l')."', '".date('l', time()+3600*24*7)."', 'Testing')");

    	mysql_query("INSERT INTO `hs_hr_timesheet` (`timesheet_id`, `employee_id`, `timesheet_period_id`, `start_date`, `end_date`, `status`) ".
    				"VALUES (10, 10, 10, '".date('Y-m-d')."', '".date('Y-m-d', time()+3600*24*7)."', 0)");
    	mysql_query("INSERT INTO `hs_hr_timesheet` (`timesheet_id`, `employee_id`, `timesheet_period_id`, `start_date`, `end_date`, `status`) ".
    				"VALUES (11, 10, 10, '".date('Y-m-d', time()+3600*24*7)."', '".date('Y-m-d', time()+3600*24*7*2)."', 10)");
    	mysql_query("INSERT INTO `hs_hr_timesheet` (`timesheet_id`, `employee_id`, `timesheet_period_id`, `start_date`, `end_date`, `status`) ".
    				"VALUES (12, 10, 10, '".date('Y-m-d', time()+3600*24*7*2)."', '".date('Y-m-d', time()+3600*24*7*3)."', 20)");
    	mysql_query("INSERT INTO `hs_hr_timesheet` (`timesheet_id`, `employee_id`, `timesheet_period_id`, `start_date`, `end_date`, `status`) ".
    				"VALUES (13, 10, 10, '".date('Y-m-d', time()+3600*24*7*3)."', '".date('Y-m-d', time()+3600*24*7*4)."', 30)");

		mysql_query("INSERT INTO `hs_hr_time_event` (`time_event_id`, `project_id`, `employee_id`, `timesheet_id`, `start_time`, `end_time`, `reported_date`, `duration`, `description`) ".
    				"VALUES (10, 10, 10, 10, '".date('Y-m-d H:i:00')."', '".date('Y-m-d H:i:00', time()+3600)."', '".date('Y-m-d')."', 60, 'Testing1')");
    	mysql_query("INSERT INTO `hs_hr_time_event` (`time_event_id`, `project_id`, `employee_id`, `timesheet_id`, `start_time`, `end_time`, `reported_date`, `duration`, `description`) ".
    				"VALUES (11, 10, 10, 10, '".date('Y-m-d H:i:00', time()+3600*2)."', '".date('Y-m-d H:i:00', time()+3600*3)."', '".date('Y-m-d')."', 60, 'Testing2')");
		mysql_query("INSERT INTO `hs_hr_time_event` (`time_event_id`, `project_id`, `employee_id`, `timesheet_id`, `start_time`, `end_time`, `reported_date`, `duration`, `description`) ".
    				"VALUES (12, 10, 10, 11, '".date('Y-m-d H:i:00', time()+3600*24*7)."', '".date('Y-m-d H:i:00', time()+3600*24*7+3600)."', '".date('Y-m-d', time()+3600*24*7)."', 60, 'Testing3')");

    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	mysql_query("DELETE FROM `hs_hr_time_event` WHERE `time_event_id` IN (10, 11, 12)", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_timesheet` WHERE `timesheet_id` IN (10, 11, 12, 13, 14)", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_timesheet_submission_period` WHERE `timesheet_period_id` IN (10)", $this->connection);

    	mysql_query("DELETE FROM `hs_hr_timesheet_submission_period` WHERE `timesheet_period_id` IN (10)", $this->connection);

    	mysql_query("DELETE FROM `hs_hr_project` WHERE `project_id` IN (10)", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_customer` WHERE `customer_id` IN (10)", $this->connection);
    }

    public function testfetchTimesheets() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setTimesheetId(50);
		$res = $timesheetObj->fetchTimesheets();

		$this->assertNull($res, "Returned non existing record");
    }

    public function testfetchTimesheets2() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setTimesheetId(10);
		$res = $timesheetObj->fetchTimesheets();

		$this->assertNotNull($res, "Returned non existing record");

		$expected[0]= array(10, 10, 10, date('Y-m-d'), date('Y-m-d', time()+3600*24*7), 0);

		$this->assertEquals(count($res), count($expected), "Returned invalid number of records");

 		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimesheetId());
			$this->assertEquals($expected[$i][1], $res[$i]->getEmployeeId());
			$this->assertEquals($expected[$i][2], $res[$i]->getTimesheetPeriodId());
			$this->assertEquals($expected[$i][3], $res[$i]->getStartDate());
			$this->assertEquals($expected[$i][4], $res[$i]->getEndDate());
			$this->assertEquals($expected[$i][5], $res[$i]->getStatus());
 		}
    }

    public function testfetchTimesheets3() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setStartDate(date('Y-m-d', time()+3600*24*7));
		$res = $timesheetObj->fetchTimesheets();

		$this->assertNotNull($res, "Returned non existing record");

		$expected[0]= array(11, 10, 10, date('Y-m-d', time()+3600*24*7), date('Y-m-d', time()+3600*24*7*2), 10);

		$this->assertEquals(count($res), count($expected), "Returned invalid number of records");

 		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimesheetId(), "Invalid Timesheet id");
			$this->assertEquals($expected[$i][1], $res[$i]->getEmployeeId(), "Invalid Employee id");
			$this->assertEquals($expected[$i][2], $res[$i]->getTimesheetPeriodId(), "Invalid Timesheet period id");
			$this->assertEquals($expected[$i][3], $res[$i]->getStartDate(), "Invalid Start date");
			$this->assertEquals($expected[$i][4], $res[$i]->getEndDate(), "Invalid End date");
			$this->assertEquals($expected[$i][5], $res[$i]->getStatus(), "Invalid Status");
 		}
    }

     public function testSubmitTimesheet() {
    	$timesheetObj = $this->classTimesheet;

		$timesheetObj->setTimesheetId(11);

    	$res = $timesheetObj->submitTimesheet();

    	$this->assertFalse($res);
     }

    public function testSubmitTimesheet2() {
    	$timesheetObj = $this->classTimesheet;

    	$timesheetObj->setTimesheetId(10);

    	$res = $timesheetObj->submitTimesheet();

    	$this->assertTrue($res);

    	$timesheetObj->setTimesheetId(10);

    	$res = $timesheetObj->fetchTimesheets();

		$this->assertNotNull($res, "Returned non existing record");

		$expected[0]= array(10, 10, 10, date('Y-m-d'), date('Y-m-d', time()+3600*24*7), 10);

		$this->assertEquals(count($res), count($expected), "Returned invalid number of records");

 		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimesheetId(), "Invalid Timesheet id");
			$this->assertEquals($expected[$i][1], $res[$i]->getEmployeeId(), "Invalid Employee id");
			$this->assertEquals($expected[$i][2], $res[$i]->getTimesheetPeriodId(), "Invalid Timesheet period id");
			$this->assertEquals($expected[$i][3], $res[$i]->getStartDate(), "Invalid Start date");
			$this->assertEquals($expected[$i][4], $res[$i]->getEndDate(), "Invalid End date");
			$this->assertEquals($expected[$i][5], $res[$i]->getStatus(), "Invalid Status");
 		}
	}

	public function testCancelTimesheet() {
    	$timesheetObj = $this->classTimesheet;

		$timesheetObj->setTimesheetId(10);

    	$res = $timesheetObj->cancelTimesheet();

    	$this->assertFalse($res);
     }

	public function testCancelTimesheet1() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setTimesheetId(11);

    	$res = $timesheetObj->cancelTimesheet();

    	$this->assertTrue($res);

    	$timesheetObj->setTimesheetId(11);

    	$res = $timesheetObj->fetchTimesheets();

		$this->assertNotNull($res, "Returned non existing record");

		$expected[0]= array(11, 10, 10, date('Y-m-d', time()+3600*24*7), date('Y-m-d', time()+3600*24*7*2), 0);

		$this->assertEquals(count($res), count($expected), "Returned invalid number of records");

 		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimesheetId(), "Invalid Timesheet id");
			$this->assertEquals($expected[$i][1], $res[$i]->getEmployeeId(), "Invalid Employee id");
			$this->assertEquals($expected[$i][2], $res[$i]->getTimesheetPeriodId(), "Invalid Timesheet period id");
			$this->assertEquals($expected[$i][3], $res[$i]->getStartDate(), "Invalid Start date");
			$this->assertEquals($expected[$i][4], $res[$i]->getEndDate(), "Invalid End date");
			$this->assertEquals($expected[$i][5], $res[$i]->getStatus(), "Invalid Status");
 		}
	}

	public function testApproveTimesheet() {
    	$timesheetObj = $this->classTimesheet;

		$timesheetObj->setTimesheetId(10);

    	$res = $timesheetObj->approveTimesheet();

    	$this->assertFalse($res);
     }

 	public function testApproveTimesheet1() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setTimesheetId(11);
		$timesheetObj->setComment('Testing...');

    	$res = $timesheetObj->approveTimesheet();

    	$this->assertTrue($res);

    	$timesheetObj->setTimesheetId(11);

    	$res = $timesheetObj->fetchTimesheets();

		$this->assertNotNull($res, "Returned non existing record");

		$expected[0]= array(11, 10, 10, date('Y-m-d', time()+3600*24*7), date('Y-m-d', time()+3600*24*7*2), 20, 'Testing...');

		$this->assertEquals(count($res), count($expected), "Returned invalid number of records");

 		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimesheetId(), "Invalid Timesheet id");
			$this->assertEquals($expected[$i][1], $res[$i]->getEmployeeId(), "Invalid Employee id");
			$this->assertEquals($expected[$i][2], $res[$i]->getTimesheetPeriodId(), "Invalid Timesheet period id");
			$this->assertEquals($expected[$i][3], $res[$i]->getStartDate(), "Invalid Start date");
			$this->assertEquals($expected[$i][4], $res[$i]->getEndDate(), "Invalid End date");
			$this->assertEquals($expected[$i][5], $res[$i]->getStatus(), "Invalid Status");
			$this->assertEquals($expected[$i][6], $res[$i]->getComment(), "Invalid Comment");
 		}
	}

	public function testRejectTimesheet() {
    	$timesheetObj = $this->classTimesheet;

		$timesheetObj->setTimesheetId(10);

    	$res = $timesheetObj->rejectTimesheet();

    	$this->assertFalse($res);
     }

	public function testRejectTimesheet2() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setTimesheetId(11);

    	$res = $timesheetObj->rejectTimesheet();

    	$this->assertTrue($res);

    	$timesheetObj->setTimesheetId(11);

    	$res = $timesheetObj->fetchTimesheets();

		$this->assertNotNull($res, "Returned non existing record");

		$expected[0]= array(11, 10, 10, date('Y-m-d', time()+3600*24*7), date('Y-m-d', time()+3600*24*7*2), 30);

		$this->assertEquals(count($res), count($expected), "Returned invalid number of records");

 		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimesheetId(), "Invalid Timesheet id");
			$this->assertEquals($expected[$i][1], $res[$i]->getEmployeeId(), "Invalid Employee id");
			$this->assertEquals($expected[$i][2], $res[$i]->getTimesheetPeriodId(), "Invalid Timesheet period id");
			$this->assertEquals($expected[$i][3], $res[$i]->getStartDate(), "Invalid Start date");
			$this->assertEquals($expected[$i][4], $res[$i]->getEndDate(), "Invalid End date");
			$this->assertEquals($expected[$i][5], $res[$i]->getStatus(), "Invalid Status");
 		}
	}

    public function testAddTimesheet() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setEmployeeId(10);
		$timesheetObj->setTimesheetPeriodId(10);
		$timesheetObj->setStartDate(date('Y-m-d', time()+3600*24*7*4));
		$timesheetObj->setEndDate(date('Y-m-d', time()+3600*24*7*5));

		$timesheetObj->addTimesheet();

		$res = $timesheetObj->fetchTimesheets();

		$this->assertNotNull($res, "Returned non existing record");

		$expected[0]= array(14, 10, 10, date('Y-m-d', time()+3600*24*7*4), date('Y-m-d', time()+3600*24*7*5), 0);

		$this->assertEquals(count($res), count($expected), "Returned invalid number of records");

 		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimesheetId(), "Invalid Timesheet id");
			$this->assertEquals($expected[$i][1], $res[$i]->getEmployeeId(), "Invalid Employee id");
			$this->assertEquals($expected[$i][2], $res[$i]->getTimesheetPeriodId(), "Invalid Timesheet period id");
			$this->assertEquals($expected[$i][3], $res[$i]->getStartDate(), "Invalid Start date");
			$this->assertEquals($expected[$i][4], $res[$i]->getEndDate(), "Invalid End date");
			$this->assertEquals($expected[$i][5], $res[$i]->getStatus(), "Invalid Status");
 		}
    }

    public function testAddTimesheet2() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setEmployeeId(10);
		$timesheetObj->setTimesheetPeriodId(10);

		$timesheetObj->addTimesheet();

		$res = $timesheetObj->fetchTimesheets();

		$this->assertNotNull($res, "Returned non existing record");

		$day=date("w");

		$expected[0]= array(14, 10, 1, date('Y-m-d', time()+3600*24*(1-$day)), date('Y-m-d', time()+3600*24*(7-$day)), 0);

		$this->assertEquals(count($res), count($expected), "Returned invalid number of records");

 		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimesheetId(), "Invalid Timesheet id");
			$this->assertEquals($expected[$i][1], $res[$i]->getEmployeeId(), "Invalid Employee id");
			$this->assertEquals($expected[$i][2], $res[$i]->getTimesheetPeriodId(), "Invalid Timesheet period id");
			$this->assertEquals($expected[$i][3], $res[$i]->getStartDate(), "Invalid Start date");
			$this->assertEquals($expected[$i][4], $res[$i]->getEndDate(), "Invalid End date");
			$this->assertEquals($expected[$i][5], $res[$i]->getStatus(), "Invalid Status");
 		}
    }

    public function testFetchTimesheetId() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setEmployeeId(10);
		$timesheetObj->setStartDate(date('Y-m-d'));
		$timesheetObj->setEndDate(date('Y-m-d', time()+3600*24*6));

		$timesheetObj->setStatus(Timesheet::TIMESHEET_STATUS_SUBMITTED);

		$res = $timesheetObj->fetchTimesheetId(Timesheet::TIMESHEET_DIRECTION_PREV);

		$this->assertFalse($res, 'Invalid id returned');
    }

    public function testFetchTimesheetId1() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setEmployeeId(10);
		$timesheetObj->setStartDate(date('Y-m-d'));
		$timesheetObj->setEndDate(date('Y-m-d', time()+3600*24*6));

		$timesheetObj->setStatus(Timesheet::TIMESHEET_STATUS_SUBMITTED);

		$res = $timesheetObj->fetchTimesheetId(Timesheet::TIMESHEET_DIRECTION_NEXT);

		$this->assertEquals(11, $res, 'Invalid id returned');
    }

    public function testFetchTimesheetId2() {
		$timesheetObj = $this->classTimesheet;

		$timesheetObj->setEmployeeId(10);
		$timesheetObj->setStartDate(date('Y-m-d', time()+3600*24*7*1+3600*24*6));
		$timesheetObj->setEndDate(date('Y-m-d', time()+3600*24*7*3));

		$timesheetObj->setStatus(Timesheet::TIMESHEET_STATUS_SUBMITTED);

		$res = $timesheetObj->fetchTimesheetId(Timesheet::TIMESHEET_DIRECTION_PREV);

		$this->assertEquals(11, $res, 'Invalid id returned');
    }

}

// Call TimesheetTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "TimesheetTest::main") {
    TimesheetTest::main();
}
?>
