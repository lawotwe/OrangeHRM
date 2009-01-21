<?php
// Call HspSummaryTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'HspSummaryTest::main');
}

require_once 'PHPUnit/Framework.php';

require_once "testConf.php";
require_once ROOT_PATH."/lib/confs/Conf.php";
require_once ROOT_PATH."/lib/common/UniqueIDGenerator.php";

require_once 'HspSummary.php';

/**
 * Test class for HspSummary.
 * Generated by PHPUnit on 2008-02-15 at 15:36:45.
 */
class HspSummaryTest extends PHPUnit_Framework_TestCase {
	private $oldValues = array();
	private $oldHspValue = null;
	private $employeeFields = null;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('HspSummaryTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
		$this->employeeFields = "`emp_number`, `employee_id`, `emp_lastname`, `emp_firstname`, `emp_middle_name`, `emp_nick_name`, " .
								"`emp_smoker`, `ethnic_race_code`, `emp_birthday`, `nation_code`, `emp_gender`, `emp_marital_status`, " .
								"`emp_ssn_num`, `emp_sin_num`, `emp_other_id`, `emp_dri_lice_num`, `emp_dri_lice_exp_date`, `emp_military_service`, " .
								"`emp_status`, `job_title_code`, `eeo_cat_code`, `work_station`, `emp_street1`, `emp_street2`, " .
								"`city_code`, `coun_code`, `provin_code`, `emp_zipcode`, `emp_hm_telephone`, `emp_mobile`, " .
								"`emp_work_telephone`, `emp_work_email`, `sal_grd_code`, `joined_date`, `emp_oth_email`";

    	$conf = new Conf();
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
        mysql_select_db($conf->dbname);

		$tableList = array('hs_hr_hsp_summary','hs_hr_employee');
		$this->_backupTables($tableList);

		$result = mysql_query("SELECT `value` FROM `hs_hr_config` WHERE `key` = 'hsp_current_plan';");
		$row = mysql_fetch_array($result, MYSQL_NUM);
		$this->oldHspValue = $row[0];

		$result = mysql_query("SELECT `last_id`, `table_name`, `field_name` FROM `hs_hr_unique_id`;");
		while($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$this->oldValues['AUTO_INC_PK_TABLE']['hs_hr_unique_id'][] = $row;
		}

    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());
    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`"),mysql_error());
    	$this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = '1' WHERE `key` = 'hsp_current_plan';"),mysql_error());
    	$this->assertTrue(mysql_query("UPDATE `hs_hr_unique_id` SET `last_id` = '0' WHERE `table_name` = 'hs_hr_hsp_summary' AND `field_name` = 'summary_id'"),mysql_error());

    	// Used in testSaveInitialSummaryForOneEmployee()
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (1, 1, 1, ".date('Y').", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (2, 1, 3, ".date('Y').", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (3, 1, 1, ".(date('Y')+1).", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (4, 1, 3, ".(date('Y')+1).", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("UPDATE `hs_hr_unique_id` SET `last_id` = '4' WHERE `table_name` = 'hs_hr_hsp_summary' AND `field_name` = 'summary_id'"),mysql_error());

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`"),mysql_error());
		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_unique_id`"),mysql_error());

		foreach($this->oldValues['AUTO_INC_PK_TABLE']['hs_hr_unique_id'] as $row) {
			$this->assertTrue(mysql_query("INSERT INTO `hs_hr_unique_id` VALUES (NULL, '" . implode("', '", $row) . "')"), mysql_error());
		}

		$this->_restoreTables();

		UniqueIDGenerator::getInstance()->resetIDs();
		$this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = '$this->oldHspValue' WHERE `key` = 'hsp_current_plan';"),mysql_error());


    }

    public function testFetchSummary() {

    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());

    	// Add 3 records to `hs_hr_hsp_summary`
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (1, 1, 1, ".date('Y').", 0, 1200.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (2, 2, 1, ".date('Y').", 0, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (3, 3, 1, ".date('Y').", 0, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());

        //Add 3 employees to `hs_hr_employee`
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` ($this->employeeFields) VALUES (1, '001', 'Bauer', 'Jack', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` ($this->employeeFields) VALUES (2, '002', 'Bond', 'James', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` ($this->employeeFields) VALUES (3, '003', 'Owen', 'David', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)"),mysql_error());

		$hspSummary = new HspSummary();

		$summary = $hspSummary->fetchHspSummary(date('Y'), 1);

		$this->assertTrue(is_array($summary));
		$this->assertTrue(is_object($summary[0]));
		$this->assertEquals(count($summary), 3);
		$this->assertEquals($summary[0]->getAnnualLimit(), 1200);

    }

    public function testFetchPersonalSummary() {

    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());

    	// Add 3 records to `hs_hr_hsp_summary`
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (1, 1, 1, ".date('Y').", 0, 1200.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (2, 2, 1, ".date('Y').", 0, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (3, 3, 1, ".date('Y').", 0, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());

        //Add 3 employees to `hs_hr_employee`
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` ($this->employeeFields) VALUES (1, '001', 'Bauer', 'Jack', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` ($this->employeeFields) VALUES (2, '002', 'Bond', 'James', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` ($this->employeeFields) VALUES (3, '003', 'Owen', 'David', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)"),mysql_error());

		$hspSummary = new HspSummary();

		$summary = $hspSummary->fetchPersonalHspSummary(date('Y'), 1);

		$this->assertTrue(is_array($summary));
		$this->assertTrue(is_object($summary[0]));
		$this->assertEquals(count($summary), 1);
		$this->assertEquals($summary[0]->getAnnualLimit(), 1200);

		$summary = $hspSummary->fetchPersonalHspSummary(date('Y'), 5);
		$this->assertNull($summary);

    }

    public function testSaveInitialSummary() {

        $this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`"),mysql_error());
        $this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());
        UniqueIDGenerator::getInstance()->resetIDs();

        //Add 3 employees to `hs_hr_employee`
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` ($this->employeeFields) VALUES (1, '001', 'Bauer', 'Jack', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` ($this->employeeFields) VALUES (2, '002', 'Bond', 'James', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` ($this->employeeFields) VALUES (3, '003', 'Owen', 'David', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)"),mysql_error());

		HspSummary::saveInitialSummary(date('Y'), 1);

		$result = mysql_query("SELECT COUNT(*) FROM `hs_hr_hsp_summary`");
		$row = mysql_fetch_array($result);
		$this->assertEquals($row[0], 3);

		// Checking for important fields
		// `hsp_plan_id`
		$result = mysql_query("SELECT `hsp_plan_id` FROM `hs_hr_hsp_summary`");
		$i=0;
		while ($row = mysql_fetch_array($result)) {
			$actual[$i] = $row[0];
			$i++;
		}

		$expected[0] = 1;
		$expected[1] = 1;
		$expected[2] = 1;

		$this->assertEquals($expected, $actual); // Two arrays should be equal

		// `summary_id`
		$result = mysql_query("SELECT `summary_id` FROM `hs_hr_hsp_summary`");
		$i=0;
		while ($row = mysql_fetch_array($result)) {
			$actual[$i] = $row[0];
			$i++;
		}

		$expected[0] = 1;
		$expected[1] = 2;
		$expected[2] = 3;

		$this->assertEquals($expected, $actual); // Two arrays should be equal

		// `employee_id`
		$result = mysql_query("SELECT `employee_id` FROM `hs_hr_hsp_summary`");
		$i=0;
		while ($row = mysql_fetch_array($result)) {
			$actual[$i] = $row[0];
			$i++;
		}

		$expected[0] = 1;
		$expected[1] = 2;
		$expected[2] = 3;

		$this->assertEquals($expected, $actual); // Two arrays should be equal

		// Cleaning the database
        $this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());
        $this->assertTrue(mysql_query("UPDATE `hs_hr_unique_id` SET `last_id` = '0' WHERE `table_name` = 'hs_hr_hsp_summary' AND `field_name` = 'summary_id'"),mysql_error());

		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`"),mysql_error());
		$this->assertTrue(mysql_query("UPDATE `hs_hr_unique_id` SET `last_id` = '0' WHERE `table_name` = 'hs_hr_employee' AND `field_name` = 'emp_number'"),mysql_error());

    }

	/**
	 * This test is to check whether the function accepts zero for HSP Plan ID
	 */

    public function testSaveInitialSummary2() {

        try {
            HspSummary::saveInitialSummary(date('Y'), 0);
            $this->fail("Zero is accepted for HSP Plan ID");
        } catch (HspSummaryException $e) {
            $this->assertEquals(HspSummaryException::HSP_PLAN_NOT_DEFINED, $e->getCode());
        }

    }

	/**
	 * This test is to check whether the function throws an excpetion when no employee has been defined.
	 */

    public function testSaveInitialSummary3() {

        try {
        	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`"),mysql_error());
            HspSummary::saveInitialSummary(date('Y'), 1);
            $this->fail("No exception is thrown when no employee exists");
        } catch (HspSummaryException $e) {
            $this->assertEquals(HspSummaryException::NO_EMPLOYEE_EXISTS, $e->getCode());
        }

    }

    public function testRecordsExist() {

    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());

    	// Add 2 records to `hs_hr_hsp_summary`
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (1, 1, 1, ".date('Y').", 0, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (2, 2, 1, ".date('Y').", 0, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());

		$this->assertTrue(HspSummary::recordsExist(date('Y')));
		$this->assertTrue(HspSummary::recordsExist(date('Y'), 1));
		$this->assertFalse(HspSummary::recordsExist(date('Y')+1));
		$this->assertFalse(HspSummary::recordsExist(date('Y'), 2));
		$this->assertFalse(HspSummary::recordsExist(date('Y')+1, 2));

    }

    public function testRecordsCount() {

    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());

    	// Add 2 records to `hs_hr_hsp_summary`
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (1, 1, 1, ".date('Y').", 0, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (2, 2, 1, ".date('Y').", 0, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());

		$this->assertEquals(HspSummary::recordsCount(date('Y'), 1), 2);

    }

    public function testSaveHspSummary() {

    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());

    	// Add 2 records to `hs_hr_hsp_summary`
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (1, 1, 1, ".date('Y').", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (2, 2, 1, ".date('Y').", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());

		$summaryObj[0] = new HspSummary();

		$summaryObj[0]->setSummaryId(1);
		$summaryObj[0]->setAnnualLimit(1200);
		$summaryObj[0]->setEmployerAmount(60);
		$summaryObj[0]->setEmployeeAmount(50);
		$summaryObj[0]->setTotalAccrued(110);
		$summaryObj[0]->setTotalUsed(75);

		$summaryObj[1] = new HspSummary();

		$summaryObj[1]->setSummaryId(2);
		$summaryObj[1]->setAnnualLimit(1800);
		$summaryObj[1]->setEmployerAmount(80);
		$summaryObj[1]->setEmployeeAmount(70);
		$summaryObj[1]->setTotalAccrued(150);
		$summaryObj[1]->setTotalUsed(200);

		$saveObj = new HspSummary();

		$saveObj->saveHspSummary($summaryObj);

		$result = mysql_query("SELECT `annual_limit`, `employer_amount`, `employee_amount`, `total_accrued`, `total_used` FROM `hs_hr_hsp_summary`");

		$i = 0;
		while ($row = mysql_fetch_array($result)) {

			$actual[$i][0] = (int)$row[0];
			$actual[$i][1] = (int)$row[1];
			$actual[$i][2] = (int)$row[2];
			$actual[$i][3] = (int)$row[3];
			$actual[$i][4] = (int)$row[4];

			$i++;

		}

		$expected[0][0] = 1200;
		$expected[0][1] = 60;
		$expected[0][2] = 50;
		$expected[0][3] = 110;
		$expected[0][4] = 75;

		$expected[1][0] = 1800;
		$expected[1][1] = 80;
		$expected[1][2] = 70;
		$expected[1][3] = 150;
		$expected[1][4] = 200;

		$this->assertEquals($expected[0], $actual[0]);
		$this->assertEquals($actual[1], $expected[1]);

    }

	public function testSaveInitialSummaryForOneEmployee1() {

		HspSummary::saveInitialSummaryForOneEmployee(2);

		$result = mysql_query("SELECT COUNT(`employee_id`) FROM `hs_hr_hsp_summary` WHERE `employee_id` = '2'");
		$row = mysql_fetch_array($result, MYSQL_NUM);

		// There should be 4 records for employee 2
		$this->assertEquals(4, $row[0]);

	}

	public function testSaveInitialSummaryForOneEmployee2() {

		// Four records for employee-1 are added at setup

		HspSummary::saveInitialSummaryForOneEmployee(2);

		$result = mysql_query("SELECT `hsp_plan_id`, `hsp_plan_year` FROM `hs_hr_hsp_summary` WHERE `employee_id` = '2'");

		$k = 0;
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		    $actual[$k][0] = $row[0];
			$actual[$k][1] = $row[1];
			$k++;
		}

		$expected[0][0] = 1;
		$expected[0][1] = date('Y');
		$expected[1][0] = 3;
		$expected[1][1] = date('Y');
		$expected[2][0] = 1;
		$expected[2][1] = date('Y')+1;
		$expected[3][0] = 3;
		$expected[3][1] = date('Y')+1;

		for ($i=0; $i<4; $i++) {
		    $this->assertEquals($expected[$i][0], $actual[$i][0]);
			$this->assertEquals($expected[$i][1], $actual[$i][1]);
		}

	}

    public function testGetYears() {
    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());

    	// Add 2 records to `hs_hr_hsp_summary`
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (2, 1, 1, ". (date('Y') - 2) .", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (3, 1, 1, ". (date('Y') + 5) .", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (6, 1, 1, ". (date('Y') + 2) .", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());

	$year = (int) date('Y');
	$expected = array($year -2, $year - 1, $year, $year + 1, $year + 2, $year + 5);

	$result = HspSummary::getYears();

	$this->assertEquals($expected, $result);
    }

    public function testGetYearsAndPlans() {

    	/* DB values are as follows
    	 * hsp_plan_id	hsp_plan_year
    	 * 1			date('Y')
    	 * 3			date('Y')
    	 * 1			date('Y')+1
    	 * 3			date('Y')+1
    	 */

    	/* Expected array should be as follows
    	 * $both[0]['year'] = date('Y');
    	 * $both[0]['plan'][0] = 1;
    	 * $both[0]['plan'][1] = 3;
    	 * $both[1]['year'] = date('Y')+1;
    	 * $both[1]['plan'][0] = 1;
    	 * $both[1]['plan'][1] = 3;
    	 */

		$both = HspSummary::getYearsAndPlans();

        $this->assertEquals(date('Y'), $both[0]['year']);
        $this->assertEquals(date('Y')+1, $both[1]['year']);

        $this->assertEquals(1, $both[0]['plan'][0]);
        $this->assertEquals(3, $both[0]['plan'][1]);
        $this->assertEquals(1, $both[1]['plan'][0]);
        $this->assertEquals(3, $both[1]['plan'][1]);

    }

    private function _backupTables($arrTableList) {

    	foreach ($arrTableList as $table) {
	    	$result = mysql_query("SELECT * FROM `$table`");
			while($row = mysql_fetch_array($result, MYSQL_NUM)) {
				$this->oldValues["$table"][] = $row;
			}
			mysql_free_result($result);
    	}
    }

    private function _restoreTables() {

    	$arrTableList = array_keys($this->oldValues);
    	if (count($arrTableList) == 0) {
    	    return;
    	}

    	foreach ($arrTableList as $table) {
    		if ($table == 'AUTO_INC_PK_TABLE') {
    			continue;
    		}

    		$this->assertTrue(mysql_query("INSERT INTO `$table` VALUES ('" . implode("', '", $this->oldValues["$table"]) . "')"), mysql_error());
    	}
    }

}

// Call HspSummaryTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'HspSummaryTest::main') {
    HspSummaryTest::main();
}
?>
