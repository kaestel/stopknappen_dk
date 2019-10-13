<?
global $itemtype;
global $IC;

$page_item = $IC->getItem(array("tags" => "page:stopknappen", "extend" => array("tags" => true, "comments" => true, "user" => true)));

if($page_item) {
	$this->sharingMetaData($page_item);
}

// topic items
$items = $IC->getItems(array("itemtype" => $itemtype, "status" => 1, "order" => "position ASC", "extend" => array("tags" => true, "user" => true, "readstate" => true)));


// find introduction and conclusion
$introduction = false;
$introduction_index = arrayKeyValue($items, "name", "Introduktion");
if($introduction_index !== false) {
	// isolate introduction from other topics
	$introduction = $items[$introduction_index];
	unset($items[$introduction_index]);
}

$conclusion = false;
$conclusion_index = arrayKeyValue($items, "name", "Konklusion");
if($conclusion_index !== false) {
	// isolate conclution from other topics
	$conclusion = $items[$conclusion_index];
	unset($items[$conclusion_index]);
}

?>
<div class="scene stop i:stop">

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


		<?= $HTML->articleInfo($page_item, "/stop", [
			"media" => $media
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>

	</div>

<? else: ?>

	<h1>Stopknappen</h1>

<? endif; ?>


	<? if($introduction): ?>
	<ul class="topics i:articleMiniList">
		<li class="article topic introduction item_id:<?= $introduction["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
			data-readstate="<?= $introduction["readstate"] ?>"
			>

			<?= $HTML->articleTags($introduction, [
				"context" => ["about"],
				"url" => "/stop/tag"
			]) ?>

			<h3 class="headline"><a href="/stop/<?= $introduction["fixed_url_identifier"] ?>"><?= strip_tags($introduction["name"]) ?></a></h3>

			<?= $HTML->articleInfo($introduction, "/stop/".$introduction["fixed_url_identifier"], [
				"media" => $media
			]) ?>

			<? if($introduction["description"]): ?>
			<div class="description" itemprop="description">
				<p><?= nl2br($introduction["description"]) ?></p>
			</div>
			<? endif; ?>

		</li>
	</ul>
	<? endif; ?>


	<ul class="topics i:articleMiniList">
	<? foreach($items as $item):
		$media = $IC->sliceMediae($item); ?>
		<li class="article topic item_id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
			data-readstate="<?= $item["readstate"] ?>"
			>

			<?= $HTML->articleTags($item, [
				"context" => ["about"],
				"url" => "/stop/tag"
			]) ?>

			<h3 class="headline"><a href="/stop/<?= $item["fixed_url_identifier"] ?>"><?= strip_tags($item["name"]) ?></a></h3>

			<?= $HTML->articleInfo($item, "/stop/".$item["fixed_url_identifier"], [
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


	<? if($conclusion): ?>
	<ul class="topics i:articleMiniList">
		<li class="article topic conclusion item_id:<?= $conclusion["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
			data-readstate="<?= $conclusion["readstate"] ?>"
			>

			<?= $HTML->articleTags($conclusion, [
				"context" => ["about"],
				"url" => "/stop/tag"
			]) ?>

			<h3 class="headline"><a href="/stop/<?= $conclusion["fixed_url_identifier"] ?>"><?= strip_tags($conclusion["name"]) ?></a></h3>

			<?= $HTML->articleInfo($conclusion, "/stop/".$conclusion["fixed_url_identifier"], [
				"media" => $media
			]) ?>

			<? if($conclusion["description"]): ?>
			<div class="description" itemprop="description">
				<p><?= nl2br($conclusion["description"]) ?></p>
			</div>
			<? endif; ?>

		</li>
	</ul>
	<? endif; ?>

</div>