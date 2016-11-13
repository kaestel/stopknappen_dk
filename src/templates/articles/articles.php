<?
global $itemtype;
global $IC;

$page_item = $IC->getItem(array("tags" => "page:articles", "extend" => array("user" => true, "mediae" => true, "tags" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

$items = $IC->getItems(array("itemtype" => $itemtype, "status" => 1, "order" => "position ASC", "extend" => array("tags" => true, "user" => true, "readstate" => true)));
	
?>
<div class="scene articles i:scene">

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


		<?= $HTML->articleInfo($page_item, "/artikler", [
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
	<h1>Artikler</h1>
<? endif; ?>

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


			<h3 itemprop="headline"><a href="/artikler/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h3>
			<h4 itemprop="alternateHeadline"><?= strip_tags($item["subheader"]) ?></h4>


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
<? endif; ?>

</div>