<?php
global $action;
global $model;


$forward_url = getVar("forward_url");
if($forward_url) {
	session()->value("login_forward", $forward_url);
}


$username = stringOr(getPost("username"));

// if username was posted and we ended up here, something went wrong
if($username) {

	// it could be that the account was not verified yet
	// - in that case, update error message
	$messages = message()->getMessages(["type" => "error"]);
	foreach($messages as $message) {
		if(preg_match("/User.+not.+verified/", $message)) {
			message()->resetMessages();
			message()->addMessage("Kontoen er ikke aktiv. Har du glemt at bekræfte din konto?", ["type" => "error"]);
			break;
		}
	}

}



$IC = new Items();
$page_item = $IC->getItem(array("tags" => "page:login", "extend" => true));

?>
<div class="scene login i:login">

<? if($page_item && $page_item["status"]): ?>
	<h1><?= $page_item["name"] ?></h1>
<? else: ?>
	<h1>Log ind</h1>
<? endif; ?>


<?	if(defined("SITE_SIGNUP") && SITE_SIGNUP): ?>
	<p>Ikke registreret endnu? <a href="<?= SITE_SIGNUP ?>">Opret din konto nu</a>.</p>
<?	endif; ?>

	<?= $model->formStart("?login=true", array("class" => "labelstyle:inject")) ?>

		<?= $HTML->serverMessages() ?>

		<fieldset>
			<?//= $model->input("username", array("type" => "string", "label" => "Email eller mobilnummer", "required" => true, "value" => $username, "pattern" => "[\w\.\-\_]+@[\w-\.]+\.\w{2,4}|([\+0-9\-\.\s\(\)]){5,18}", "hint_message" => "Du kan logge ind med enten dit mobilnummer eller din email-adresse.", "error_message" => "Det indtastede er ikke et gyldigt mobilnummer eller email-adresse.")); ?>
			<?//= $model->input("password", array("type" => "password", "label" => "password", "required" => true, "hint_message" => "Indtast din kode", "error_message" => "Din kode skal være 8-20 tegn.")); ?>
			<?= $model->input("username", array("label" => "Email eller mobilnummer", "required" => true, "value" => $username, "hint_message" => "Du kan logge ind med enten dit mobilnummer eller din email-adresse.", "error_message" => "Det indtastede er ikke et gyldigt mobilnummer eller email-adresse.")); ?>
			<?= $model->input("password", array("label" => "password", "required" => true, "hint_message" => "Indtast din kode", "error_message" => "Din kode skal være 8-20 tegn.")); ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Log ind", array("class" => "primary", "wrapper" => "li.login")) ?>
			<li class="forgot">Har du <a href="/login/glemt">glemt din kode</a>?</li>
		</ul>
	<?= $model->formEnd() ?>


<? if($page_item && $page_item["status"]): ?>
	<div class="article i:article id:<?= $page_item["item_id"] ?>" itemscope itemtype="http://schema.org/Article">

		<? if($page_item["subheader"]): ?>
		<h2 itemprop="headline"><?= $page_item["subheader"] ?></h2>
		<? endif; ?>


		<?= $HTML->articleInfo($page_item, "/login", [
			"sharing" => false
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>

	</div>

<? endif; ?>

</div>
