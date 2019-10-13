<?php
global $action;
global $model;

$IC = new Items();
$page_item = $IC->getItem(array("tags" => "page:verify-confirmed", "extend" => array("user" => true, "tags" => true, "mediae" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

$username = session()->value("signup_email");
session()->reset("signup_email");
?>

<div class="scene verify confirmed i:scene">

<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMediae($page_item); ?>
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

		<?= $HTML->articleInfo($page_item, "/deltag/bekraeft/kvittering", [
			"media" => $media
		]) ?>

		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= preg_replace("/{username}/", $username, $page_item["html"]) ?>
		</div>
		<? endif; ?>
	</div>
<? else:?>
	<h1>Tak!</h1>
	<p><?= $username ?> hermed bekræftet.</p>
	<p><a href="/janitor/admin/profile">Log ind</a>.</p>
<? endif; ?>

</div>