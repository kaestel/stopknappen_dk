<?php
global $IC;
global $action;
global $itemtype;

$selected_tag = urldecode($action[1]);
$items = $IC->getItems(array("itemtype" => $itemtype, "status" => 1, "tags" => "about:".$selected_tag, "order" => "position ASC", "extend" => array("tags" => true, "user" => true, "readstate" => true)));

?>

<div class="scene articles tag i:scene">
	<h1>Artikler <br />om <?= $selected_tag ?></h1>

<? if($items): ?>
	<ul class="items articles i:articleMiniList">
		<? foreach($items as $item):
			$media = $IC->sliceMedia($item); ?>
		<li class="item article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
			data-readstate="<?= $item["readstate"] ?>"
			>


			<?= $HTML->articleTags($item, [
				"context" => ["about"],
				"url" => "/artikler/tag",
				"default" => ["/artikler", "Alle artikler"]
			]) ?>


			<h3 itemprop="headline"><a href="/artikler/<?= $item["sindex"] ?>"><?= strip_tags($item["name"]) ?></a></h3>


			<?= $HTML->articleInfo($item, "/artikler/".$item["sindex"], [
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
		Vi kunne ikke finde den angivne artikel.
	</p>

<? endif; ?>

</div>