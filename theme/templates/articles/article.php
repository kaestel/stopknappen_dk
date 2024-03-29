<?php
global $IC;
global $action;
global $itemtype;

$sindex = $action[0];
$item = $IC->getItem(array("sindex" => $sindex, "status" => 1, "extend" => array("tags" => true, "user" => true, "mediae" => true, "comments" => true, "readstate" => true)));
if($item) {
	$this->sharingMetaData($item);

	// set related pattern
	$related_pattern = array("itemtype" => $item["itemtype"], "tags" => $item["tags"], "exclude" => $item["id"]);

}
else {
	// itemtype pattern for missing item
	$related_pattern = array("itemtype" => $itemtype);
}

// add base pattern properties
$related_pattern["limit"] = 3;
$related_pattern["extend"] = array("tags" => true, "readstate" => true, "user" => true, "mediae" => true);

// get related items
$related_items = $IC->getRelatedItems($related_pattern);

?>

<div class="scene article i:scene">

<? if($item):
	$media = $IC->sliceMediae($item, "single_media"); ?>

	<div class="article i:article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
		data-csrf-token="<?= session()->value("csrf") ?>"
		data-readstate="<?= $item["readstate"] ?>"
		data-readstate-add="<?= security()->validPath("/janitor/admin/profile/addReadstate/".$item["item_id"]) ?>" 
		data-readstate-delete="<?= security()->validPath("/janitor/admin/profile/deleteReadstate/".$item["item_id"]) ?>" 
		>

		<? if($media): ?>
		<div class="image item_id:<?= $item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; ?>


		<?= $HTML->articleTags($item, [
			"context" => ["about"],
			"url" => "/artikler/tag",
			"default" => ["/artikler", "Alle artikler"]
		]) ?>


		<h1 itemprop="headline"><?= $item["name"] ?></h1>
		<h2 itemprop="alternateName"><?= $item["subheader"] ?></h2>


		<?= $HTML->articleInfo($item, "/artikler/".$item["sindex"],[
			"media" => $media,
			"sharing" => true
		]) ?>


		<div class="articlebody" itemprop="articleBody">
			<?= $item["html"] ?>
		</div>

		<? if($item["mediae"]): ?>
			<? foreach($item["mediae"] as $media): ?>
		<div class="image item_id:<?= $item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>">
			<p>Image: <a href="/images/<?= $item["item_id"] ?>/<?= $media["variant"] ?>/500x.<?= $media["format"] ?>"><?= $media["name"] ?></a></p>
		</div>
			<? endforeach; ?>
		<? endif; ?>


		<?= $HTML->frontendComments($item, "/janitor/admin/article/addComment") ?>

	</div>


<? else: ?>

	<h1>Teknologi er tydeligvis ikke svaret på alting</h1>
	<p>
		Vi kunne ikke finde den angivne side - måske er den flygtet for at undgå verdens undergang :)
	</p>

<? endif; ?>


<? if($related_items): ?>
	<div class="related">
		<h2>Relaterede artikler <a href="/artikler">(Se alle)</a></h2>

		<ul class="items articles i:articleMiniList">
<?		foreach($related_items as $item): 
			$media = $IC->sliceMediae($item, "single_media"); ?>
			<li class="item article item_id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
				data-readstate="<?= $item["readstate"] ?>"
				>


				<?= $HTML->articleTags($item, [
					"context" => ["about"],
					"url" => "/artikler/tag",
					"default" => ["/artikler", "Alle artikler"]
				]) ?>


				<h3 itemprop="headline"><a href="/artikler/<?= $item["sindex"] ?>"><?= strip_tags($item["name"]) ?></a></h3>
				<h4 itemprop="alternateHeadline"><?= strip_tags($item["subheader"]) ?></h4>


				<?= $HTML->articleInfo($item, "/artikler/".$item["sindex"],[
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
	</div>
<? endif; ?>

</div>
