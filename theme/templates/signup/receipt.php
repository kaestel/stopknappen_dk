<?php
global $action;
global $model;

$IC = new Items();
$page_item = $IC->getItem(array("tags" => "page:signup-receipt", "extend" => array("user" => true, "tags" => true, "mediae" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

$email = session()->value("signup_email");
session()->reset("signup_email");
?>
<div class="scene signup i:scene">
<? if($page_item && $page_item["status"] && $email): 
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


		<?= $HTML->articleInfo($page_item, "/deltag/kvittering", [
			"media" => $media
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= preg_replace("/{email}/", $email, $page_item["html"]) ?>
		</div>
		<? endif; ?>
	</div>
<? else:?>
	<h1>Kvittering</h1>
	<p>Tak for din tilmelding. Vi har sendt dig en email som du skal bruge til at aktivere din konto.</p>
	<p>For at aktivere din konto kan du enten klikke på linket i emailen, eller kopiere aktiverings-koden ind i input feltet på denne side.</p>
<? endif; ?>

<?= $model->formStart("bekraeft", ["class" => "verify_code"]) ?>

<?	if(message()->hasMessages(array("type" => "error"))): ?>
		<p class="errormessage">
<?		$messages = message()->getMessages(array("type" => "error"));
		message()->resetMessages();
		foreach($messages as $message): ?>
			<?= $message ?><br>
<?		endforeach;?>
		</p>
<?	endif; ?>

		<fieldset>
			<?= $model->input("verification_code"); ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Aktiver min konto", array("class" => "primary", "wrapper" => "li.reset")) ?>
		</ul>
<?= $model->formEnd() ?>

<?= print_r($_SESSION) ?>

</div>
