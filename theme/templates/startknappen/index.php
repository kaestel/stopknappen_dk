<?
global $itemtype;
global $IC;

$page_item = $IC->getItem(array("tags" => "page:startknappen", "status" => 1, "extend" => array("tags" => true, "comments" => true, "user" => true)));
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

$budget = false;
$budget_index = arrayKeyValue($items, "name", "Budget");
if($budget_index !== false) {
	// isolate budet from other topics
	$budget = $items[$budget_index];
	unset($items[$budget_index]);
}
$timeline = false;
$timeline_index = arrayKeyValue($items, "name", "Tidslinje");
if($timeline_index !== false) {
	// isolate timeline from other topics
	$timeline = $items[$timeline_index];
	unset($items[$timeline_index]);
}

?>
<div class="scene start i:start">

<? if($page_item): 
	$media = $IC->sliceMediae($page_item, "single_media"); ?>
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


		<?= $HTML->articleInfo($page_item, "/start", [
			"media" => $media
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>

	</div>

<? else: ?>

	<h1>Startknappen</h1>

<? endif; ?>


	<? if($introduction): ?>
	<ul class="topics i:articleMiniList">
		<li class="article topic introduction item_id:<?= $introduction["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
			data-readstate="<?= $introduction["readstate"] ?>"
			>

			<?= $HTML->articleTags($introduction, [
				"context" => ["about"],
				"url" => "/start/tag"
			]) ?>

			<h3 class="headline"><a href="/start/<?= $introduction["fixed_url_identifier"] ?>"><?= strip_tags($introduction["name"]) ?></a></h3>

			<?= $HTML->articleInfo($introduction, "/start/".$introduction["fixed_url_identifier"], [
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
	<? endforeach; ?>
	</ul>


	<? if($budget || $timeline): ?>
	<ul class="topics i:articleMiniList">
		<? if($budget): ?>
		<li class="article topic conclusion item_id:<?= $budget["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
			data-readstate="<?= $budget["readstate"] ?>"
			>

			<?= $HTML->articleTags($budget, [
				"context" => ["about"],
				"url" => "/stop/tag"
			]) ?>

			<h3 class="headline"><a href="/stop/<?= $budget["fixed_url_identifier"] ?>"><?= strip_tags($budget["name"]) ?></a></h3>

			<?= $HTML->articleInfo($budget, "/stop/".$budget["fixed_url_identifier"], [
				"media" => $media
			]) ?>

			<? if($budget["description"]): ?>
			<div class="description" itemprop="description">
				<p><?= nl2br($budget["description"]) ?></p>
			</div>
			<? endif; ?>

		</li>
		<? endif; ?>

		<? if($timeline): ?>
		<li class="article topic conclusion item_id:<?= $timeline["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
			data-readstate="<?= $timeline["readstate"] ?>"
			>

			<?= $HTML->articleTags($timeline, [
				"context" => ["about"],
				"url" => "/stop/tag"
			]) ?>

			<h3 class="headline"><a href="/stop/<?= $timeline["fixed_url_identifier"] ?>"><?= strip_tags($timeline["name"]) ?></a></h3>

			<?= $HTML->articleInfo($timeline, "/stop/".$timeline["fixed_url_identifier"], [
				"media" => $media
			]) ?>

			<? if($timeline["description"]): ?>
			<div class="description" itemprop="description">
				<p><?= nl2br($timeline["description"]) ?></p>
			</div>
			<? endif; ?>

		</li>
		<? endif; ?>

	</ul>
	<? endif; ?>

</div>