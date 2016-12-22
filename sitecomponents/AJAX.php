<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Solitaire\Shorty;
 */

namespace Logics\Solitaire\Shorty;

use \Logics\Foundation\BaseLib\Request;
use \Logics\Foundation\JSON\JSONResponder;
use \Logics\Foundation\SQL\SQLdatabase;

/**
 * AJAX responder
 *
 * @author    Andrey Mashukov <andrey@logics.net.au>
 * @copyright 2016 Andrey Mashukov
 * @license   https://opensource.org/licenses/MIT MIT License
 * @version   SVN: $Date: 2016-09-07 09:02:04 +0930 (Wed, 07 Sep 2016) $ $Revision: 332 $
 * @link      $HeadURL: http://svn.logics.net.au/foundation/messagesender/trunk/sitecomponents/AJAX.php $
 */

class AJAX
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
	 * Responder to AJAX requests
	 *
	 * @param Request $r HTTP request
	 *
	 * @return void
	 *
	 * @sitecomponent ajax
	 *
	 * @untranslatable success
	 */

	public function responder(Request $r)
	    {
		if (isset($r->longurl) === true)
		    {
			$urlManager = new URLManager();
			JSONResponder::jsonResponse(array("status" => "success", "data" => $urlManager->produceShortURL($r->longurl)));
		    }
	    } //end responder()


    } //end class

?>
