<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();
$itemtype = "article";


$page->bodyClass("articles");
$page->pageTitle("Hvorfor, Fordi.");


if(is_array($action) && count($action)) {

	# /artikler/tag/#tag# - list based on tags
	if(count($action) == 2 && $action[0] == "tag") {

		$page->page(array(
			"templates" => "articles/articles_tag.php"
		));
		exit();
	}

	# /artikler/#sindex# - view
	else if(count($action) == 1) {

		$page->page(array(
			"templates" => "articles/article.php"
		));
		exit();
	}

}

// show list
$page->page(array(
	"templates" => "articles/articles.php"
));
exit();

?>
