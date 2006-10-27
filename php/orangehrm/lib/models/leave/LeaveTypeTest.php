<?php
// Call LeaveTypeTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "LeaveTypeTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

define('ROOT_PATH', $rootPath);
define('WPATH', $webPath);
$_SESSION['WPATH'] = WPATH;

require_once "LeaveType.php";
require_once ROOT_PATH."/lib/confs/Conf.php";

/**
 * Test class for LeaveType.
 * Generated by PHPUnit_Util_Skeleton on 2006-10-18 at 10:36:24.
 */
class LeaveTypeTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    
    public $classLeaveType = null;
    public $connection = null;
    
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("LeaveTypeTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$this->classLeaveType = new LeaveType(); 
    	
    	$conf = new Conf();
    	
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
		
        mysql_select_db($conf->dbname);
        
        mysql_query("TRUNCATE TABLE `hs_hr_leavetype`");
        mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY011', 'Medical', 1)");
        mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY012', 'Medicals', 1)");
        mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY013', 'Medicalx', 1)");
			
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	   	
    	 mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY011'", $this->connection); 
    	 mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY012'", $this->connection);
    	 mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY013'", $this->connection);
    	 mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY014'", $this->connection);
    }
	
   public function testAddLeaveType() {
    	
    	$this->classLeaveType->setLeaveTypeName("Anual");
    	
    	$res = $this->classLeaveType->addLeaveType();
    	
    	$res = $this->classLeaveType->retriveLeaveType("LTY014");
        
        $expected = array('LTY014', 'Anual');
        
        $this->assertEquals($res[0]->getLeaveTypeId(), $expected[0], "Didn't return expected result 1");
        $this->assertEquals($res[0]->getLeaveTypeName(), $expected[1], "Didn't return expected result 2");

       
        
        $this->assertEquals(count($res), 1, "Number of records found is not accurate ");

   }
	
   public function testRetriveLeaveType() {
    	
        $res = $this->classLeaveType->retriveLeaveType("LTY016"); 
        
        $this->assertEquals($res, null, "Retured non exsistant record ");
   } 
    
   
   
   public function testRetriveLeaveAccuracy() {

        $res = $this->classLeaveType->retriveLeaveType("LTY011");
        
        $expected[0] = array('Anual', 'LTY011');
      
        
        $this->assertEquals($res, true, "No record found ");
        
        
                    
   }
   
   
   public function testEditLeavetype () {
   		
   		$this->classLeaveType->setLeaveTypeName("New Medicals");
   		
   		$res = $this->classLeaveType->editLeaveType("LTY012");
   		
   		$res = $this->classLeaveType->retriveLeaveType("LTY012");
        
   		$expected = array('LTY012', 'New Medicals');
        
        $this->assertEquals($res[0]->getLeaveTypeId(), $expected[0], "Didn't return expected result 1");
        $this->assertEquals($res[0]->getLeaveTypeName(), $expected[1], "Didn't return expected result 2");

        
        $this->assertEquals($res, true, "No record found ");
   		
   }
     
   
   public function testDeleteLeaveType () {
     	
   		$this ->classLeaveType->setLeaveTypeId("LTY012");
   		
   		$res = $this->classLeaveType->deleteLeaveType("LTY012");
   		
   		$res = $this->classLeaveType->retriveLeaveType("LTY012");
        
	
        $expected = array('LTY012', 'Medicals' , $res[0]->unAvalableStatuFlag);
        
        $this->assertEquals($res[0]->getLeaveTypeId(), $expected[0], "Didn't return expected result 1");
        $this->assertEquals($res[0]->getLeaveTypeName(), $expected[1], "Didn't return expected result 2");

        
        $this->assertEquals($res, true, "No record found ");
   }
   
   public function testFetchLeave() {
        $res = $this->classLeaveType->fetchLeaveTypes();
        
        $this->assertEquals($res, true, "No record found ");            
    }
    
    
    public function testFetchLeaveAccuracy() {
    	
        $res = $this->classLeaveType->fetchLeaveTypes();
               

        //$this->assertEquals(count($res), 3, "Number of records found is not accurate ");
                
        $expected[0] = array("LTY011", "Medical");
        $expected[1] = array("LTY012", "Medicals");
        $expected[2] = array("LTY013", "Medicalx");                  
        
        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getLeaveTypeId(), $expected[$i][0], "Didn't return expected result 1");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][1], "Didn't return expected result 2");

        }    
    }
   
}

// Call LeaveTypeTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "LeaveTypeTest::main") {
    LeaveTypeTest::main();
}
?>
