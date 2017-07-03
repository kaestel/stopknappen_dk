<?
global $itemtype;
global $IC;

$page_item = $IC->getItem(array("tags" => "page:startknappen", "extend" => array("tags" => true, "comments" => true, "user" => true)));

if($page_item) {
	$this->sharingMetaData($page_item);
}

// topic items
$items = $IC->getItems(array("itemtype" => $itemtype, "status" => 1, "order" => "position ASC", "extend" => array("tags" => true, "user" => true, "readstate" => true)));

$items_read = [];
// sort items in read and not read
foreach($items as $i => $item) {
	if($item["readstate"]) {
		array_push($items_read, $items[$i]);
		unset($items[$i]);
	}
}

?>
<div class="scene start i:start">

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


	<ul class="topics">
<?	foreach($items as $item):
		$media = $IC->sliceMedia($item); ?>
		<li class="topic item_id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
			data-readstate="<?= $item["readstate"] ?>"
			>


			<?= $HTML->articleTags($item, [
				"context" => ["about"],
				"url" => "/start/tag"
			]) ?>


			<h3 class="headline"><a href="/start/<?= $item["sindex"] ?>"><?= strip_tags($item["name"]) ?></a></h3>


			<?= $HTML->articleInfo($item, "/start/".$item["sindex"], [
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


	<ul class="topics read i:articleMiniList">
<?	foreach($items_read as $item):
		$media = $IC->sliceMedia($item); ?>
		<li class="article topic item_id:<?= $item["item_id"] ?>"
			data-readstate="<?= $item["readstate"] ?>"
			>


			<?= $HTML->articleTags($item, [
				"context" => ["about"],
				"url" => "/start/tag",
			]) ?>


			<h3 class="headline"><a href="/start/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h3>

			<?= $HTML->articleInfo($item, "/start/".$item["sindex"], [
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