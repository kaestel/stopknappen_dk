<?php
$access_item["/"] = true;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();
$itemtype = "starttopic";


$page->bodyClass("start");
$page->pageTitle("En frisk start");


if(is_array($action) && count($action)) {

	# /start/tag/#tag# - list based on tags
	if(count($action) == 2 && $action[0] == "tag") {

		$page->page(array(
			"templates" => "startknappen/tag.php"
		));
		exit();
	}

	# /start/#sindex# - view
	else if(count($action) == 1) {

		$page->page(array(
			"templates" => "startknappen/view.php"
		));
		exit();
	}

}

$page->page(array(
	"templates" => "startknappen/index.php"
));

?>
