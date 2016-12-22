<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Tests\Solitaire\Shorty
 */

namespace Logics\Tests\Solitaire\Shorty;

use \Logics\Foundation\DAO\DAO;
use \Logics\Foundation\SQL\MySQLdatabase;
use \PHPUnit_Framework_TestCase;

/**
 * Test for DAO
 *
 * @author    Andrey Mashukov <andrey@logics.net.au>
 * @copyright 2016 Andrey Mashukov
 * @license   http://www.gefest.com.au/license Gefest proprietary license
 * @version   SVN: $Date: 2016-09-20 02:08:38 +0930 (Вт, 20 сен 2016) $ $Revision: 8 $
 * @link      $HeadURL: https://svn.logics.net.au/solitaire/shorty/trunk/tests/DAOTest.php $
 *
 * @runTestsInSeparateProcesses
 *
 * @donottranslate
 */

class DAOTest extends PHPUnit_Framework_TestCase
    {

	/**
	 * Database connector
	 *
	 * @var MySQLdatabase
	 */
	private $_db;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */

	protected function setUp()
	    {
		set_include_path(dirname(__DIR__) . ":" . get_include_path());

		define("DBHOST", $GLOBALS["DB_HOST"]);
		define("DBNAME", $GLOBALS["DB_DBNAME"]);
		define("DBUSER", $GLOBALS["DB_USER"]);
		define("DBPASS", $GLOBALS["DB_PASSWD"]);

		$this->_db = new MySQLdatabase($GLOBALS["DB_HOST"], $GLOBALS["DB_DBNAME"], $GLOBALS["DB_USER"], $GLOBALS["DB_PASSWD"]);

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
	 * Test for returning short URL
	 *
	 * @return void
	 */

	public function testShouldReturnShortUrl()
	    {
		$dao = DAO::get("shorturls");
		$dao->addAssociation("http://vk.com", "HFJrsvk");
		$this->assertEquals("HFJrsvk", $dao->getShortURL("http://vk.com"));
		$this->assertEquals("", $dao->getShortURL("http://unknown.com"));
	    } //end testShouldReturnShortUrl()


	/**
	 * Test for returning long URL
	 *
	 * @return void
	 */

	public function testShouldReturnLongUrl()
	    {
		$dao = DAO::get("shorturls");
		$dao->addAssociation("http://vk.com", "HFJrsvk");
		$this->assertEquals("http://vk.com", $dao->getLongURL("HFJrsvk"));
		$this->assertEquals("", $dao->getLongURL("UnKNOWn"));
	    } //end testShouldReturnLongUrl()


	/**
	 * Test for Check Data Integrity
	 *
	 * @return void
	 */

	public function testShouldCheckDataIntegrity()
	    {
		$dao = DAO::get("shorturls");
		$dao->check();
	    } //end testShouldCheckDataIntegrity()


	/**
	 * Test cheching existing short URL
	 *
	 * @return void
	 */

	public function testShouldReturnExistingShortUrl()
	    {
		$dao = DAO::get("shorturls");
		$dao->addAssociation("http://vk.com", "HFJrsvk");
		$this->assertTrue($dao->isShortURLExists("HFJrsvk"));
		$this->assertFalse($dao->isShortURLExists("UnKNOWn"));
	    } //end testShouldReturnExistingShortUrl()


	/**
	 * Test cheching existing long URL
	 *
	 * @return void
	 */

	public function testShouldReturnExistingLongUrl()
	    {
		$dao = DAO::get("shorturls");
		$dao->addAssociation("http://vk.com", "HFJrsvk");
		$this->assertTrue($dao->isLongURLExists("http://vk.com"));
		$this->assertFalse($dao->isLongURLExists("http://unknown.com"));
	    } //end testShouldReturnExistingLongUrl()


	/**
	 * Test for DAO check
	 *
	 * @return void
	 */

	public function testShouldCheckData()
	    {
		$dao = DAO::get("shorturls");
		$dao->check();
	    } //end testShouldCheckData()


    } //end class

?>
