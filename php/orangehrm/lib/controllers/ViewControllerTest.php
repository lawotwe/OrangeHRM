<?php
// Call ViewControllerTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "ViewControllerTest::main");
}

define("ROOT_PATH", "E:/moha/source/orangehrm/trunk/php/orangehrm");
define("WPATH", "http://localhost/orangehrm");

session_start();

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "ViewController.php";

/**
 * Test class for ViewController.
 * Generated by PHPUnit_Util_Skeleton on 2006-09-13 at 08:21:16.
 */
class ViewControllerTest extends PHPUnit_Framework_TestCase {
	
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */	 
	
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";		
			
        $suite  = new PHPUnit_Framework_TestSuite("ViewControllerTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }
	
	function connectDB() {

		if(!@mysql_connect($_SESSION['dbInfo']['dbHostName'].':'.$_SESSION['dbInfo']['dbHostPort'], 		$_SESSION['dbInfo']['dbUserName'], $_SESSION['dbInfo']['dbPassword'])) {
			$_SESSION['error'] =  'Database Connection Error!';		
			return;
		}	
	}
	
	function fillData($phase=1, $source='/UnitTest/dbscript-') {
		$source .= $phase.'.sql';
		$this->connectDB();
	
		error_log (date("r")." Fill Data Phase $phase - Connected to the DB Server\n",3, "log.txt");
	
		if(!mysql_select_db($_SESSION['dbInfo']['dbName'])) {
			$_SESSION['error'] = 'Unable to create Database!';
			error_log (date("r")." Fill Data Phase $phase - Error - Unable to create Database\n",3, "log.txt");
			return;
		}
	
		error_log (date("r")." Fill Data Phase $phase - Selected the DB\n",3, "log.txt");
		error_log (date("r")." Fill Data Phase $phase - Reading DB Script\n",3, "log.txt");
	
		$queryFile = ROOT_PATH . $source;
		$fp    = fopen($queryFile, 'r');
	
		error_log (date("r")." Fill Data Phase $phase - Opened DB Script\n",3, "log.txt");
	
		$query = fread($fp, filesize($queryFile));
		fclose($fp);
		
		error_log (date("r")." Fill Data Phase $phase - Read DB script\n",3, "log.txt");
								
		$dbScriptStatements = explode(";", $query);
	
		error_log (date("r")." Fill Data Phase $phase - There are ".count($dbScriptStatements)." Statements in the DB script\n",3, "log.txt");
								
		for($c=0;(count($dbScriptStatements)-1)>$c;$c++)
			if(!@mysql_query($dbScriptStatements[$c])) {  
				$_SESSION['error'] = mysql_error();
				$error = mysql_error();
				error_log (date("r")." Fill Data Phase $phase - Error Statement # $c \n",3, "log.txt");
				error_log (date("r")." ".$dbScriptStatements[$c]."\n",3, "log.txt");
				
			}
			
		unset($query);						
		if(isset($error))
			return;
	}	
	

	
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
	 
    protected function setUp() {	
	 				
		$_SESSION['dbInfo']['dbHostName'] = "localhost";
		$_SESSION['dbInfo']['dbHostPort'] = "3306";
		$_SESSION['dbInfo']['dbUserName'] = "root";
		$_SESSION['dbInfo']['dbPassword'] = "moha";
		
		$_SESSION['dbInfo']['dbName'] = "hr_mysqltest";
		
		/*$this->fillData();	
		unset($error);	
		unset($_SESSION['error']);		*/
		
		$this->view = new ViewController();	
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
		
    }

    /*
	 ************************************************************************************
     * XajaxObjCall() Tests                                                             *
	 ************************************************************************************
     */
	 
	 /**
	  * GeoInfo - Province
	  */
    public function testXajaxObjCall_Province_1() {       
        $this->assertEquals(false, $this->view->xajaxObjCall("LK", "LOC", "province"));		
    }	
	public function testXajaxObjCall_Province_2() {        
        $this->assertEquals(true, $this->view->xajaxObjCall("US", "LOC", "province"));		
    }
	
	 /**
	  * GeoInfo - District
	  */
	public function testXajaxObjCall_District_1() {       
        $this->assertEquals(false, $this->view->xajaxObjCall("US", "LOC", "district"));		
    }	
	public function testXajaxObjCall_District_2() {        
        $this->assertEquals(false, $this->view->xajaxObjCall("TX", "LOC", "district"));		
    }
	
	/**
	  * GeoInfo - addLocation
	  */
	/*public function testXajaxObjCall_addLocation_1() {	
		$extractor = new EXTRACTOR_Location(); 
		
		$test = array('txtLocDescription'=>"Nawam Mawatha", 'txtAddress'=>"Sayuru Sevana", 'cmbDistrict'=>"Colombo", 'cmbCountry'=>"LK", 'cmbProvince'=>"Western", 'txtZIP'=>"00200", 'txtPhone'=>"011-2446111", 'txtFax'=>"011-2446112", 'txtComments'=>"PHPUnit");    
		
		$parsedObject = $extractor->parseAddData($test);
        $this->assertEquals(false, $this->view->xajaxObjCall("US", "LOC", "addLocation"));		
    }	
	public function testXajaxObjCall_addLocation_2() {        
        $this->assertEquals(false, $this->view->xajaxObjCall("TX", "LOC", "addLocation"));		
    }*/
	
	 /**
	  * Job - Job Title - Assigned
	  */	  
	public function testXajaxObjCall_Job_ass_1() {        
        $this->assertEquals(false, $this->view->xajaxObjCall("Web Developer", "JOB", "assigned"));		
    }
	public function testXajaxObjCall_Job_ass_2() {        
        $this->assertEquals(true, $this->view->xajaxObjCall("JOB001", "JOB", "assigned"));		
    }
	public function testXajaxObjCall_Job_ass_3() {
		$test = array(array("EST001", "Permanent"));        
        $this->assertEquals($test, $this->view->xajaxObjCall("JOB001", "JOB", "assigned"));		
    }
	
	 /**
	  * Job - Job Title - Unassigned
	  */
	public function testXajaxObjCall_Job_unAss_1() {        
        $this->assertEquals(true, $this->view->xajaxObjCall("Web Developer", "JOB", "unAssigned"));		
    }
	public function testXajaxObjCall_Job_unAss_2() {
		$test = array(array("EST001", "Permanent"), array("EST002", "Part Time"));        
        $this->assertEquals($test, $this->view->xajaxObjCall("Web Developer", "JOB", "unAssigned"));		
    }
	public function testXajaxObjCall_Job_unAss_3() {        
        $this->assertEquals(true, $this->view->xajaxObjCall("JOB001", "JOB", "unAssigned"));		
    }
	public function testXajaxObjCall_Job_unAss_4() {
		$test = array(array("EST002", "Part Time"));        
        $this->assertEquals($test, $this->view->xajaxObjCall("JOB001", "JOB", "unAssigned"));		
    }
	
	 /**
	  * Job - Job Title - editEmpStat
	  */
	public function testXajaxObjCall_Job_editEmpStat_1() {        
        $this->assertEquals(false, $this->view->xajaxObjCall("Web Developer", "JOB", "editEmpStat"));		
    }
	public function testXajaxObjCall_Job_editEmpStat_2() {        
        $this->assertEquals(true, $this->view->xajaxObjCall("EST002", "JOB", "editEmpStat"));		
    }
	public function testXajaxObjCall_Job_editEmpStat_3() {
		$test = array(array("EST002", "Part Time"));        
        $this->assertEquals($test, $this->view->xajaxObjCall("EST002", "JOB", "editEmpStat"));		
    }
	public function testXajaxObjCall_Job_editEmpStat_4() {
		$test = array(array("EST001", "Permanent"));      
        $this->assertEquals($test, $this->view->xajaxObjCall("EST001", "JOB", "editEmpStat"));		
    }
	
	 /*
	  * *********************************************************************************
	  */

    /**
     * @todo Implement testViewList().
     */
    public function testViewList() {       
        $this->assertEquals(true,true);
		//  No tests for HTML
    }

    /**
     * @todo Implement testDelParser().
     */
    /*public function testDelParser_emloyment_status() {
        $delArr = array(array('EST001')); 
        $this->view->delParser("EST", $delArr);
		
		$test = array(array("EST002", "Part Time")); 
		$this->assertEquals($test, $this->view->xajaxObjCall("EST002", "JOB", "editEmpStat"));
    }*/

    /**
     * @todo Implement testSelectIndexId().
     */
   /* public function testSelectIndexId() {
		$test = array(array("EST001", "Permanent"), array("EST002", "Part Time"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', 0));
    }*/

    /**
     * @todo Implement testGetHeadingInfo().
     */
    public function testGetHeadingInfo() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testGetInfo().
     */
    public function testGetInfo() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testGetPageName().
     */
    public function testGetPageName() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testCountList().
     */
    public function testCountList() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testAddData().
     */
    public function testAddData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testAddDesDisData().
     */
    public function testAddDesDisData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testUpdateDesDisData().
     */
    public function testUpdateDesDisData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testDelDesDisData().
     */
    public function testDelDesDisData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testUpdateData().
     */
    public function testUpdateData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testAssignData().
     */
    public function testAssignData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testDeleteData().
     */
    public function testDeleteData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testDelAssignData().
     */
    public function testDelAssignData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testReDirect().
     */
    public function testReDirect() {
        $this->assertEquals(true,true);
		//  No tests for HTML
    }
}

// Call ViewControllerTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "ViewControllerTest::main") {
    ViewControllerTest::main();
}
?>
