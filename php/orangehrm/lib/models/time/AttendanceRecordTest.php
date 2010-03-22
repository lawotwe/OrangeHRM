<?php

if (! defined ( 'PHPUnit_MAIN_METHOD' )) {
	define ( 'PHPUnit_MAIN_METHOD', 'AttendanceRecordTest::main' );
}

if (! defined ( 'ROOT_PATH' )) {
	define ( 'ROOT_PATH', dirname ( __FILE__ ) . '/../../..' );
}
define ( 'ENVIRNOMENT', 'test' );


require_once 'PHPUnit/Framework.php';

require_once ROOT_PATH . '/lib/models/time/AttendanceRecord.php';
require_once ROOT_PATH . '/lib/dao/DMLFunctions.php';
require_once ROOT_PATH . '/lib/dao/SQLQBuilder.php';
require_once ROOT_PATH . '/lib/common/UniqueIDGenerator.php';
require_once ROOT_PATH . '/lib/models/time/AttendanceReportRow.php';
require_once ROOT_PATH . '/lib/models/hrfunct/EmpInfo.php';

/**
 * Test class for AttendanceRecord.
 * Generated by PHPUnit on 2010-02-22 at 11:21:53.
 */
class AttendanceRecordTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var AttendanceRecord
	 */
	protected $object;
	
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->object = new AttendanceRecord ( );
		$sql [] = "INSERT INTO `hs_hr_employee` (`emp_number`, `employee_id`, `emp_lastname`, `emp_firstname`, `emp_middle_name`, `emp_nick_name`, `emp_smoker`, `ethnic_race_code`, `emp_birthday`, `nation_code`, `emp_gender`, `emp_marital_status`, `emp_ssn_num`, `emp_sin_num`, `emp_other_id`, `emp_dri_lice_num`, `emp_dri_lice_exp_date`, `emp_military_service`, `emp_status`, `job_title_code`, `eeo_cat_code`, `work_station`, `emp_street1`, `emp_street2`, `city_code`, `coun_code`, `provin_code`, `emp_zipcode`, `emp_hm_telephone`, `emp_mobile`, `emp_work_telephone`, `emp_work_email`, `sal_grd_code`, `joined_date`, `emp_oth_email`, `terminated_date`, `termination_reason`, `custom1`, `custom2`, `custom3`, `custom4`, `custom5`, `custom6`, `custom7`, `custom8`, `custom9`, `custom10`) VALUES
				(1, '001', 'Abbey', 'Kayla', '', '', 0, NULL, NULL, NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
				(2, '002', 'Abel', 'Ashley', '', '', 0, NULL, NULL, NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
				(3, '003', 'Abraham', 'Tyler', '', '', 0, NULL, NULL, NULL, NULL, NULL, '', '', '', '', NULL, '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
						";
		$sql [] = "
			INSERT INTO `hs_hr_attendance` (`attendance_id`, `employee_id`, `punchin_time`, `punchout_time`, `in_note`, `out_note`, `timestamp_diff`, `status`) VALUES
			(2, 1, '2010-02-11 14:39:00', '2010-02-11 15:40:00', 'note 1', '', 0, '1'),
			(3, 2, '2010-02-11 15:16:00', '2010-02-11 18:16:00', '', 'note2', 0, '1'),
			(4, 2, '2010-02-11 20:12:00', '2010-02-11 21:42:00', '', '', 0, '1'),
			(5, 2, '2010-02-15 10:00:00', '2010-02-18 10:30:00', '', '', 0, '1'),
			(6, 1, '2010-02-16 14:39:00', '2010-02-16 15:39:00', 'note3', '', 0, '1'),
			(7, 3, '2010-02-13 11:51:00', '2010-02-15 13:52:00', 'note4', '', 0, '1'),
			(8, 3, '2010-02-12 08:00:00', '2010-02-12 09:15:00', 'note5', 'note6', 0, '1'),
			(9, 3, '2010-02-12 10:00:00', '2010-02-12 11:00:00', 'note5', 'note6', 0, '1')
			;";
		
		$connection = new DMLFunctions();
		foreach ($sql as $sqlStatement) {
		  $connection->executeQuery($sqlStatement);
		}
	}
	
	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {
		
		$sql [] = "DELETE FROM `hs_hr_attendance` WHERE `hs_hr_attendance`.`attendance_id` = 2 ;";
		$sql [] = "DELETE FROM `hs_hr_attendance` WHERE `hs_hr_attendance`.`attendance_id` = 3 ;";
		$sql [] = "DELETE FROM `hs_hr_attendance` WHERE `hs_hr_attendance`.`attendance_id` = 4 ;";
		$sql [] = "DELETE FROM `hs_hr_attendance` WHERE `hs_hr_attendance`.`attendance_id` = 5 ;";
		$sql [] = "DELETE FROM `hs_hr_attendance` WHERE `hs_hr_attendance`.`attendance_id` = 6 ;";
		$sql [] = "DELETE FROM `hs_hr_attendance` WHERE `hs_hr_attendance`.`attendance_id` = 7 ;";
		$sql [] = "DELETE FROM `hs_hr_attendance` WHERE `hs_hr_attendance`.`attendance_id` = 8 ;";
		$sql [] = "DELETE FROM `hs_hr_attendance` WHERE `hs_hr_attendance`.`attendance_id` = 9 ;";
	  
	   $sql [] = "DELETE FROM `hs_hr_employee` WHERE `hs_hr_employee`.`emp_number` = 1 ;";
	   $sql [] = "DELETE FROM `hs_hr_employee` WHERE `hs_hr_employee`.`emp_number` = 2 ;";
	   $sql [] = "DELETE FROM `hs_hr_employee` WHERE `hs_hr_employee`.`emp_number` = 3 ;";
	  
	    $connection = new DMLFunctions();
        foreach ($sql as $sqlStatement) {
         	$connection->executeQuery(trim($sqlStatement));
        }
	}

	
	/**
	 * @todo Implement testAddRecord().
	 */
	public function testAddRecord() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete ( 'This test has not been implemented yet.' );
	}
	
	/**
	 * @todo Implement testUpdateRecord().
	 */
	public function testUpdateRecord() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete ( 'This test has not been implemented yet.' );
	}
	
	/**
	 * @todo Implement testFetchRecords().
	 */
	public function testFetchRecords() {
		
		$object = new AttendanceRecord();				
		$this->assertEquals(sizeof($object->fetchRecords(-1,'2009-02-11','2011-02-16')),8);		
		$this->assertEquals(sizeof($object->fetchRecords(1,'2009-02-11','2010-02-16 23:59:59')),2);
		$this->assertEquals(sizeof($object->fetchRecords(1,'2009-02-11','2010-02-16')),1);		
		
		$this->assertEquals(sizeof($object->fetchRecords(3,'2010-02-11 00:00:00','2010-02-12 23:59:59')),2);
		$attendance = $object->fetchRecords(3,'2010-02-11 00:00:00','2010-02-12 23:59:59');
		
		$this->assertEquals($attendance [0]->getEmployeeId(),3);
		$this->assertEquals($attendance [0]->getInDate(),'2010-02-12');
		$this->assertEquals($attendance [0]->getInTime(),'08:00');
		$this->assertEquals($attendance [0]->getOutDate(),'2010-02-12');
		$this->assertEquals($attendance [0]->getOutTime(),'09:15');
	}
	
	/**
	 * @todo Implement testFetchSummary().
	 */
	public function testFetchSummary() {
		$object = new AttendanceRecord();
		
		$this->assertEquals(sizeof($object->fetchSummary(-1,'2009-02-11','2011-02-16')),11);
		
		$this->assertEquals(sizeof($object->fetchSummary(1,'2009-02-11','2011-02-16')),2);
		$this->assertEquals(sizeof($object->fetchSummary(2,'2009-02-11','2011-02-16')),5);
		$this->assertEquals(sizeof($object->fetchSummary(3,'2010-02-11 00:00:00','2010-02-12 23:59:59')),1);
		
		$attendance = $object->fetchSummary(3,'2010-02-11 00:00:00','2010-02-12 23:59:59');
		
		$this->assertEquals($attendance [0]->employeeName,'Tyler Abraham');
        $this->assertEquals($attendance [0]->duration, 2.15);
        $this->assertEquals($attendance [0]->inTime,'2010-02-12');
        $this->assertEquals($attendance [0]->outTime,'2010-02-12');
      
		
	}
	
	/**
	 * @todo Implement testCountRecords().
	 */
	public function testCountRecords() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete ( 'This test has not been implemented yet.' );
	}
	
	/**
	 * @todo Implement testIsOverlapping().
	 */
	public function testIsOverlapping() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete ( 'This test has not been implemented yet.' );
	}
	
	/**
	 * @todo Implement testIsOverlappingInTime().
	 */
	public function testIsOverlappingInTime() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete ( 'This test has not been implemented yet.' );
	}
}
?>
