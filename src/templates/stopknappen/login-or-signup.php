<?php
$IC = new Items();

$page_item = $IC->getItem(array("tags" => "page:stopstart", "extend" => array("comments" => true, "tags" => true, "mediae" => true)));

if($page_item) {
	$this->sharingMetaData($page_item);
}
// overwrite article title
$this->pageTitle("STOP / START");
?>
<div class="scene buttons i:buttons">

	<div class="intro"></div>


<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMedia($page_item); ?>
	<div class="article i:article id:<?= $page_item["item_id"] ?>" itemscope itemtype="http://schema.org/Article">

		<? if($media): ?>
		<div class="image item_id:<?= $page_item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; ?>


		<?= $HTML->articleTags($page_item, [
			"context" => false
		]) ?>


		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>

		<? if($page_item["subheader"]): ?>
		<h2 itemprop="alternativeHeadline"><?= $page_item["subheader"] ?></h2>
		<? endif; ?>


		<?= $HTML->articleInfo($page_item, "/knapperne", [
			"media" => $media,
			"sharing" => false
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>

		<?= $HTML->frontendComments($page_item, "/janitor/admin/page/addComment") ?>

	</div>
<? endif; ?>

</div>
