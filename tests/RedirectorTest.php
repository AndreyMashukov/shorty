<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Tests\Solitaire\Shorty
 */

namespace Logics\Tests\Solitaire\Shorty;

use \Logics\Foundation\SQL\MySQLdatabase;
use \Logics\Solitaire\Shorty\Redirect;
use \Logics\Tests\DefaultDataSet;
use \Logics\Tests\GetConnectionMySQL;
use \Logics\Tests\GetSetUpOperation;
use \Logics\Tests\PHPUnit_Extensions_Script_TestCase;
use \Logics\Tests\RequestValidator;
use \Logics\Tests\ScriptExecutor;

/**
 * Test for Redirector
 *
 * @author    Andrey Mashukov <andrey@logics.net.au>
 * @copyright 2016 Andrey Mashukov
 * @license   http://www.gefest.com.au/license Gefest proprietary license
 * @version   SVN: $Date: 2016-08-03 07:35:48 +0930 (Ср, 03 авг 2016) $ $Revision: 38 $
 * @link      $HeadURL: https://svn.logics.net.au/solitaire/nataly-fit/trunk/tests/ShortyIndexTest.php $
 *
 * @runTestsInSeparateProcesses
 *
 * @donottranslate
 */

class RedirectorTest extends PHPUnit_Extensions_Script_TestCase
    {

	use GetConnectionMySQL;

	use GetSetUpOperation;

	use ScriptExecutor;

	use DefaultDataSet;

	/**
	 * Database connector
	 *
	 * @var MySQLdatabase
	 */
	private $_db;

	/**
	 * Get test data set
	 *
	 * @return dataset
	 */

	public function getDataSet()
	    {
		return $this->createMySQLXmlDataSet(__DIR__ . "/dataSet.xml");
	    } //end getDataSet()


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */

	protected function setUp()
	    {
		$this->setUpScript(dirname(__DIR__) . "/index.php");

		$this->_db = new MySQLdatabase($GLOBALS["DB_HOST"], $GLOBALS["DB_DBNAME"], $GLOBALS["DB_USER"], $GLOBALS["DB_PASSWD"]);

		$this->_db->execUntilSuccessful(
		    "CREATE TABLE IF NOT EXISTS `associations` (" .
		    "`id` int(11) AUTO_INCREMENT, " .
		    "`longURL` text NOT NULL, " .
		    "`shortURL` text NOT NULL, " .
		    "PRIMARY KEY (id), " .
		    "INDEX (longURL(128)), " .
		    "INDEX (shortURL(32)))" .
		    "ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE utf8_general_ci"
		);

		define("DBHOST", $GLOBALS["DB_HOST"]);
		define("DBNAME", $GLOBALS["DB_DBNAME"]);
		define("DBUSER", $GLOBALS["DB_USER"]);
		define("DBPASS", $GLOBALS["DB_PASSWD"]);

		define("SHORT_HOST", "http://shorty.ru");

		parent::setUp();
	    } //end setUp()


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return void
	 */

	protected function tearDown()
	    {
		$this->_db->exec("DROP TABLE IF EXISTS `associations`");

		parent::tearDown();
	    } //end tearDown()


	/**
	 * Test for the Redirecting
	 *
	 * @return void
	 */

	public function testShouldRedirectToLongUrl()
	    {
		$redirect = new Redirect($this->_db, "", array());

		$GLOBALS["_GET"] = array("transition" => "EJRDjdsErt");
		$r               = new RequestValidator();
		$redirect->redirector($r);

		$GLOBALS["_GET"] = array("transition" => "EJRDjdsEr");
		$r               = new RequestValidator();
		$redirect->redirector($r);

		define("INVALID_REQUEST_URL", "http://invalid.ru");
		$redirect->redirector($r);
	    } //end testShouldRedirectToLongUrl()


    } //end class

?>
