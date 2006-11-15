<?php
// Call BackupTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "BackupTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

define('ROOT_PATH', $rootPath);
define('WPATH', $webPath);
$_SESSION['WPATH'] = WPATH;

require_once "Backup.php";
require_once ROOT_PATH."/lib/confs/Conf.php";

/**
 * Test class for Backup.
 * Generated by PHPUnit_Util_Skeleton on 2006-10-12 at 08:36:24.
 */
class BackupTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    
    public $classBackup = null;
    public $connection = null;
    
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("BackupTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$this->classBackup = new Backup(); 
    	
    	$conf = new Conf();
    	
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
		mysql_query("CREATE DATABASE `BackupTest`");
		 mysql_select_db("BackupTest");
		mysql_query("CREATE TABLE `data_sheet_info` (`request_id` int(10) NOT NULL auto_increment,
  `datasheet_type` varchar(200) NOT NULL default '',   `fullname` varchar(255) NOT NULL default '',
  `companyname` varchar(255) NOT NULL default '',   `jobtitle` varchar(100) NOT NULL default '',
  `noofemployees` varchar(100) NOT NULL default '',   `industry` varchar(100) NOT NULL default '',
  `companyaddress` text NOT NULL, `country` varchar(200) NOT NULL default '',
  `phone` varchar(25) NOT NULL default '',   `email` varchar(100) NOT NULL default '',
  `addtioanlcomments` text NOT NULL,   `foundusfrom` varchar(100) NOT NULL default '',
  `date` varchar(12) NOT NULL default '',   PRIMARY KEY  (`request_id`))");
       
        
        mysql_query("INSERT INTO `data_sheet_info` VALUES (1,'nnn','nn','nn','nn','nn','nn','nn','nn','nn','nn','nn','nn',''),(2,'wireless-i banco','ss','ss','ss','50-99','Automotive','ssssssssss','American Samoa','ss','ss@ss.com','ssss','Yahoo!',''),(3,'wireless-i banco','Testing','Testing','Testing','50-99','Aerospace','Testing Testing Testing \r\nTesting ','Afghanistan','Testing','Testing@beyondm.com','Testing Testing Testing ','Email',''),(4,'wireless-i banco','sureshkumar','manhar','s.d','l-49','Computer/Technology-Manufacturer','pavani prestage','India','9849834559','ask_b4u@sify.com','','Other','')");
		
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
     mysql_query("DROP DATABASE `BackupTest`");	   	
    	 	
    }

  	public function testdumpDatabase(){
  		$conn = $this->connection;
  		$this->classBackup->setConnection($conn);
		$this->classBackup->setDatabase("BackupTest");
		
		$filecontent=$this->classBackup->dumpDatabase(true);
		
		$this->assertEquals($filecontent, true, "No record found");
  	}
	
  	
}

// Call BackupTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "BackupTest::main") {
    BackupTest::main();
}
?>
