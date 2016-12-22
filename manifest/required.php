<?php

/**
 * PHP version 5.6
 *
 * @package   Manifest
 * @author    Config Generator <jenkins@svn.logics.net.au>
 * @copyright 2016 Andrey Mashukov
 * @license   http://www.gefest.com.au/license Gefest proprietary license
 * @version   SVN: $Date: 2016-09-30 23:05:14 +0930 (Fri, 30 Sep 2016) $ $Revision: 14 $
 * @link      $HeadURL: https://svn.logics.net.au/solitaire/shorty/trunk/manifest/required.php $
 */

/**
 * Automatically generated file, do not modify
 *
 * @donottranslate
 */

use \Logics\Foundation\Init\EnvironmentCheck;

EnvironmentCheck::constant("SHORT_HOST");
EnvironmentCheck::constant("LOGGER_HOST");
EnvironmentCheck::constant("LOGGER_DB");
EnvironmentCheck::constant("LOGGER_USER");
EnvironmentCheck::constant("LOGGER_PASS");

$packages = array(
	     array(
	      "command"   => "/usr/bin/tesseract",
	      "package"   => "tesseract",
	      "enablecmd" => "",
	      "restart"   => false,
	      "noinstall" => false,
	     ),
	     array(
	      "command"   => "/usr/bin/latex",
	      "package"   => "texlive-latex",
	      "enablecmd" => "",
	      "restart"   => false,
	      "noinstall" => false,
	     ),
	     array(
	      "command"   => "/usr/bin/dvips",
	      "package"   => "texlive-dvips",
	      "enablecmd" => "",
	      "restart"   => false,
	      "noinstall" => false,
	     ),
	     array(
	      "command"   => "/usr/bin/pdftohtml",
	      "package"   => "poppler-utils",
	      "enablecmd" => "",
	      "restart"   => false,
	      "noinstall" => false,
	     ),
	    );

EnvironmentCheck::packages($packages);

?>
