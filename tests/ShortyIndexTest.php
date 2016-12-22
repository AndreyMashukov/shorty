<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Tests\Solitaire\Shorty
 */

namespace Logics\Tests\Solitaire\Shorty;

use \DOMDocument;
use \Logics\Foundation\HTTP\HTTPclient;
use \Logics\Foundation\SQL\MySQLdatabase;
use \Logics\Foundation\SmartyExtended\XHTMLvalidator;
use \Logics\Foundation\XML\DOMXPathExtended;
use \Logics\Tests\DefaultDataSet;
use \Logics\Tests\GetConnectionMySQL;
use \Logics\Tests\GetSetUpOperation;
use \Logics\Tests\InternalWebServer;
use \Logics\Tests\PHPUnit_Extensions_ScenarioPlayer_TestCase;
use \Logics\Tests\ScriptExecutor;
use \Logics\Tests\VXEDevelopmentTools;

/**
 * Test for Shorty's index.php
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

class ShortyIndexTest extends PHPUnit_Extensions_ScenarioPlayer_TestCase
    {

	use GetConnectionMySQL;

	use GetSetUpOperation;

	use InternalWebServer;

	use VXEDevelopmentTools;

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
		parent::setUpScript(dirname(__DIR__) . "/index.php");

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
	 * Test for the Home page
	 *
	 * @return void
	 */

	public function testShouldGenerateHomePage()
	    {
		$html = $this->_execute($this->script, array(), "GET");
		$this->assertTrue(XHTMLvalidator::validate($html, true));
	    } //end testShouldGenerateHomePage()


	/**
	 * Test for exists shortURL
	 *
	 * @return void
	 */

	public function testShouldReturnExistingShortLink()
	    {
		$this->instanceid = "longurl";

		$html        = $this->_execute($this->script, array(), "GET");
		$requestData = array("LongURL[1]/URL[1]" => "https://vk.com");

		$post               = $this->getFormData($html, $requestData);
		$post["transition"] = "geturl";
		$html               = $this->_execute($this->script, $post, "POST");
		$this->assertTrue(XHTMLvalidator::validate($html, true));
		$this->assertContains("http://shorty.ru/EJRDjds", $html);
	    } //end testShouldReturnExistingShortLink()


	/**
	 * Test for getting short link
	 *
	 * @return void
	 */

	public function testShouldGetShortLink()
	    {
		$this->instanceid = "longurl";

		$html        = $this->_execute($this->script, array(), "GET");
		$requestData = array("LongURL[1]/URL[1]" => "http://irkagenta.net/advert.php?ad=802817");

		$post               = $this->getFormData($html, $requestData);
		$post["transition"] = "geturl";
		$html               = $this->_execute($this->script, $post, "POST");
		$this->assertTrue(XHTMLvalidator::validate($html, true));
		$this->assertRegExp("|http://shorty\.ru/[A-Za-z]+|", $html);
	    } //end testShouldGetShortLink()


	/**
	 * Test for getting short url via webserver
	 *
	 * @return void
	 */

	public function testShouldGetShortUrlViaWebserver()
	    {
		$http = new HTTPclient($this->webserverURL());
		$html = $http->get();
		$doc  = new DOMDocument();
		$doc->loadXML($html);
		$xpath = new DOMXPathExtended($doc);
		$query = $xpath->query("//null:input[@class='singlelinewidget']");
		$this->assertEquals(1, $query->length);

		$query = $xpath->query("//null:input[@name='longurl[formtracker]' and @value='longurl']");
		$this->assertEquals(1, $query->length);

		$query = $xpath->query("//null:input[@name='transition' and @value='geturl']");
		$this->assertEquals(1, $query->length);

		$this->instanceid = "longurl";
		$requestData      = array("LongURL[1]/URL[1]" => "http://irkagenta.net/advert.php?ad=802817");

		$post               = $this->getFormData($html, $requestData);
		$post["transition"] = "geturl";

		$http->setRequest($this->webserverURL(), $post);
		$html = $http->post();
		$this->assertTrue(XHTMLvalidator::validate($html, true));
		$this->assertContains("http://shorty.ru/EeYWurygag", $html);
	    } //end testShouldGetShortUrlViaWebserver()


	/**
	 * Test for correct behaviour withiot session
	 *
	 * @return void
	 */

	public function testShouldBehaveCorrectlyWithoutSession()
	    {
		$http = new HTTPclient($this->webserverURL());
		$html = $http->get();
		$doc  = new DOMDocument();
		$doc->loadXML($html);
		$xpath = new DOMXPathExtended($doc);
		$query = $xpath->query("//null:input[@class='singlelinewidget']");
		$this->assertEquals(1, $query->length);

		$query = $xpath->query("//null:input[@name='longurl[formtracker]' and @value='longurl']");
		$this->assertEquals(1, $query->length);

		$query = $xpath->query("//null:input[@name='transition' and @value='geturl']");
		$this->assertEquals(1, $query->length);

		$this->instanceid = "longurl";
		$requestData      = array("LongURL[1]/URL[1]" => "http://irkagenta.net/advert.php?ad=802817");

		$post               = $this->getFormData($html, $requestData);
		$post["transition"] = "geturl";

		$http = new HTTPclient($this->webserverURL(), $post);
		$html = $http->post();
		$this->assertTrue(XHTMLvalidator::validate($html, true));
	    } //end testShouldBehaveCorrectlyWithoutSession()


	/**
	 * Test for redirector
	 *
	 * @return void
	 */

	public function testShouldReturnRedirectHeaders()
	    {
		$http    = new HTTPclient($this->webserverURL() . "/EJRDjdsErt", array(), array(), array("followlocation" => false));
		$page    = $http->get();
		$headers = $http->lastheaders();
		$this->assertTrue(isset($headers["Location"]));
		$this->assertEquals("https://vk.com", $headers["Location"]);

		$http    = new HTTPclient($this->webserverURL() . "/JHYgfTREcV", array(), array(), array("followlocation" => false));
		$page    = $http->get();
		$headers = $http->lastheaders();
		$this->assertTrue(isset($headers["Location"]));
		$this->assertEquals("http://invalid.ru", $headers["Location"]);
	    } //end testShouldReturnRedirectHeaders()


    } //end class

?>
