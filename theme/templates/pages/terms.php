<?
global $action;
global $IC;

$page_item = $IC->getItem(array("tags" => "page:terms", "extend" => array("mediae" => true, "tags" => true)));

if($page_item) {
	$this->sharingMetaData($page_item);
}
?>
<div class="scene terms i:scene">

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


		<?= $HTML->articleInfo($page_item, "/terms", [
			"media" => $media,
			"sharing" => false
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>

	</div>



<? else:?>

	<h1>Vilkår, kager, privatliv og licenser</h1>
	<p>Vi er lige i gang med at opdatere siden – prøv igen senere.</p>

<? endif; ?>

</div>
