<?php
// Call WorkshiftTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "WorkshiftTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once ROOT_PATH."/lib/confs/Conf.php";
require_once ROOT_PATH."/lib/dao/DMLFunctions.php";
require_once ROOT_PATH."/lib/dao/SQLQBuilder.php";
require_once ROOT_PATH."/lib/common/UniqueIDGenerator.php";
require_once ROOT_PATH."/lib/models/time/Workshift.php";

/**
 * Test class for Workshift.
 * Generated by PHPUnit_Util_Skeleton on 2007-09-03 at 14:23:03.
 */
class WorkshiftTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("WorkshiftTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$conf = new Conf();
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
        mysql_select_db($conf->dbname);

		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee_workshift`", $this->connection));
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_workshift`", $this->connection));
        $this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`", $this->connection));

		// Insert a project and customer and employees for use in the test
        $this->assertTrue(mysql_query("INSERT INTO hs_hr_employee(emp_number, employee_id, emp_lastname, emp_firstname, emp_middle_name) " .
        			"VALUES(1, '0011', 'Rajasinghe', 'Saman', 'Marlon')"));
        $this->assertTrue(mysql_query("INSERT INTO hs_hr_employee(emp_number, employee_id, emp_lastname, emp_firstname, emp_middle_name) " .
        			"VALUES(2, '0022', 'Jayasinghe', 'Aruna', 'Shantha')"));
        $this->assertTrue(mysql_query("INSERT INTO hs_hr_employee(emp_number, employee_id, emp_lastname, emp_firstname, emp_middle_name) " .
        			"VALUES(3, '0034', 'Ranasinghe', 'Nimal', 'Bandara')"));
        $idGenerator = new UniqueIDGenerator();
        $idGenerator->resetIDs();

    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee_workshift`", $this->connection));
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_workshift`", $this->connection));
        $this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`", $this->connection));
        $idGenerator = new UniqueIDGenerator();
        $idGenerator->resetIDs();
    }

    /**
     * Test case for testSave().
     */
    public function testSave() {

		$workshift = new Workshift();

		try {
			$workshift->save();
			$this->fail("No exception thrown");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::VALUES_EMPTY_OR_NOT_SET, $e->getCode());
		}

		$workshift = new Workshift();
		$workshift->setName("Test shift");
		try {
			$workshift->save();
			$this->fail("No exception thrown");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::VALUES_EMPTY_OR_NOT_SET, $e->getCode());
		}

		$workshift = new Workshift();
		$workshift->setHoursPerDay(12);
		try {
			$workshift->save();
			$this->fail("No exception thrown");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::VALUES_EMPTY_OR_NOT_SET, $e->getCode());
		}

		$workshift = new Workshift();
		$workshift->setName("Test shift");
		$workshift->setHoursPerDay(-1);
		try {
			$workshift->save();
			$this->fail("No exception thrown");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::VALUES_EMPTY_OR_NOT_SET, $e->getCode());
		}

		$workshift = new Workshift();
		$workshift->setName("Test shift");
		$workshift->setHoursPerDay(12);
		$workshift->save();
		$id = $workshift->getWorkshiftId();
		$this->assertNotNull($id);
		$this->assertEquals(1, $id);
		$workshift = $this->_getWorkshift($id);
		$this->assertTrue($workshift !== false);
		$this->assertEquals("Test shift", $workshift['name']);
		$this->assertEquals(12, $workshift['hours_per_day']);
		$this->assertEquals(1, $workshift['workshift_id']);

		// Update

		$workshift = new Workshift();
		$workshift->setName("Normal Shift");
		$workshift->setHoursPerDay(8);
		$workshift->setWorkshiftId(3);

		// Set invalid id exception should be thrown
		$affected = $workshift->save();
		$this->assertEquals(0, $affected);

		// valid id, verify that values have changed
		$workshift->setWorkshiftId(1);
		$affected = $workshift->save();
		$this->assertEquals(1, $affected);

		$updatedRow = $this->_getWorkshift(1);
		$this->assertEquals("Normal Shift", $updatedRow['name']);
		$this->assertEquals(8, $updatedRow['hours_per_day']);

		$workshift = new Workshift();
		$workshift->setWorkshiftId(1);
		try {
			$workshift->save();
			$this->fail("Workshift without name and hours per day saved");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::VALUES_EMPTY_OR_NOT_SET, $e->getCode());
		}

		// Invalid hours per day
		$workshift = new Workshift();
		$workshift->setName("Invalid workshift");
		$workshift->setHoursPerDay("' {}' '");
		try {
			$workshift->save();
			$this->fail("Invalid hours per day allowed");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::VALUES_EMPTY_OR_NOT_SET, $e->getCode());
		}

		$workshift = new Workshift();
		$workshift->setWorkshiftId(1);
		$workshift->setName("Invalid workshift");
		$workshift->setHoursPerDay("' {}' '");
		try {
			$workshift->save();
			$this->fail("Invalid hours per day allowed");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::VALUES_EMPTY_OR_NOT_SET, $e->getCode());
		}

		// Test if sql injection works - update
		$workshift = new Workshift();
		$workshift->setWorkshiftId(1);
		$workshift->setName("sfdk'");
		$workshift->setHoursPerDay("22");
		$workshift->save();

		// check that the value is saved
		$updatedRow = $this->_getWorkshift(1);
		$this->assertEquals("sfdk'", $updatedRow['name']);
		$this->assertEquals(22, $updatedRow['hours_per_day']);

		// Test if sql injection works - save
		$workshift = new Workshift();
		$workshift->setName("eeee'");
		$workshift->setHoursPerDay("22");
		$workshift->save();

		$id = $workshift->getWorkshiftId();

		// check that the value is saved
		$updatedRow = $this->_getWorkshift($id);
		$this->assertEquals("eeee'", $updatedRow['name']);
		$this->assertEquals(22, $updatedRow['hours_per_day']);
    }

    /**
     * Test method for delete().
     */
    public function testDelete() {

    	// Test for id not available

    	$workshift = new Workshift();
    	$workshift->setWorkshiftId(15);
    	try {
    		$workshift->delete();
    		$this->fail("Non existing ID was not checked!");
    	} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ROW_COUNT, $e->getCode());
    	}

    	// Test for valid id

    	$workshift = new Workshift();
    	$workshift->setName("Delete Shift");
    	$workshift->setHoursPerDay(7);
    	$workshift->save();

    	// Check the saving
    	$id = $workshift->getWorkshiftId();
    	$updatedRow = $this->_getWorkshift($id);
		$this->assertNotNull($updatedRow);

		// check whether the ID exists
		$workshift->delete();
    	$id = $workshift->getWorkshiftId();
		$updatedRow = $this->_getWorkshift($id);
		$this->assertNull($updatedRow);

		// Empty id

		$workshift = new Workshift();
     	try {
    		$workshift->delete();
    		$this->fail("Empty ID was not checked!");
    	} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ID, $e->getCode());
    	}

    	// Invalid id

    	$workshift = new Workshift();
    	$workshift->setWorkshiftId("'fgW");
    	try {
    		$workshift->delete();
    		$this->fail("Invalid ID was not checked!");
    	} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ID, $e->getCode());
    	}
    }

    /**
     * @todo Implement testAssignEmployees().
     */
    public function testAssignEmployees() {

		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('1' , 'New Test Shift', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('2' , 'Workshift 2', '10')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('3' , 'Workshift 3', '11')"));

    	// Try to assign without valid workshift id, should throw an error
    	$employees = array(1, 2, 3);
		$workshift = new Workshift();
		try {
			$workshift->assignEmployees($employees);
			$this->fail("Trying to assign employees without setting workshift id should throw exception");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ID, $e->getCode());
		}

		// Assigning to non existing workshift, should not insert any rows
		$workshift->setWorkshiftId(4);
		$count = $workshift->assignEmployees($employees);
		$this->assertEquals(0, $count);
		$this->assertEquals(0, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));

    	// Assign empty list of employees should be allowed
		$workshift->setWorkshiftId(1);
		$count = $workshift->assignEmployees(array());
		$this->assertEquals(0, $count);
		$this->assertEquals(0, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));

    	// Assign valid employee list
		$employees = array(1, 3);
		$count = $workshift->assignEmployees($employees);
		$this->assertEquals(2, $count);
		$this->assertEquals(2, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 1)"));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 3)"));

		// reassigning already assigned employees shouldn't assign them again
		$employees = array(1, 2, 3);
		$count = $workshift->assignEmployees($employees);
		$this->assertEquals(1, $count);
		$this->assertEquals(3, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 1)"));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 2)"));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 3)"));

		// Passing same employee several times should not add duplicate entries
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee_workshift`"));

		$employees = array(1, 3, 1, 1, 3);
		$count = $workshift->assignEmployees($employees);
		$this->assertEquals(2, $count);
		$this->assertEquals(2, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 1)"));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 3)"));

		// Invalid employee ID's should not be assigned.
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee_workshift`"));
		$employees = array(1, -1, "')", 3);
		$count = $workshift->assignEmployees($employees);
		$this->assertEquals(2, $count);
		$this->assertEquals(2, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 1)"));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 3)"));

		// Non existing employee should not be added
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee_workshift`"));
		$employees = array(1, 2, 4, 3, 5);
		$count = $workshift->assignEmployees($employees);
		$this->assertEquals(3, $count);
		$this->assertEquals(3, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 1)"));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 2)"));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "(workshift_id = 1 AND emp_number = 3)"));

    }

	/**
	 * Test method for getWorkshiftForEmployee
	 */
	public function testGetWorkshiftForEmployee() {

		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('1' , 'New Test Shift', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('2' , 'Workshift 2', '10')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('3' , 'Workshift 3', '11')"));

		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (1, 1)"));
		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (2, 2)"));

		// Invalid employee id
		try {
			Workshift::getWorkshiftForEmployee('sdf');
			$this->fail("Invalid employee number should throw exception");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ID, $e->getCode());
		}

		// Get workshift for non-existant employee
		$this->assertNull(Workshift::getWorkshiftForEmployee(4));

		// Get workshift for employee without assigned workshift
		$this->assertNull(Workshift::getWorkshiftForEmployee(3));

		// Get workshift for employee with workshift assigned
		$shift = Workshift::getWorkshiftForEmployee(1);
		$this->assertNotNull($shift);
		$this->assertEquals("New Test Shift", $shift->getName());
		$this->assertEquals(5, $shift->getHoursPerDay());
		$this->assertEquals(1, $shift->getWorkshiftId());

	}

	/**
	 * Test method for removeAssignedEmployees
	 */
	public function testRemoveAssignedEmployees() {

		// Callling remove assigned employees without setting valid workshift id
		$workshift = new Workshift();
		try {
			$workshift->removeAssignedEmployees();
			$this->fail("Trying to remove assigned employees without setting workshift id should throw exception");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ID, $e->getCode());
		}

		// remove assigned employees with non-existent workshift_id, shouldn't throw error
		$workshift = new Workshift();
		$workshift->setWorkshiftId(4);
		$count = $workshift->removeAssignedEmployees();
		$this->assertEquals(0, $count);

		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('1' , 'New Test Shift', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('2' , 'Workshift 2', '10')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('3' , 'Workshift 3', '11')"));
		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (1, 1)"));
		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (2, 2)"));
		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (2, 3)"));

		$count = $workshift->removeAssignedEmployees();
		$this->assertEquals(0, $count);

		// check no assignments are deleted
		$this->assertEquals(3, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));

		// Remove assigned employees when no employees are assigned - check no assignments are deleted
		$workshift->setWorkshiftId(3);
		$count = $workshift->removeAssignedEmployees();
		$this->assertEquals(0, $count);
		$this->assertEquals(3, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));

		// Remove assigned employees
		$workshift->setWorkshiftId(2);
		$count = $workshift->removeAssignedEmployees();
		$this->assertEquals(2, $count);
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));
		$this->assertEquals(1, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE, "workshift_id = 1"));

		$workshift->setWorkshiftId(1);
		$count = $workshift->removeAssignedEmployees();
		$this->assertEquals(1, $count);
		$this->assertEquals(0, $this->_countRows(Workshift::EMPLOYEE_WORKSHIFT_TABLE));
	}

	/**
	 * Test method for getEmployeesWithoutWorkshift
	 */
	public function testGetEmployeesWithoutWorkshift() {

		$employees = Workshift::getEmployeesWithoutWorkshift();
		$expected[1] = array(1, '0011', 'Rajasinghe', 'Saman', 'Marlon');
		$expected[2] = array(2, '0022', 'Jayasinghe', 'Aruna', 'Shantha');
		$expected[3] = array(3, '0034', 'Ranasinghe', 'Nimal', 'Bandara');

		$this->assertEquals(3, count($employees));
		$this->_checkEmployeeList($employees, $expected);

		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('1' , 'New Test Shift', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('2' , 'Workshift 2', '10')"));

		$employees = Workshift::getEmployeesWithoutWorkshift();
		$this->assertEquals(3, count($employees));
		$this->_checkEmployeeList($employees, $expected);

		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (1, 1)"));
		$employees = Workshift::getEmployeesWithoutWorkshift();
		$this->assertEquals(2, count($employees));

		unset($expected[1]);
		$this->_checkEmployeeList($employees, $expected);

		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (2, 2)"));
		$employees = Workshift::getEmployeesWithoutWorkshift();
		$this->assertEquals(1, count($employees));

		unset($expected[2]);
		$this->_checkEmployeeList($employees, $expected);

		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (2, 3)"));
		$employees = Workshift::getEmployeesWithoutWorkshift();
		$this->assertEquals(0, count($employees));
	}

	/**
	 * Test method for getAssignedEmployees
	 */
	public function testGetAssignedEmployees() {

		$workshift = new Workshift();

		try {
			$workshift->getAssignedEmployees();
			$this->fail("Trying to fetch assigned employees without setting workshift id should throw exception");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ID, $e->getCode());
		}

		// Workshift not in system
		$workshift->setWorkshiftId(1);
		$employees = $workshift->getAssignedEmployees();
		$this->assertEquals(0, count($employees));

		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('1' , 'New Test Shift', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('2' , 'Workshift 2', '10')"));

		// Workshift with no assigned employees
		$workshift->setWorkshiftId(2);
		$employees = $workshift->getAssignedEmployees();
		$this->assertEquals(0, count($employees));

		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (1, 1)"));
		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (2, 2)"));
		$this->assertTrue(mysql_query("INSERT INTO hs_hr_employee_workshift(workshift_id, emp_number) VALUES (2, 3)"));


		$expected[2] = array(2, '0022', 'Jayasinghe', 'Aruna', 'Shantha');
		$expected[3] = array(3, '0034', 'Ranasinghe', 'Nimal', 'Bandara');

		$employees = $workshift->getAssignedEmployees();
		$this->assertEquals(2, count($employees));
		$this->_checkEmployeeList($employees, $expected);


		$workshift->setWorkshiftId(1);
		$employees = $workshift->getAssignedEmployees();

		unset($expected);
		$expected[1] = array(1, '0011', 'Rajasinghe', 'Saman', 'Marlon');
		$this->assertEquals(1, count($employees));
		$this->_checkEmployeeList($employees, $expected);
	}

    /**
     * Test case for testGetWorkshifts().
     */
    public function testGetWorkshifts() {

		// No workshifts, should return empty array
		$workshifts = Workshift::getWorkshifts();
		$this->assertTrue(is_array($workshifts));
		$this->assertEquals(0, count($workshifts));

		// Only one workshift, should return array with one workshift
		$sql = "INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('1' , 'New Test Shift', '5')";
		$this->assertTrue(mysql_query($sql));

		$workshifts = Workshift::getWorkshifts();
		$this->assertTrue(is_array($workshifts));
		$this->assertEquals(1, count($workshifts));
		$this->assertEquals('New Test Shift', $workshifts[0]->getName());
		$this->assertEquals(1, $workshifts[0]->getWorkshiftId());
		$this->assertEquals(5, $workshifts[0]->getHoursPerDay());

		// Many workshifts, should return array with all available workshifts
		$sql = "INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('2' , 'Workshift 2', '8')";
		$this->assertTrue(mysql_query($sql));
		$sql = "INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('3' , 'Workshift 3', '6')";
		$this->assertTrue(mysql_query($sql));

		$workshifts = Workshift::getWorkshifts();
		$this->assertTrue(is_array($workshifts));
		$this->assertEquals(3, count($workshifts));

		$ids = array(1, 2, 3);
		$names = array("New Test Shift", "Workshift 2", "Workshift 3");
		$hours = array(5, 8, 6);

		foreach ($workshifts as $workshift) {

			$id = $workshift->getWorkshiftId();
			$index = array_search($id, $ids);
			$this->assertTrue($index !== false);

			$this->assertEquals($names[$index], $workshift->getName());
			$this->assertEquals($hours[$index], $workshift->getHoursPerDay());

			unset($ids[$index]);
			unset($names[$index]);
			unset($hours[$index]);
		}
    }

    /**
     * Testcase for testGetWorkshift().
     */
    public function testGetWorkshift() {

		// invalid id
		try {
			$workshift = Workshift::getWorkshift(null);
			$this->fail("Exception not thrown");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ID, $e->getCode());
		}

		// negative id
		try {
			$workshift = Workshift::getWorkshift(-1);
			$this->fail("Negative id!");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ID, $e->getCode());
		}

		// try sql injection in id

		// id not found in database
		try {
			$workshift = Workshift::getWorkshift("'{}");
			$this->fail("Invalid ID!");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ID, $e->getCode());
		}

		try {
			$workshift = Workshift::getWorkshift(16);
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::WORKSHIFT_NOT_FOUND, $e->getCode());
		}

		// valid id

		$sql = "INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('3' , 'New Test Shift', '5')";
		$result = mysql_query($sql);
		$this->assertTrue($result);

		// Check whether the returned object is Workshift
		$workshift = Workshift::getWorkshift(3);
		$this->assertTrue($workshift instanceof Workshift);

		$this->assertEquals(3, $workshift->getWorkshiftId());
		$this->assertEquals("New Test Shift", $workshift->getName());
		$this->assertEquals(5, $workshift->getHoursPerDay());

    }

    /**
     * Test method for deleteWorkshifts().
     */
    public function testDeleteWorkshifts() {

		// Parameter is not an array
		try {
			Workshift::deleteWorkshifts(null);
			$this->fail("null parameter allowed");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_PARAMETER, $e->getCode());
		}

		try {
			Workshift::deleteWorkshifts(2);
			$this->fail("integer parameter allowed");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_PARAMETER, $e->getCode());
		}

		// Empty array
		$idArray = array();
		try {
			Workshift::deleteWorkshifts($idArray);
			$this->fail("Empty array allowed");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_PARAMETER, $e->getCode());
		}

		// array contains invalid ids
		$idArray = array(1, 2, -1, 4);
		try {
			Workshift::deleteWorkshifts($idArray);
			$this->fail("Invalid id's allowed");
		} catch (WorkshiftException $e) {
			$this->assertEquals(WorkshiftException::INVALID_ID, $e->getCode());
		}

		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('1' , 'Work shift 1', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('2' , 'Work shift 2', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('3' , 'Work shift 3', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('4' , 'Work shift 4', '5')"));

		// array contains id's not in database
		$idArray = array(1, 2, 23);
		Workshift::deleteWorkshifts($idArray);

		$this->assertEquals(2, $this->_countRows(Workshift::WORKSHIFT_TABLE));
		$this->assertEquals(2, $this->_countRows(Workshift::WORKSHIFT_TABLE, "workshift_id IN (3, 4)"));

		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_workshift`", $this->connection));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('1' , 'Work shift 1', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('2' , 'Work shift 2', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('3' , 'Work shift 3', '5')"));
		$this->assertTrue(mysql_query("INSERT INTO " . Workshift::WORKSHIFT_TABLE . " VALUES ('4' , 'Work shift 4', '5')"));

		// array contains valid ids
		$idArray = array(1, 2, 3);
		Workshift::deleteWorkshifts($idArray);

		$this->assertEquals(1, $this->_countRows(Workshift::WORKSHIFT_TABLE));
		$row = $this->_getWorkshift(4);

		$this->assertNotNull($row);
		$this->assertEquals("Work shift 4", $row['name']);
		$this->assertEquals(5, $row['hours_per_day']);

    }

    private function _getWorkshift($id) {
    	$sql = "SELECT workshift_id, name, hours_per_day FROM hs_hr_workshift WHERE workshift_id = $id ";
    	$result = mysql_query($sql);
    	$this->assertTrue($result !== false, mysql_error());

		$num = mysql_num_rows($result);
		if ($num == 0) {
			return null;
		} else if ($num == 1) {
			return mysql_fetch_array($result);
		} else {
			$this->fail("Two workshifts with same id");
		}
    }

    private function _countRows($table, $condition = null) {

    	$sql = "SELECT COUNT(*) FROM $table";
    	if (!empty($condition)) {
    		$sql .= " WHERE $condition";
    	}

    	$result = mysql_query($sql);

    	$this->assertTrue($result !== false);
    	$this->assertEquals(1, mysql_num_rows($result));
    	$row = mysql_fetch_array($result);
    	$count = $row[0];
    	return $count;
    }

	/**
	 * Checks that the expected employees and only the expected employees
	 * are in the given array of employees. Asserts if not
	 */
    private function _checkEmployeeList($employees, $expected) {

		foreach($employees as $employee) {
			$empNumber = $employee['emp_number'];

			$this->assertTrue(array_key_exists($empNumber, $expected));
			$expectedVal = $expected[$empNumber];

			$this->assertEquals($expectedVal[1], $employee['employee_id']);
			$this->assertEquals($expectedVal[2], $employee['emp_lastname']);
			$this->assertEquals($expectedVal[3], $employee['emp_firstname']);
			$this->assertEquals($expectedVal[4], $employee['emp_middle_name']);

			unset($expected[$empNumber]);
		}
    }
}

// Call WorkshiftTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "WorkshiftTest::main") {
    WorkshiftTest::main();
}
?>
