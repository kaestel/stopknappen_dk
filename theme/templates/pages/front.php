<?php
$IC = new Items();

$intros = $IC->getItems(array("itemtype" => "page", "tags" => "page:intro", "status" => 1, "extend" => true));
if($intros) {
	$intro = $intros[rand(0, count($intros)-1)];
}

$page_item = $IC->getItem(array("tags" => "page:front", "extend" => array("user" => true, "mediae" => true, "tags" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

$post_items = $IC->getItems(array("itemtype" => "post", "tags" => "on:frontpage", "status" => 1, "extend" => array("tags" => true, "readstate" => true, "user" => true, "mediae" => true)));

?>
<div class="scene front i:front">

	<div class="intro" itemscope itemtype="http://schema.org/CreativeWork">

		<h2 class="stop"><span>STOP</span></h2>
		<? if(isset($intro) && isset($intro["html"]) && $intro["html"]): ?>
		<div class="quote" itemprop="text">
			<?= $intro["html"] ?>
		</div>
		<? endif; ?>

	</div>


<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMediae($page_item); ?>
	<div class="article i:article" itemscope itemtype="http://schema.org/Article">

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


		<?= $HTML->articleInfo($page_item, "/", [
			"media" => $media,
			"sharing" => true
		]) ?>



		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>
	</div>
<? endif; ?>


<? if($post_items): ?>
	<div class="posts">
		<h2>Aktuelle opslag <a href="/opslag">(se alle)</a></h2>
		<ul class="items articles i:articleMiniList">
		<? foreach($post_items as $item): 
			$media = $IC->sliceMediae($item); ?>
			<li class="item article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/BlogPosting"
				data-readstate="<?= $item["readstate"] ?>"
				>

				<?= $HTML->articleTags($item, [
					"context" => ["post"],
					"url" => "/opslag/tag",
					"default" => ["/opslag", "Alle"]
				]) ?>

				<h3 itemprop="headline"><a href="/opslag/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h3>

				<?= $HTML->articleInfo($page_item, "/opslag/".$item["sindex"], [
					"media" => $media
				]) ?>

				<? if($item["description"]): ?>
				<div class="description" itemprop="description">
					<p><?= nl2br($item["description"]) ?> <a href="/opslag/<?= $item["sindex"] ?>" class="readmore">Læs mere</a>.</p>
				</div>
				<? endif; ?>

			</li>
		<? endforeach; ?>
		</ul>

	</div>
<?	endif; ?>

</div>