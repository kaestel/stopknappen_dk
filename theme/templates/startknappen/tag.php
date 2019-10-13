<?php
global $IC;
global $action;
global $itemtype;

$selected_tag = urldecode($action[1]);
$items = $IC->getItems(array("itemtype" => $itemtype, "status" => 1, "tags" => "about:".$selected_tag, "order" => "position ASC", "extend" => array("tags" => true, "user" => true, "readstate" => true)));

?>

<div class="scene start tag i:start">
	<h1>Startknappen <br />om <?= $selected_tag ?></h1>

<? if($items): ?>
	<ul class="topics i:articleMiniList">
<?	foreach($items as $item):
	 	$media = $IC->sliceMediae($item); ?>
		<li class="article topic item_id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
			data-readstate="<?= $item["readstate"] ?>"
			>


			<?= $HTML->articleTags($item, [
				"context" => ["about"],
				"url" => "/start/tag"
			]) ?>


			<h3 class="headline"><a href="/start/<?= $item["fixed_url_identifier"] ?>"><?= strip_tags($item["name"]) ?></a></h3>


			<?= $HTML->articleInfo($item, "/start/".$item["fixed_url_identifier"], [
				"media" => $media
			]) ?>


			<? if($item["description"]): ?>
			<div class="description" itemprop="description">
				<p><?= nl2br($item["description"]) ?></p>
			</div>
			<? endif; ?>

		</li>
<?	endforeach; ?>
	</ul>


<? else: ?>

	<h2>Teknologi er tydeligvis ikke svaret på alting</h2>
	<p>
		Vi kunne ikke finde den angivne side - måske er den flygtet for at undgå verdens undergang :)
	</p>
	<p>Tryk på <a href="/start">Startknappen</a>.</p>

<? endif; ?>

</div>