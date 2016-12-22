<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Monarto\Shorty
 */

namespace Logics\Solitaire\Shorty;

use \Logics\Foundation\VisualXMLEditor\VisualXMLEditor;
use \Logics\Foundation\Web\RequestValidator;
use \Logics\Foundation\Web\ScenarioAction;

/**
 * Shorty get short URL action page
 *
 * @author    Andrey Mashukov <andrey@logics.net.au>
 * @copyright 2016 Andrey Mashukov
 * @license   http://www.gefest.com.au/license Gefest proprietary license
 * @version   SVN: $Date: 2016-05-04 03:21:50 +0930 (Ср, 04 май 2016) $ $Revision: 105 $
 * @link      $HeadURL: http://svn.logics.net.au/monarto/Shorty/site/ActionLogin.php $
 */

class ActionGetURL extends ScenarioAction
    {

	/**
	 * Perform custom actions required for this page
	 *
	 * @param RequestValidator $r RequestValidator containing inbound request
	 *
	 * @return void
	 *
	 * @untranslatable Home
	 * @untranslatable shortURL
	 * @untranslatable URL
	 * @untranslatable longurl
	 */

	public function actions(RequestValidator $r)
	    {
		unset($r);
		$vxe = VisualXMLEditor::retrieve("longurl");
		if ($vxe !== false)
		    {
			$xml     = $vxe->simplexml();
			$longURL = $xml->{"URL"};

			$urlManager = new URLManager();
			$shortURL   = $urlManager->produceShortURL($longURL);
			$this->storage->put("shortURL", $shortURL, "Home");
		    }
	    } //end actions()


    } //end class

?>
