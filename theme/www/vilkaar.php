<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();


$page->bodyClass("terms");
$page->pageTitle("Vilkår");


$page->page(array(
	"templates" => "pages/terms.php"
));
exit();

?>