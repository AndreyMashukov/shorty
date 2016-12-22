<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Solitaire\Shorty
 */

namespace Logics\Solitaire\Shorty;

use \Logics\Foundation\DAO\DAOImplementation;
use \Logics\Foundation\SQL\SQL;

/**
 * MySQL Implementation Shorty
 *
 * @author    Andrey Mashukov <andrey@logics.net.au>
 * @copyright 2013-2016 Andrey Mashukov
 * @license   https://opensource.org/licenses/MIT MIT License
 * @version   SVN: $Date: 2016-03-17 06:19:03 +1030 (Thu, 17 Mar 2016) $ $Revision: 1554 $
 * @link      $HeadURL: http://svn.logics.net.au/foundation/tests/DAO/dao/ImplementationOne.php $
 *
 * @defaultdaoimplementation
 */

class MySQLImplementation extends DAOImplementation
    {

	/**
	 * Instance of database
	 *
	 * @var SQLDatabase
	 */
	private $_db;

	/**
	 * Initialization of implementation
	 *
	 * @param bool $newprocess Whether we run in new process which may differ from original
	 *
	 * @return void
	 *
	 * @untranslatable MySQL
	 */

	public function __construct($newprocess)
	    {
		$this->_db = SQL::get("MySQL", $newprocess === false);
		$this->normalize();
	    } //end __construct()


	/**
	 * IsLongURLExists method, checking is exists this long URL
	 *
	 * @param string $longURL Is long URL
	 *
	 * @return bool long URL exists
	 */

	public function isLongURLExists($longURL)
	    {
		$result = $this->_db->exec(
		    "SELECT `longURL` FROM `associations` " .
		    "WHERE `longURL` = " . $this->_db->sqlText($longURL)
		);
		return ($result->getNumRows() === 0) ? false : true;
	    } //end isLongURLExists()


	/**
	 * IsShortURLExists method, checking is exists this short URL
	 *
	 * @param string $shortURL Is long URL
	 *
	 * @return bool Short URL exists
	 */

	public function isShortURLExists($shortURL)
	    {
		$result = $this->_db->exec(
		    "SELECT `shortURL` FROM `associations` " .
		    "WHERE `shortURL` = " . $this->_db->sqlText($shortURL)
		);
		return ($result->getNumRows() === 0) ? false : true;
	    } //end isShortURLExists()


	/**
	 * Add association long URL and short URL
	 *
	 * @param string $longURL  Long URL
	 * @param string $shortURL Short URL
	 *
	 * @return void
	 */

	public function addAssociation($longURL, $shortURL)
	    {
		$this->_db->exec(
		    "INSERT INTO `associations` SET " .
		    "`longURL`  = " . $this->_db->sqlText($longURL) . ", " .
		    "`shortURL` = " . $this->_db->sqlText($shortURL)
		);
	    } //end addAssociation()


	/**
	 * Getting short URL by long URL
	 *
	 * @param string $longURL Long URL
	 *
	 * @return string Short URL or empty string
	 */

	public function getShortURL($longURL)
	    {
		$result = $this->_db->exec("SELECT `shortURL` FROM `associations` " .
		    "WHERE `longURL` = " . $this->_db->sqlText($longURL)
		);
		if ($result->getNumRows() > 0)
		    {
			$row = $result->getRow();
			return $row["shortURL"];
		    }
		else
		    {
			return "";
		    }
	    } //end getShortURL()


	/**
	 * Getting long URL by short URL
	 *
	 * @param string $shortURL Long URL
	 *
	 * @return string Long URL or empty string
	 */

	public function getLongURL($shortURL)
	    {
		$result = $this->_db->exec("SELECT `longURL` FROM `associations` " .
		    "WHERE `shortURL` = " . $this->_db->sqlText($shortURL)
		);
		if ($result->getNumRows() > 0)
		    {
			$row = $result->getRow();
			return $row["longURL"];
		    }
		else
		    {
			return "";
		    }
	    } //end getLongURL()


	/**
	 * Normalize data
	 *
	 * @return void
	 *
	 * @untranslatable PRIMARY KEY (id),
	 * @untranslatable INDEX (longURL(128)),
	 * @untranslatable INDEX (shortURL(32)))
	 * @untranslatable ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE utf8_general_ci
	 */

	public function normalize()
	    {
		$this->_db->exec(
		    "CREATE TABLE IF NOT EXISTS `associations` (" .
		    "`id` int(11) AUTO_INCREMENT, " .
		    "`longURL` text NOT NULL, " .
		    "`shortURL` text NOT NULL, " .
		    "PRIMARY KEY (id), " .
		    "INDEX (longURL(128)), " .
		    "INDEX (shortURL(32)))" .
		    "ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE utf8_general_ci"
		);
	    } //end normalize()


	/**
	 * Check data
	 *
	 * @return void
	 */

	public function check()
	    {
		$this->_db->exec("OPTIMIZE TABLE `associations`");
	    } //end check()


    } //end class

?>
