<?php
$IC = new Items();

$page_item = $IC->getItem(array("tags" => "page:front", "extend" => array("user" => true, "mediae" => true, "tags" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

$post_items = $IC->getItems(array("itemtype" => "post", "tags" => "on:frontpage", "status" => 1, "extend" => array("tags" => true, "readstate" => true, "user" => true, "mediae" => true)));

?>
<div class="scene front i:front">

	<div class="intro">
		<!--
		// ny dansk tekst

		jeg tror
		vi har sovet længe nok
		nu 
		er det på tide
		at vågne og indse

		at midlet 
		er blevet en tyran
		og målet er glemt
		i stakken af regninger

		vi har så travlt
		at stilstand er tryghed
		og tryghed er en luksus
		som koster os alt

		tilfredse
		som mættede får
		men intet er vores
		bortset fra evnen til at tænke selv
		-->

		<h2 class="i_think"><a href="/artikler/jeg-tror-paa">jeg tror</a></h2>
		<p class="long"><span class="s1">vi har</span> <span class="s2">sovet</span> <span class="s3">længe nok</span></p>
		<h3 class="now">nu</h3> 
		<p class="time"><span class="s1">er det</span> <span class="s2"><a href="/artikler/det-er-paa-tide">på tide</a></span></a></p>
		<p class="wake"><span class="s1">at</span> <span class="s2">vågne</span> <span class="s3">og</span></p>
		<p class="realize">indse</p>

		<h2 class="means">at midlet</h2>
		<p class="tyrant"><span class="s1">er blevet</span> <span class="s2">en tyran</span></p>
		<p class="goal"><span class="s1">og</span> <span class="s2">målet</span> <span class="s3">er</span></p>
		<h3 class="forgotten">glemt</h3>
		<p class="bills"><span class="s1">i stakken</span> <span class="s1">af</span> <span class="s2">regninger</span></p>

		<p class="busy"><span class="s1">vi har så</span> <span class="s2">travlt</span></p>
		<p class="idleness"><span class="s1">at</span> <span class="s2">stilstand</span></p>
		<h2 class="safety"><span class="s1">er</span> <span class="s2">tryghed</span></h2>
		<p class="luxery"><span class="s1">og</span> <span class="s2">tryghed</span> <span class="s1">er en</span> <span class="s2">luksus</span></p>
		<p class="cost"><span class="s1">som</span> <span class="s2">koster</span> <span class="s3">os</span></p> 
		<h3 class="everything">alt</h3>

		<p class="content">tilfredse</p>
		<p class="sheep"><span class="s1">som mættede</span> <span class="s2">får</span></p>
		<p class="nothing"><span class="s1">men</span> <span class="s2"><a href="/artikler/intet-er-vores">intet er vores</a></span></p>
		<p class="except">bortset fra</p>
		<h3 class="ability">evnen</h3>
		<p class="to_think"><span class="s1">til at</span> <span class="s2">tænke</span> <span class="s1">selv</span></p>
	</div>


<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMedia($page_item); ?>
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
	<div class="news">
		<h2>Aktuelt <a href="/nyheder">(se alle)</a></h2>
		<ul class="items articles">
		<? foreach($post_items as $item): 
			$media = $IC->sliceMedia($item); ?>
			<li class="item article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/BlogPosting"
				data-readstate="<?= $item["readstate"] ?>"
				>


				<?= $HTML->articleTags($item, [
					"context" => ["post"],
					"url" => "/nyheder/tag",
					"default" => ["/nyheder", "All"]
				]) ?>


				<h3 itemprop="headline"><?= $item["name"] ?></h3>


				<?= $HTML->articleInfo($page_item, "/nyheder/".$item["sindex"], [
					"media" => $media
				]) ?>


				<? if($item["html"]): ?>
				<div class="articlebody" itemprop="articleBody">
					<?= $item["html"] ?>
				</div>
				<? endif; ?>

			</li>
		<? endforeach; ?>
		</ul>

	</div>
<?	endif; ?>

</div>