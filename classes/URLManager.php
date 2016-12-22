<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Solitaire\Shorty
 */

namespace Logics\Solitaire\Shorty;

use \Logics\Foundation\DAO\DAO;

/**
 * URL Manager
 *
 * @author    Andrey Mashukov <andrey@dev.logics.net.au>
 * @copyright 2016 Andrey Mashukov
 * @license   http://www.gefest.com.au/license Gefest proprietary license
 * @version   SVN: $Date: 2016-06-15 22:11:39 +0930 (Wed, 15 Jun 2016) $ $Revision: 138 $
 * @link      $HeadURL: http://svn.logics.net.au/monarto/vilves/classes/Ads.php $
 */

class URLManager
    {

	/**
	 * Producing short URL from long URL
	 *
	 * @param string $longURL Long URL from request
	 *
	 * @return string $shortURL Contains short URL
	 *
	 * @requiredconst SHORT_HOST "http://shorty.ru" Name of the host which will redirect short URLs
	 *
	 * @untranslatable shorturls
	 */

	public function produceShortURL($longURL)
	    {
		$dao      = DAO::get("shorturls");
		$shortURL = false;
		if ($dao->isLongURLExists($longURL) === true)
		    {
			$shortURL = $dao->getShortURL($longURL);
		    }
		else
		    {
			for ($salt = 0; true; $salt++)
			    {
				$shortURL = $this->_getShortURL($longURL, $salt);
				if ($dao->isShortURLExists($shortURL) === false)
				    {
					break;
				    }
			    }

			$dao->addAssociation($longURL, $shortURL);
		    }

		return SHORT_HOST . "/" . $shortURL;
	    } //end produceShortURL()


	/**
	 * Getting long URL by short URL
	 *
	 * @param string $shortURL Short URL from request
	 *
	 * @return string $longURL Contains long URL
	 *
	 * @requiredconst SHORT_HOST "http://shorty.ru" Name of the host which will redirect short URLs
	 *
	 * @untranslatable shorturls
	 * @untranslatable \//ui
	 */

	public function getLongURL($shortURL)
	    {
		$dao     = DAO::get("shorturls");
		$longURL = "";
		$hash    = preg_replace("/^" . preg_quote(SHORT_HOST, "/") . "\//ui", "", $shortURL);
		if ($dao->isShortURLExists($hash) === true)
		    {
			$longURL = $dao->getLongURL($hash);
		    }

		return $longURL;
	    } //end getLongURL()


	/**
	 * Short URL generator
	 *
	 * @param string $longURL Long URL
	 * @param int    $salt    Any  symbol for make unique longURL
	 *
	 * @return string $shortURL short URL
	 *
	 * @untranslatable 0123456789abcdef
	 * @untranslatable ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz
	 */

	private function _getShortURL($longURL, $salt)
	    {
		$hash         = substr(md5($salt . $longURL), 0, 14);
		$digits       = "0123456789abcdef";
		$fromBase     = strlen($digits);
		$allowedchars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$toBase       = strlen($allowedchars);
		$length       = strlen($hash);
		$result       = "";

		$nibbles = array();
		for ($i = 0; $i < $length; ++$i)
		    {
			$nibbles[$i] = strpos($digits, $hash[$i]);
		    }

		do
		    {
			$value  = 0;
			$newlen = 0;
			for ($i = 0; $i < $length; ++$i)
			    {
				$value = (($value * $fromBase) + $nibbles[$i]);
				if ($value >= $toBase)
				    {
					$nibbles[$newlen++] = (int) ($value / $toBase);
					$value             %= $toBase;
				    }
				else if ($newlen > 0)
				    {
					$nibbles[$newlen++] = 0;
				    }
			    }

			$length = $newlen;
			$result = $allowedchars[$value] . $result;
		    } while ($newlen != 0);

		return $result;
	    } //end _getShortURL()


    } //end class

?>
