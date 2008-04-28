<?php
// Call HspSummaryTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'HspSummaryTest::main');
}

require_once 'PHPUnit/Framework.php';

require_once "testConf.php";
require_once ROOT_PATH."/lib/confs/Conf.php";

require_once 'HspSummary.php';

/**
 * Test class for HspSummary.
 * Generated by PHPUnit on 2008-02-15 at 15:36:45.
 */
class HspSummaryTest extends PHPUnit_Framework_TestCase {
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

    	$conf = new Conf();
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
        mysql_select_db($conf->dbname);

    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());
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
		$this->assertTrue(mysql_query("UPDATE `hs_hr_unique_id` SET `last_id` = '0' WHERE `id` = '34'"),mysql_error());
    }

    public function testFetchSummary() {

    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());

    	// Add 3 records to `hs_hr_hsp_summary`
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (1, 1, 1, ".date('Y').", 0, 1200.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (2, 2, 1, ".date('Y').", 0, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (3, 3, 1, ".date('Y').", 0, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());

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

		$hspSummary = new HspSummary();

		$summary = $hspSummary->fetchPersonalHspSummary(date('Y'), 1);

		$this->assertTrue(is_array($summary));
		$this->assertTrue(is_object($summary[0]));
		$this->assertEquals(count($summary), 1);
		$this->assertEquals($summary[0]->getAnnualLimit(), 1200);

		$summary = $hspSummary->fetchPersonalHspSummary(date('Y'), 5);

		$this->assertTrue(is_array($summary));
		$this->assertEquals(count($summary), 0);
    }

    public function testSaveInitialSummary() {

        $this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`"),mysql_error());
        $this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());
        $this->assertTrue(mysql_query("UPDATE `hs_hr_unique_id` SET `last_id` = '0' WHERE `id` = '34'"),mysql_error());

        //Add 3 employees to `hs_hr_employee`
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` VALUES (1, '001', 'Bauer', 'Jack', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` VALUES (2, '002', 'Bond', 'James', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_employee` VALUES (3, '003', 'Owen', 'David', '', '', 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)"),mysql_error());

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
        $this->assertTrue(mysql_query("UPDATE `hs_hr_unique_id` SET `last_id` = '0' WHERE `id` = '34'"),mysql_error());

		$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_employee`"),mysql_error());
		$this->assertTrue(mysql_query("UPDATE `hs_hr_unique_id` SET `last_id` = '0' WHERE `id` = '8'"),mysql_error());

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

    public function testSaveInitialSummaryForOneEmployee() {

    	$this->assertTrue(mysql_query("TRUNCATE TABLE `hs_hr_hsp_summary`"),mysql_error());

    	// Add 2 records to `hs_hr_hsp_summary`
    	$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (1, 1, 1, ".date('Y').", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());
		$this->assertTrue(mysql_query("INSERT INTO `hs_hr_hsp_summary` VALUES (2, 1, 3, ".date('Y').", 1, 0.00, 0.00, 0.00, 0.00, 0.00)"),mysql_error());

		HspSummary::saveInitialSummaryForOneEmployee(date('Y'), 2);

		$result = mysql_query("SELECT `employee_id`, `hsp_plan_id` FROM `hs_hr_hsp_summary` WHERE `summary_id` = '3' OR `summary_id` = '4'");

		$empIds[0] = 2;
		$empIds[1] = 2;

		$hspIds[0] = 1;
		$hspIds[1] = 3;

		$i = 0;

		while ($row = mysql_fetch_array($result)) {

		    $this->assertEquals($empIds[$i], $row['employee_id']);
			$this->assertEquals($hspIds[$i], $row['hsp_plan_id']);

			$i++;

		}

    }


}

// Call HspSummaryTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'HspSummaryTest::main') {
    HspSummaryTest::main();
}
?>
