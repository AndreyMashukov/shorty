<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Solitaire\Shorty
 */

namespace Logics\Solitaire\Shorty;

use \Logics\Foundation\SmartyExtended\SmartyExtended;
use \Logics\Foundation\Web\RequestValidator;
use \Logics\Foundation\Web\ScenarioPage;

/**
 * Home page Short URLs
 *
 * @author    Andrey Mashukov <andrey@logics.net.au>
 * @copyright 2016 Andrey Mashukov
 * @license   http://www.gefest.com.au/license Gefest proprietary license
 * @version   SVN: $Date: 2016-08-03 07:35:48 +0930 (Ср, 03 авг 2016) $ $Revision: 38 $
 * @link      $HeadURL: https://svn.logics.net.au/solitaire/nataly-fit/trunk/site/Home.php $
 */

class Home extends ScenarioPage
    {

	/**
	 * Perform custom actions required for this page
	 *
	 * @param SmartyExtended   $smarty Smarty class used to render this page
	 * @param RequestValidator $r      RequestValidator containing inbound request
	 *
	 * @return void
	 *
	 * @untranslatable title
	 * @untranslatable shortURL
	 * @untranslatable ActionGetURL
	 */

	public function actions(SmartyExtended $smarty, RequestValidator $r)
	    {
		unset($r);
		$smarty->assign("title", _("Short URL service"));
		$smarty->assign("shortURL", $this->storage->get("shortURL", "ActionGetURL"));
	    } //end actions()


	/**
	 * Returns list of all forms used on the page
	 *
	 * @param RequestValidator $r Request validator
	 *
	 * @return array List of all forms used on the page
	 *
	 * @untranslatable schema
	 * @untranslatable wayout
	 * @untranslatable geturl
	 * @untranslatable longurl
	 */

	public function forms(RequestValidator $r)
	    {
		unset($r);
		return array("longurl" => array("schema" => "forms/longurl.xsd", "wayout" => "geturl"));
	    } //end forms()


	/**
	 * Returns name of Smarty template file to use
	 *
	 * @return string Name of Smarty template
	 */

	public function template()
	    {
		return "home.tpl";
	    } //end template()


	/**
	 * Returns list of all URIs which this page provides
	 *
	 * @return array URIs array with arrays containing indexes 'loc', 'lastmod', 'changefreq' and 'priority'
	 *
	 * @untranslatable /home
	 */

	public function sitemap()
	    {
		return array(array("loc" => "/home"));
	    } //end sitemap()


    } //end class

?>
