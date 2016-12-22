<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Solitaire\Shorty
 *
 * Index page loader
 *
 * @author    Andrey Mashukov <andrey@logics.net.au>
 * @copyright 2016 Andrey Mashukov
 * @license   http://www.gefest.com.au/license Gefest proprietary license
 * @version   SVN: $Date: 2016-08-03 07:35:48 +0930 (Ср, 03 авг 2016) $ $Revision: 38 $
 * @link      $HeadURL: https://svn.logics.net.au/solitaire/nataly-fit/trunk/index.php $
 *
 * @untranslatable http
 * @untranslatable include_path
 * @untranslatable /vendor
 * @untranslatable logics/phpunit-extensions/LoadPHPUnitConfig.php
 * @untranslatable /index.php
 */

$_SERVER["REQUEST_SCHEME"]  = "http";
$_SERVER["DOCUMENT_ROOT"]   = str_replace(__DIR__, dirname(__DIR__), $_SERVER["DOCUMENT_ROOT"]);
$_SERVER["SCRIPT_FILENAME"] = str_replace(__DIR__, dirname(__DIR__), $_SERVER["SCRIPT_FILENAME"]);

chdir(dirname(__DIR__));

ini_set("include_path", get_include_path() . ":" . dirname(__DIR__) . "/vendor");

require stream_resolve_include_path("logics/phpunit-extensions/LoadPHPUnitConfig.php");

require_once dirname(__DIR__) . "/index.php";

?>
