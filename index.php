<?php

/**
 * PHP version 5.6
 *
 * @package Logics\Solitaire\Shorty
 *
 * Short URLS
 *
 * @author    Andrey Mashukov <andrey@logics.net.au>
 * @copyright 2016 Andrey Mashukov
 * @license   http://www.gefest.com.au/license Gefest proprietary license
 * @version   SVN: $Date: 2016-08-03 07:35:48 +0930 (Ср, 03 авг 2016) $ $Revision: 38 $
 * @link      $HeadURL: https://svn.logics.net.au/solitaire/nataly-fit/trunk/index.php $
 *
 * @untranslatable include_path
 * @untranslatable /vendor
 * @untranslatable MySQL
 * @untranslatable site/map.dotml
 */

namespace Logics\Solitaire\Shorty;

use \Logics\Foundation\Init\Init;
use \Logics\Foundation\SQL\SQL;
use \Logics\Foundation\Web\ScenarioPlayer;

ini_set("include_path", get_include_path() . ":" . __DIR__ . "/vendor" . ":" . dirname(dirname(__DIR__)));
require "autoload.php";

Init::application();
$db = SQL::get("MySQL");

$scenario = new ScenarioPlayer($db, "site/map.dotml");
$scenario->execute();

?>
