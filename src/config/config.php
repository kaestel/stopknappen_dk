<?php

/**
* This file contains definitions
*
* @package Config Dummy file
*/
header("Content-type: text/html; charset=UTF-8");
error_reporting(E_ALL);

/**
* Site name
*/
define("SITE_UID", "stop");
define("SITE_NAME", "Stopknappen");
define("SITE_URL", (isset($_SERVER["HTTPS"]) ? "https" : "http")."://".$_SERVER["SERVER_NAME"]);
define("SITE_EMAIL", "start@stopknappen.dk");

/**
* Optional constants
*/
define("DEFAULT_PAGE_DESCRIPTION", "");
define("DEFAULT_PAGE_IMAGE", "/img/logo-large.png");

define("DEFAULT_LANGUAGE_ISO", "EN"); // Reginal language English
define("DEFAULT_COUNTRY_ISO", "DK"); // Regional country Denmark
define("DEFAULT_CURRENCY_ISO", "DKK");


// ENABLE ITEMS MODEL
define("SITE_ITEMS", true);
define("SITE_SIGNUP", "/deltag");


// Enable notifications (send collection email after N notifications)
define("SITE_COLLECT_NOTIFICATIONS", 50);


// INSTALL MODE
//define("SITE_INSTALL", true);

?>
