<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();


$page->bodyClass("buttons");
$page->pageTitle("Stop / Start");


$page->page(array(
	"templates" => "pages/knapperne.php"
));

?>
