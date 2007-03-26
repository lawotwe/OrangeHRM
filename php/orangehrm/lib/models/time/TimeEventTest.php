<?php
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
    	mysql_query("INSERT INTO `hs_hr_timesheet_submission_period` (`timesheet_period_id`, `name`, `frequency`, `period`, `start_day`, `end_day`, `description`) ".
    				"VALUES (10, 'Permanent', 'Weekly', 1, '".date('l')."', '".date('l', time()*3600*24*7)."', 'Testing')");
    	mysql_query("INSERT INTO `hs_hr_timesheet` (`timesheet_id`, `employee_id`, `timesheet_period_id`, `start_date`, `end_date`, `status`) ".
    				"VALUES (10, 10, 10, '".date('Y-m-d')."', '".date('Y-m-d', time()*3600*24)."', 0)");

		mysql_query("INSERT INTO `hs_hr_time_event` (`time_event_id`, `project_id`, `employee_id`, `timesheet_id`, `start_time`, `end_time`, `reported_date`, `duration`, `description`) ".
    				"VALUES (10, 10, 10, 10, '".date('Y-m-d H:i:00')."', '".date('Y-m-d H:i:00', time()+3600)."', '".date('Y-m-d')."', 60, 'Testing')");

    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	mysql_query("DELETE FROM `hs_hr_time_event` WHERE `time_event_id` = 10", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_timesheet` WHERE `timesheet_id` = 10", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_timesheet_submission_period` WHERE `timesheet_period_id` = 10", $this->connection);
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

		$expected[0] = array(10, 10, 10, 10, date('Y-m-d H:i:00'), date('Y-m-d H:i:00', time()+3600), date('Y-m-d'), 60, 'Testing');

		$this->assertNotNull($res, "Returned nothing");

		 $this->assertEquals(count($res), 1, "Didn't return the expected number of records");

		 for ($i=0; $i<count($res); $i++) {
		 	$this->assertEquals($expected[$i][0], $res[$i]->getTimeEventId(), "Invalid time event id");
		 	$this->assertEquals($expected[$i][1], $res[$i]->getProjectId(), "Invalid project id");
		 	$this->assertEquals($expected[$i][2], $res[$i]->getEmployeeId(), "Invalid employee id");
		 	$this->assertEquals($expected[$i][3], $res[$i]->getTimesheetId(), "Invalid timesheet id");
		 	$this->assertEquals($expected[$i][4], $res[$i]->getStartTime(), "Invalid start time");
		 	$this->assertEquals($expected[$i][5], $res[$i]->getEndTime(), "Invalid end time");
		 	$this->assertEquals($expected[$i][6], $res[$i]->getReportedDate(), "Invalid reported date");
		 	$this->assertEquals($expected[$i][7], $res[$i]->getDuration(), "Invalid duration");
		 	$this->assertEquals($expected[$i][8], $res[$i]->getDescription(), "Invalid description");
		 }
    }
}

// Call TimeEventTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "TimeEventTest::main") {
    TimeEventTest::main();
}
?>
