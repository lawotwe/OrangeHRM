<?php
// Call LeaveTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "LeaveTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

define('ROOT_PATH', "E:/moha/source/orangehrm/trunk/php/orangehrm");
define('WPATH', "http://127.0.0.1/orangehrm");
$_SESSION['WPATH'] = WPATH;

require_once "Leave.php";
require_once ROOT_PATH."/lib/confs/Conf.php";

/**
 * Test class for Leave.
 * Generated by PHPUnit_Util_Skeleton on 2006-10-12 at 08:36:24.
 */
class LeaveTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    
    public $classLeave = null;
    public $connection = null;
    
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("LeaveTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$this->classLeave = new Leave(); 
    	
    	$conf = new Conf();
    	
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
		
        mysql_select_db($conf->dbname);
        
		mysql_query("INSERT INTO `hs_hr_leave` VALUES (10, 'EMP011', 'LTY010', 1, '2006-10-12', '2006-10-17', 1, 1, 'Leave 1')");
		mysql_query("INSERT INTO `hs_hr_leave` VALUES (11, 'EMP011', 'LTY010', 1, '2006-10-12', '2006-10-25', 1, 1, 'Leave 2')");
    			
		mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY010', 1, 'Medical', 1)");	
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	   	
    	mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY010'", $this->connection);    	
    	mysql_query("TRUNCATE TABLE `hs_hr_leave`", $this->connection);    	
    }

    public function testApplyLeave()
    {
    	$this->classLeave->setEmployeeId("EMP012");
    	$this->classLeave->setLeaveTypeId("LTY010");
    	$this->classLeave->setLeaveTypeNameId("1");    	
    	$this->classLeave->setLeaveDate("2006-10-12");
    	$this->classLeave->setLeaveLength("2");
    	$this->classLeave->setLeaveStatus("1");
    	$this->classLeave->setLeaveComments("Leave 1");
    	
    	$res = $this->classLeave->applyLeave();		
    	
    	$res = $this->classLeave->retriveLeaveEmployee("EMP012");
        $expected[0] = array("2006-10-12", 'Medical', 1, 2, 'Leave 1');
        
        for ($i=0; $i < count($expected); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][1], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Checking added / applied leave ");
        }
        
        $this->classLeave->setLeaveComments("Leave 2");
        $res = $this->classLeave->applyLeave();      
        
        $res = $this->classLeave->retriveLeaveEmployee("EMP012");  
        $expected[1] = array("2006-10-12", 'Medical', 1, 2, 'Leave 2'); 
        
        for ($i=0; $i < count($expected); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][1], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Checking added / applied leave ");
        }	
    }
    
    public function testRetriveLeaveEmployee1() {
    	
        $res = $this->classLeave->retriveLeaveEmployee("EMP101");        
        
        $this->assertEquals($res, null, "Retured non exsistant record ");
    }      
    
    public function testRetriveLeaveEmployeeAccuracy() {

        $res = $this->classLeave->retriveLeaveEmployee("EMP011");
        
        $expected[0] = array('2006-10-17', 'Medical', 1, 1, 'Leave 1');
        $expected[1] = array('2006-10-25', 'Medical', 1, 1, 'Leave 2');
        
        $this->assertEquals($res, true, "No record found ");
        
        $this->assertEquals(count($res), 2, "Number of records found is not accurate ");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Didn't return expected result ");
        }
       
    }
    
    public function testCancelLeaveAccuracy() {
    	        
        $res = $this->classLeave->cancelLeave(10);
        $expected = true;
                
        $this->assertEquals($res, $expected, "Cancel of leave failed ");
        
        $res = $this->classLeave->cancelLeave(10);
        $expected = false;
                
        $this->assertEquals($res, $expected, "Cancelled already cancelled leave ");
                
        $res = $this->classLeave->retriveLeaveEmployee("EMP011");        
        $expected[0] = array('2006-10-25', 'Medical', 1, 1, 'Leave 2');                

        $this->assertEquals($res, true, "No record found ");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[0]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveTypeName(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveStatus(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveLength(), $expected[$i][3], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveComments(), $expected[$i][4], "Didn't return expected result ");
        }
    }    

}

// Call LeaveTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "LeaveTest::main") {
    LeaveTest::main();
}
?>
