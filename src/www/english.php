<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();
$itemtype = "page";


$page->bodyClass("language");
$page->pageTitle("The Stopbutton");


$page->page(array(
	"templates" => "pages/english.php"
));
exit();

?>