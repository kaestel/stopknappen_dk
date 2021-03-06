<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();
$itemtype = "stoptopic";


$page->bodyClass("stop");
$page->pageTitle("Tryk stop, før det er for sent");


if(session()->value("user_group_id") == 1) {
	
	$page->page(array(
		"body_class" => "buttons",
		"templates" => "stopknappen/login-or-signup.php"
	));
	exit();
	
}
else if(is_array($action) && count($action)) {

	# /stopknappen/tag/#tag# - list based on tags
	if(count($action) == 2 && $action[0] == "tag") {

		$page->page(array(
			"templates" => "stopknappen/tag.php"
		));
		exit();
	}

	# /artikler/#sindex# - view
	else if(count($action) == 1) {

		$page->page(array(
			"templates" => "stopknappen/view.php"
		));
		exit();
	}

}
else {

	$page->page(array(
		"templates" => "stopknappen/index.php"
	));
	
}

?>
