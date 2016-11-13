<?php
global $action;
global $IC;
global $itemtype;

$selected_tag = urldecode($action[1]);
$items = $IC->getItems(array("itemtype" => $itemtype, "status" => 1, "tags" => $itemtype.":".addslashes($selected_tag), "extend" => array("tags" => true, "user" => true, "readstate" => true, "mediae" => true)));

$categories = $IC->getTags(array("context" => $itemtype, "order" => "value"));

?>

<div class="scene posts tag i:scene">
<? if($items): ?>
	<h1>Nyheder <br />om <?= $selected_tag ?></h1>
<? else: ?>
	<h1>Nyheder</h1>
<? endif; ?>

<? if($categories): ?>
	<div class="categories">
		<ul class="tags">
			<li><a href="/nyheder">Alle nyheder</a></li>
		<? foreach($categories as $tag): ?>
			<li<?= ($selected_tag == $tag["value"] ? ' class="selected"' : '') ?>><a href="/nyheder/tag/<?= urlencode($tag["value"]) ?>"><?= $tag["value"] ?></a></li>
			<? endforeach; ?>
		</ul>
	</div>
<? endif; ?>


<? if($items): ?>
	<ul class="items articles i:articleMiniList">
		<? foreach($items as $item):
			$media = $IC->sliceMedia($item); ?>
		<li class="item article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/BlogPosting"
			data-readstate="<?= $item["readstate"] ?>"
			>


			<?= $HTML->articleTags($item, [
				"context" => [$itemtype],
				"url" => "/nyheder/tag",
				"default" => ["/nyheder", "Alle"]
			]) ?>


			<h3 itemprop="headline"><a href="/nyheder/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h3>


			<?= $HTML->articleInfo($item, "/nyheder/".$item["sindex"], [
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

<? else: ?>

	<h2>Teknologi er tydeligvis ikke svaret på alting</h2>
	<p>
		Vi kunne ikke finde den angivne nyhed.
	</p>

<? endif; ?>


</div>
