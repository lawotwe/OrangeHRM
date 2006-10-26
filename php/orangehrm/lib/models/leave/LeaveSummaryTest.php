<?php
// Call LeaveSummaryTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "LeaveSummaryTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

define('ROOT_PATH', $rootPath);
define('WPATH', $webPath);
$_SESSION['WPATH'] = WPATH;

require_once "LeaveSummary.php";
require_once ROOT_PATH."/lib/confs/Conf.php";

/**
 * Test class for LeaveSummary.
 * Generated by PHPUnit_Util_Skeleton on 2006-10-19 at 13:16:38.
 */
class LeaveSummaryTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    
    private $leaveSummary = null;
    private $connection	= null;
    
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("LeaveSummaryTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	
    	$this->leaveSummary = new LeaveSummary();
    	
    	$conf = new Conf();
    	
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
		
        mysql_select_db($conf->dbname);
        
        mysql_query("TRUNCATE TABLE `hs_hr_leavetype`");
        
        mysql_query("INSERT INTO `hs_hr_employee` VALUES ('EMP011', 'Arnold', 'Subasinghe', '', 'Arnold', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', 'AF', '', '', '', '', '', '', NULL, '0000-00-00', '')");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('EMP012', 'Mohanjith', 'Sudirikku', 'Hannadige', 'MOHA', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");
		
		mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY010', 'Medical', 1)");	
		mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY011', 'Casual', 1)");
		
		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` VALUES ('LTY010', 'EMP012', 10);");
		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` VALUES ('LTY011', 'EMP012', 20);");
		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` VALUES ('LTY010', 'EMP011', 10);");
		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` VALUES ('LTY011', 'EMP011', 20);");
		
		mysql_query("INSERT INTO `hs_hr_leave` VALUES (10, 'EMP011', 'LTY010', 'Medical', '2006-10-12', '2006-10-17', 1, 3, 'Leave 1')");
		mysql_query("INSERT INTO `hs_hr_leave` VALUES (11, 'EMP011', 'LTY010', 'Medical', '2006-10-12', '2006-10-25', 1, 3, 'Leave 2')");
    	
    
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	
    	mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY010'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY011'", $this->connection);
    	
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = 'EMP011'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = 'EMP012'", $this->connection);
    	
    	mysql_query("DELETE FROM `hs_hr_employee_leave_quota` WHERE `Employee_ID` = 'EMP012'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee_leave_quota` WHERE `Employee_ID` = 'EMP011'", $this->connection);
    	
    	mysql_query("TRUNCATE TABLE `hs_hr_leave`", $this->connection);
    	
    	$this->connection = null;
    	
    }    

    /**
     * @todo Implement testFetchLeaveSummary().
     */
    
    public function testFetchLeaveSummaryAccuracy() {
    	
        $res = $this->leaveSummary->fetchLeaveSummary("EMP012");

        $this->assertEquals($res, true, "No records returned");               
        $this->assertEquals(count($res), 2, "Returned invalid numner of records");
        
        $expected[] = array("Medical", 0, 10);
        $expected[] = array("Casual", 0, 20);
        
        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTaken(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveAvailable(), $expected[$i][2], "Didn't return expected result ");
        }
        
    }
    
    public function testFetchLeaveSummaryAccuracy2() {
    	
        $res = $this->leaveSummary->fetchLeaveSummary("EMP011");

        $this->assertEquals($res, true, "No records returned");               
        $this->assertEquals(count($res), 2, "Returned invalid numner of records");
        
        $expected[1] = array("Medical", 2, 8);
        $expected[0] = array("Casual", 0, 20);
        
        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTaken(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveAvailable(), $expected[$i][2], "Didn't return expected result ");
        }
        
    }
}

// Call LeaveSummaryTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "LeaveSummaryTest::main") {
    LeaveSummaryTest::main();
}
?>
