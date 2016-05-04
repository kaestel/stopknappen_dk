<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");
$query = new Query();
$IC = new Item();

print '<?xml version="1.0" encoding="UTF-8"?>';

?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?
// FRONTPAGE
$item = $IC->getItem(array("tags" => "page:front"));
?>
	<url>
		<loc><?= SITE_URL ?>/</loc>
		<lastmod><?= date("Y-m-d", strtotime($item["modified_at"])) ?></lastmod>
		<changefreq>daily</changefreq>
		<priority>1</priority>
	</url>
<?
// POSTS MAINPAGE
$item = $IC->getItem(array("tags" => "page:posts"));
?>
	<url>
		<loc><?= SITE_URL ?>/nyheder</loc>
		<lastmod><?= date("Y-m-d", strtotime($item["modified_at"])) ?></lastmod>
		<changefreq>daily</changefreq>
		<priority>1</priority>
	</url>
<?
// POSTS
$items = $IC->getItems(array("itemtype" => "post", "status" => 1)); 
foreach($items as $item):
?>
	<url>
		<loc><?= SITE_URL ?>/nyheder/<?= $item["sindex"] ?></loc>
		<lastmod><?= date("Y-m-d", strtotime($item["modified_at"])) ?></lastmod>
		<changefreq>daily</changefreq>
		<priority>1</priority>
	</url>
<? endforeach; ?>
<?
// ARTICLE MAINPAGE
$item = $IC->getItem(array("tags" => "page:articles"));
?>
	<url>
		<loc><?= SITE_URL ?>/artikler</loc>
		<lastmod><?= date("Y-m-d", strtotime($item["modified_at"])) ?></lastmod>
		<changefreq>daily</changefreq>
		<priority>1</priority>
	</url>
<?
// ARTICLES
$items = $IC->getItems(array("itemtype" => "article", "status" => 1)); 
foreach($items as $item):
?>
	<url>
		<loc><?= SITE_URL ?>/artikler/<?= $item["sindex"] ?></loc>
		<lastmod><?= date("Y-m-d", strtotime($item["modified_at"])) ?></lastmod>
		<changefreq>daily</changefreq>
		<priority>1</priority>
	</url>
<? endforeach; ?>
<?
// WISHLIST PAGE
$item = $IC->getItem(array("tags" => "page:wishlist"));
?>
	<url>
		<loc><?= SITE_URL ?>/ønskeseddel</loc>
		<lastmod><?= date("Y-m-d", strtotime($item["modified_at"])) ?></lastmod>
		<changefreq>daily</changefreq>
		<priority>1</priority>
	</url>
</urlset>