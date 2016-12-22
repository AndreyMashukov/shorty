<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Solitaire\Shorty;
 */

namespace Logics\Solitaire\Shorty;

use \Logics\Foundation\BaseLib\Request;
use \Logics\Foundation\SQL\SQLdatabase;

/**
 * URL Redirector
 *
 * @author    Andrey Mashukov <andrey@logics.net.au>
 * @copyright 2016 Andrey Mashukov
 * @license   https://opensource.org/licenses/MIT MIT License
 * @version   SVN: $Date: 2016-09-07 09:02:04 +0930 (Wed, 07 Sep 2016) $ $Revision: 332 $
 * @link      $HeadURL$
 */

class Redirect
    {

	/**
	 * Current database
	 *
	 * @var SQLdatabase
	 */
	private $_db;

	/**
	 * Pages/action classes directory
	 *
	 * @var string
	 */
	private $_dir;

	/**
	 * All possible states
	 *
	 * @var array
	 */
	private $_states;

	/**
	 * Instantiate this class
	 *
	 * @param SQLdatabase $db     Database connector
	 * @param string      $dir    Directory containing page/action classes
	 * @param array       $states List of all possible states
	 *
	 * @return void
	 */

	public function __construct(SQLdatabase $db, $dir, array $states)
	    {
		$this->_db     = $db;
		$this->_dir    = $dir;
		$this->_states = $states;
	    } //end __construct()


	/**
	 * URL Redirector
	 *
	 * @param Request $r HTTP request
	 *
	 * @return void
	 *
	 * @optionalconst INVALID_REQUEST_URL "" URL to which browser should be redirected in case of invalid request. Empty means nothing should be shown to the client.
	 *
	 * @sitecomponent [A-Za-z]{10}
	 *
	 * @untranslatable Location:
	 * @untranslatable INVALID_REQUEST_URL
	 */

	public function redirector(Request $r)
	    {
		if (isset($r->transition) === true)
		    {
			$urlManager = new URLManager();
			$longURL    = $urlManager->getLongURL($r->transition);
			if ($longURL !== "")
			    {
				header("Location: " . $longURL, true, 301);
			    }
			else
			    {
				if (defined("INVALID_REQUEST_URL") === true)
				    {
					header("Location: " . INVALID_REQUEST_URL);
				    }
			    }
		    }
	    } //end redirector()


    } //end class

?>
