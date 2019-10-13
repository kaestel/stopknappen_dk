<?php
global $action;
global $IC;
global $itemtype;

$page_item = $IC->getItem(array("tags" => "page:posts", "extend" => array("user" => true, "mediae" => true, "tags" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

// get post tags for listing
$categories = $IC->getTags(array("context" => $itemtype, "order" => "value"));
$items = $IC->getItems(array("itemtype" => $itemtype, "status" => 1, "extend" => array("tags" => true, "user" => true, "readstate" => true)));

?>

<div class="scene posts i:scene">

<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMediae($page_item); ?>
	<div class="article i:article id:<?= $page_item["item_id"] ?>" itemscope itemtype="http://schema.org/Article">


		<?= $HTML->articleTags($page_item, [
			"context" => false
		]) ?>


		<? if($media): ?>
		<div class="image item_id:<?= $page_item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; ?>

		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>

		<? if($page_item["subheader"]): ?>
		<h2 itemprop="alternativeHeadline"><?= $page_item["subheader"] ?></h2>
		<? endif; ?>


		<?= $HTML->articleInfo($page_item, "/opslag", [
			"media" => $media,
			"sharing" => true
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>
	</div>
<? else:?>
	<h1>Opslag</h1>
<? endif; ?>


<? if($categories): ?>
	<div class="categories">
		<ul class="tags">
			<li class="selected"><a href="/opslag">Alle opslag</a></li>
			<? foreach($categories as $tag): ?>
			<li><a href="/opslag/tag/<?= urlencode($tag["value"]) ?>"><?= $tag["value"] ?></a></li>
			<? endforeach; ?>
		</ul>
	</div>
<? endif; ?>


<?	if($items): ?>
	<ul class="items articles i:articleMiniList">
		<? foreach($items as $item): 
			$media = $IC->sliceMediae($item); ?>
		<li class="item article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/BlogPosting"
			data-readstate="<?= $item["readstate"] ?>"
			>


			<?= $HTML->articleTags($item, [
				"context" => [$itemtype],
				"url" => "/opslag/tag",
				"default" => ["/opslag", "Alle"]
			]) ?>


			<h3 itemprop="headline"><a href="/opslag/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h3>


			<?= $HTML->articleInfo($item, "/opslag/".$item["sindex"], [
				"media" => $media
			]) ?>


			<? if($item["description"]): ?>
			<div class="description" itemprop="description">
				<p><?= nl2br($item["description"]) ?></p>
			</div>
			<? endif; ?>

		</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>

</div>
