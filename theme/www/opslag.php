<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();
$itemtype = "post";


$page->bodyClass("posts");
$page->pageTitle("Opslag");



// post list for tags
// /opslag/#sindex#
if(count($action) == 1) {

	$page->page(array(
		"templates" => "posts/post.php"
	));
	exit();

}
// /opslag/tag/#tag#
// /opslag/tag/#tag#/#sindex#/prev|next
else if(count($action) >= 2 && $action[0] == "tag") {

	$page->page(array(
		"templates" => "posts/posts_tag.php"
	));
	exit();

}


$page->page(array(
	"templates" => "posts/posts.php"
));
exit();


?>
 