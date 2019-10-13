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
	<h1>Opslag om <br /><?= $selected_tag ?></h1>
<? else: ?>
	<h1>Opslag</h1>
<? endif; ?>

<? if($categories): ?>
	<div class="categories">
		<ul class="tags">
			<li><a href="/opslag">Alle opslag</a></li>
		<? foreach($categories as $tag): ?>
			<li<?= ($selected_tag == $tag["value"] ? ' class="selected"' : '') ?>><a href="/opslag/tag/<?= urlencode($tag["value"]) ?>"><?= $tag["value"] ?></a></li>
			<? endforeach; ?>
		</ul>
	</div>
<? endif; ?>


<? if($items): ?>
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

<? else: ?>

	<h2>Teknologi er tydeligvis ikke svaret på alting</h2>
	<p>
		Vi kunne ikke finde den angivne side - måske er den flygtet for at undgå verdens undergang :)
	</p>

<? endif; ?>


</div>
