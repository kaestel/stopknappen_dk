<?php
global $IC;
global $action;
global $itemtype;

$selected_tag = urldecode($action[1]);
$items = $IC->getItems(array("itemtype" => $itemtype, "status" => 1, "tags" => "about:".$selected_tag, "order" => "position ASC", "extend" => array("tags" => true, "readstate" => true)));

?>

<div class="scene articles tag i:scene">
	<h1>Artikler <br />om <?= $selected_tag ?></h1>

<? if($items): ?>
	<ul class="items articles i:articleMiniList">
		<? foreach($items as $item):
			$media = $IC->sliceMedia($item); ?>
		<li class="item article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/Article"
			data-readstate="<?= $item["readstate"] ?>"
			>

			<ul class="tags">
			<? if($item["tags"]):
				$editing_tag = arrayKeyValue($item["tags"], "context", "editing");
				if($editing_tag !== false): ?>
				<li class="editing" title="Denne artikel redigeres stadig"><?= $item["tags"][$editing_tag]["value"] == "true" ? "Redigeres" : $item["tags"][$editing_tag]["value"] ?></li>
				<? endif; ?>
				<li><a href="/artikler">Alle artikler</a></li>
				<? foreach($item["tags"] as $item_tag): ?>
					<? if($item_tag["context"] == "about"): ?>
				<li itemprop="articleSection"><a href="/artikler/tag/<?= urlencode($item_tag["value"]) ?>"><?= $item_tag["value"] ?></a></li>
					<? endif; ?>
				<? endforeach; ?>
			<? endif; ?>
			</ul>

			<h3 itemprop="headline"><a href="/artikler/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h3>

			<ul class="info">
				<li class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", strtotime($item["published_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($item["published_at"])) ?></li>
				<li class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", strtotime($item["modified_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($item["published_at"])) ?></li>
				<li class="author" itemprop="author"><?= $item["user_nickname"] ?></li>
				<li class="main_entity" itemprop="mainEntityOfPage"><?= SITE_URL."/artikler/".$item["sindex"] ?></li>
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

<? else: ?>

	<h2>Teknologi er tydeligvis ikke svaret på alting</h2>
	<p>
		Vi kunne ikke finde den angivne artikel.
	</p>

<? endif; ?>

</div>