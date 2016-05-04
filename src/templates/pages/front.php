<?php
$IC = new Items();

$page_item = $IC->getItem(array("tags" => "page:front", "extend" => array("user" => true, "mediae" => true)));
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
		<p class="time"><a href="/artikler/det-er-paa-tide">er det på tide</a></p>
		<p class="wake"><span class="s1">at</span> <span class="s2">vågne</span> <span class="s3">og</span></p>
		<p class="realize">indse</p>

		<h2 class="means">at midlet</h2>
		<p class="tyrant"><span class="s1">er blevet</span> <span class="s2">en tyran</span></p>
		<p class="goal"><span class="s1">og</span> <span class="s2">målet</span> <span class="s3">er</span></p>
		<h3 class="forgotten">glemt</h3>
		<p class="bills">i stakken af regninger</p>

		<p class="busy">vi har så travlt</p>
		<p class="idleness"><span class="s1">at</span> <span class="s2">stilstand</span></p>
		<h2 class="safety"><span class="s1">er</span> <span class="s2">tryghed</span></h2>
		<p class="luxery"><span class="s1">og tryghed er</span> <span class="s2">en luksus</span></p>
		<p class="cost"><span class="s2">som koster os</span></p> 
		<h3 class="everything">alt</h3>

		<p class="content">tilfredse</p>
		<p class="sheep"><span class="s1">som mættede</span> <span class="s2">får</span></p>
		<p class="nothing"><span class="s1">men</span> <span class="s2"><a href="/artikler/intet-er-vores">intet er vores</a></span></p>
		<p class="except">bortset fra</p>
		<h3 class="ability">evnen</h3>
		<p class="to_think">til at tænke selv</p>
	</div>


<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMedia($page_item); ?>
	<div class="article i:article" itemscope itemtype="http://schema.org/Article">

		<? if($media): ?>
		<div class="image item_id:<?= $page_item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; ?>

		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>

		<? if($page_item["subheader"]): ?>
		<h2 itemprop="alternativeHeadline"><?= $page_item["subheader"] ?></h2>
		<? endif; ?>

		<ul class="info">
			<li class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", strtotime($page_item["published_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($page_item["published_at"])) ?></li>
			<li class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", strtotime($page_item["modified_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($page_item["published_at"])) ?></li>
			<li class="author" itemprop="author"><?= $page_item["user_nickname"] ?></li>
			<li class="main_entity share" itemprop="mainEntityOfPage"><?= SITE_URL ?></li>
			<li class="publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<ul class="publisher_info">
					<li class="name" itemprop="name">stopknappen.dk</li>
					<li class="logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
						<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
						<span class="image_width" itemprop="width" content="720"></span>
						<span class="image_height" itemprop="height" content="405"></span>
					</li>
				</ul>
			</li>
			<li class="image_info" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
			<? if($media): ?>
				<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/images/<?= $page_item["item_id"] ?>/<?= $media["variant"] ?>/720x.<?= $media["format"] ?>"></span>
				<span class="image_width" itemprop="width" content="720"></span>
				<span class="image_height" itemprop="height" content="<?= floor(720 / ($media["width"] / $media["height"])) ?>"></span>
			<? else: ?>
				<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
				<span class="image_width" itemprop="width" content="720"></span>
				<span class="image_height" itemprop="height" content="405"></span>
			<? endif; ?>
			</li>
		</ul>

		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>
	</div>
<? endif; ?>


<? if($post_items): ?>
	<div class="news">
		<h2>Aktuelt</h2>
		<ul class="items articles">
		<? foreach($post_items as $item): 
			$media = $IC->sliceMedia($item); ?>
			<li class="item article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/BlogPosting"
				data-readstate="<?= $item["readstate"] ?>"
				>

				<ul class="tags">
				<? if($item["tags"]):
					$editing_tag = arrayKeyValue($item["tags"], "context", "editing");
					if($editing_tag !== false): ?>
					<li class="editing" title="This post is work in progress"><?= $item["tags"][$editing_tag]["value"] == "true" ? "Still editing" : $item["tags"][$editing_tag]["value"] ?></li>
					<? endif; ?>
					<li><a href="/nyheder">Alle nyheder</a></li>
					<? foreach($item["tags"] as $item_tag): ?>
						<? if($item_tag["context"] == "post"): ?>
					<li itemprop="articleSection"><a href="/nyheder/tag/<?= urlencode($item_tag["value"]) ?>"><?= $item_tag["value"] ?></a></li>
						<? endif; ?>
					<? endforeach; ?>
				<? endif; ?>
				</ul>

				<h3 itemprop="headline"><a href="/nyheder/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h3>

				<ul class="info">
					<li class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", strtotime($item["published_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($item["published_at"])) ?></li>
					<li class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", strtotime($item["modified_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($item["published_at"])) ?></li>
					<li class="author" itemprop="author"><?= $item["user_nickname"] ?></li>
					<li class="main_entity" itemprop="mainEntityOfPage"><?= SITE_URL."/nyheder/".$item["sindex"] ?></li>
					<li class="publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
						<ul class="publisher_info">
							<li class="name" itemprop="name">stopknappen.dk</li>
							<li class="logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
								<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
								<span class="image_width" itemprop="width" content="720"></span>
								<span class="image_height" itemprop="height" content="405"></span>
							</li>
						</ul>
					</li>
					<li class="image_info" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<? if($media): ?>
						<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/images/<?= $item["item_id"] ?>/<?= $media["variant"] ?>/720x.<?= $media["format"] ?>"></span>
						<span class="image_width" itemprop="width" content="720"></span>
						<span class="image_height" itemprop="height" content="<?= floor(720 / ($media["width"] / $media["height"])) ?>"></span>
					<? else: ?>
						<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
						<span class="image_width" itemprop="width" content="720"></span>
						<span class="image_height" itemprop="height" content="405"></span>
					<? endif; ?>
					</li>
				</ul>

				<? if($item["description"]): ?>
				<div class="description" itemprop="description">
					<p><?= nl2br($item["description"]) ?></p>
				</div>
				<? endif; ?>

			</li>
		<? endforeach; ?>
		</ul>

	</div>
<?	endif; ?>

</div>