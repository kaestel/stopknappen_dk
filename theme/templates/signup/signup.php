<?php
global $action;
global $model;


$IC = new Items();
$page_item = $IC->getItem(array("tags" => "page:signup", "status" => 1, "extend" => array("user" => true, "tags" => true, "mediae" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

// in case of signup failure, empty password field
$model->setProperty("password", "value", "");

?>
<div class="scene signup i:signup">

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


		<?= $HTML->articleInfo($page_item, "/deltag", [
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
	<h1>Opret en konto og deltag i udviklingen af Stopknappen</h1>
<? endif; ?>

	<?= $model->formStart("tilmelding", array("class" => "signup labelstyle:inject")) ?>
		<?= $model->input("maillist", array("type" => "hidden", "value" => 1)); ?>
		<?= $model->input("maillist_name", array("type" => "hidden", "value" => "Nysgerrig")); ?>

		<?= $HTML->serverMessages() ?>

		<fieldset>
			<?= $model->input("nickname", array("label" => "Dit offentlige brugernavn", "value" => "Anonym", "required" => true, "hint_message" => "Indtast dit offentlige brugernavn. Der er ikke noget galt med at være anonym.", "error_message" => "Det indtastede er ikke en gyldigt.")); ?>
			<?= $model->input("email", array("label" => "Din email", "required" => true, "hint_message" => "Indtast din email-adresse.", "error_message" => "Det indtastede er ikke en gyldig email-adresse.")); ?>
			<?= $model->input("password", array("hint_message" => "Indtast dit nye kodeord - eller lad feltet være tomt, så genererer vi et til dig.", "error_message" => "Dit password skal være mellem 8 og 20 tegn.")); ?>
			<?= $model->inputRobot(array("hint_message" => "Vis at du ikke er en robot", "error_message" => "Er du en robot? Dette skridt er desværre nødvendigt for at modvirke robot tilmeldinger.")); ?>
			<?= $model->input("terms", array("label" => "Jeg accepterer <a href=\"/vilkaar\" target=\"_blank\">vilkår</a> for stopknappen.dk", "hint_message" => "Indtast dit nye kodeord - eller lad feltet være tomt, så genererer vi et til dig.", "error_message" => "Dit password skal være mellem 8 og 20 tegn.")); ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Opret konto", array("class" => "primary", "wrapper" => "li.signup")) ?>
		</ul>
	<?= $model->formEnd() ?>

</div>
