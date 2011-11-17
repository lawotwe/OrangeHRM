<?php
// Call EmpInfoTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'EmpInfoTest::main');
}

;

require_once 'EmpInfo.php';

/**
 * Test class for EmpInfo.
 * Generated by PHPUnit on 2008-02-28 at 15:18:53.
 */
class EmpInfoTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('EmpInfoTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$dbConnection = new DMLFunctions();

		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`"), mysql_error());
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_emp_reportto`"));
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_pr_salary_grade`"));
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_job_spec`"));
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_job_title`"));
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_job_vacancy`"));
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_job_application`"));
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_job_application_events`"));

		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee`(emp_number, emp_lastname, emp_firstname, emp_nick_name, coun_code) " .
				"VALUES ('001', 'Perera', 'Nihal', '', 'AF')"));
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee`(emp_number, emp_lastname, emp_firstname, emp_nick_name, coun_code) " .
			"VALUES ('002', 'Udawatte', 'Kamal', '', 'AF')"));
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee`(emp_number, emp_lastname, emp_firstname, emp_nick_name, coun_code) " .
			"VALUES ('003', 'Kulasekara', 'Amal', '', 'AF')"));
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee`(emp_number, emp_lastname, emp_firstname, emp_nick_name, coun_code) " .
			"VALUES ('004', 'Anuradha', 'Saman', '', 'AF')"));
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee`(emp_number, emp_lastname, emp_firstname, emp_nick_name, coun_code) " .
			"VALUES ('005', 'Surendra', 'Tharindu', '', 'AF')"));
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee`(emp_number, emp_lastname, emp_firstname, emp_nick_name, coun_code) " .
			"VALUES ('006', 'Nayeem', 'Fazly', '', 'AF')"));
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee`(emp_number, emp_lastname, emp_firstname, emp_nick_name, coun_code) " .
			"VALUES ('007', 'Mahesan', 'Sanjeewan', '', 'AF')"));

		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_emp_reportto` VALUES ('2', '4', '1')"));
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_emp_reportto` VALUES ('3', '5', '1')"));
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_emp_reportto` VALUES ('3', '6', '1')"));
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_emp_reportto` VALUES ('3', '7', '1')"));

		$this->assertTrue(mysql_query("INSERT INTO `hs_pr_salary_grade` (`sal_grd_code`, `sal_grd_name`) VALUES ('SAL003', 'Top Management')"), mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_job_spec` (`jobspec_id`, `jobspec_name`, `jobspec_desc`, `jobspec_duties`) VALUES (3, 'Software Engineer', '', '')"), mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_job_title` (`jobtit_code`, `jobtit_name`, `jobtit_desc`, `jobtit_comm`, `sal_grd_code`, `jobspec_id`) VALUES ('JOB005', 'SE', 'SE', '', 'SAL003', 3)"), mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_job_vacancy` (`vacancy_id`, `jobtit_code`, `manager_id`, `active`, `description`) VALUES (1, 'JOB005', 1, 1, '')"), mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_job_application` (`application_id`, `vacancy_id`, `lastname`, `firstname`, `middlename`, `street1`, `street2`, `city`, `country_code`, `province`, `zip`, `phone`, `mobile`, `email`, `qualifications`, `status`, `applied_datetime`, `emp_number`) VALUES (1, 1, 'Bauer', 'Jack', '', 'No:87', '', 'Houston', 'US', 'California', '40000', '', '0888-789456', 'gayanath@example.com', 'Quite good', 0, '".date('Y-m-d H:i:s')."', NULL)"), mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_job_application_events` (`id`, `application_id`, `created_time`, `created_by`, `owner`, `event_time`, `event_type`, `status`, `notes`)".
			"VALUES (1, 1, '".date('Y-m-d H:i:s')."', 'USR001', 5, '".date('Y-m-d H:i:s', time()+3600*24*3)."', 1, 1, '')"), mysql_error());

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_emp_reportto`"));
    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`"));
    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_pr_salary_grade`"));
    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_job_spec`"));
    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_job_title`"));
    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_job_vacancy`"));
    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_job_application`"));
    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_job_application_events`"));
    }

    public function testCountEmployee()
    {
    	$empinfo = new EmpInfo();
        $this->assertEquals($empinfo->countEmployee(),7, 'Counting employees is wrong...');

		mysql_query("UPDATE `hs_hr_employee` SET `emp_status` = 'EST000' WHERE `emp_number`=1");

        $this->assertEquals($empinfo->countEmployee(),6, 'Counting employees is wrong...');
    }

    public function testGetFullName() {

    }

    public function testCountSubordinates() {

		$empInfo = new EmpInfo();
		$result[] = $empInfo->countSubordinates('001');
		$result[] = $empInfo->countSubordinates('002');
		$result[] = $empInfo->countSubordinates('003');

		$this->assertEquals(0, $result[0]);
		$this->assertEquals(1, $result[1]);
		$this->assertEquals(3, $result[2]);

    }

    public function testIsAcceptor() {

		$empInfo = new EmpInfo();
		$this->assertTrue($empInfo->isAcceptor(5));
		$this->assertTrue($empInfo->isAcceptor(005));
		$this->assertFalse($empInfo->isAcceptor(2));

    }

    public function testIsOfferer() {

    	$empInfo = new EmpInfo();
    	$this->assertTrue($empInfo->isOfferer(1));
    	$this->assertTrue($empInfo->isOfferer(001));
    	$this->assertFalse($empInfo->isOfferer(4));

    }

    public function testGetEmployeeSearchList(){
        $empInfo = new EmpInfo();
        $employeeSearchList = $empInfo->getEmployeeSearchList();

        $this->assertEquals(true, is_array($employeeSearchList));

        $this->assertEquals('Sanjeewan Mahesan', $employeeSearchList[0][0]);
        $this->assertEquals('7', $employeeSearchList[0][2]);

        $this->assertEquals('Fazly Nayeem', $employeeSearchList[1][0]);
        $this->assertEquals('6', $employeeSearchList[1][2]);

        $this->assertEquals('Tharindu Surendra', $employeeSearchList[2][0]);
        $this->assertEquals('5', $employeeSearchList[2][2]);

        $this->assertEquals('Saman Anuradha', $employeeSearchList[3][0]);
        $this->assertEquals('4', $employeeSearchList[3][2]);
    }
}

// Call EmpInfoTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'EmpInfoTest::main') {
    EmpInfoTest::main();
}
?>
