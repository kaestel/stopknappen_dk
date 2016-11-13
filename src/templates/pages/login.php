<?php
	
$model = new Model();
$username = stringOr(getPost("username"));
	
?>
<div class="scene login i:login">
	<h1>Log ind</h1>

<?	if(defined("SITE_SIGNUP") && SITE_SIGNUP): ?>
	<p>Ikke registreret endnu? <a href="<?= SITE_SIGNUP ?>">Opret din konto nu</a>.</p>
<?	endif; ?>

	<?= $model->formStart("?login=true", array("class" => "labelstyle:inject")) ?>

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
			<?= $model->input("username", array("type" => "string", "label" => "Email eller mobilnummer", "required" => true, "value" => $username, "pattern" => "[\w\.\-\_]+@[\w-\.]+\.\w{2,4}|([\+0-9\-\.\s\(\)]){5,18}", "hint_message" => "Du kan logge ind med enten dit mobilnummer eller din email-adresse.", "error_message" => "Det indtastede er ikke et gyldigt mobilnummer eller email-adresse.")); ?>
			<?= $model->input("password", array("type" => "password", "label" => "password", "required" => true, "hint_message" => "Indtast din kode", "error_message" => "Din kode skal være 8-20 tegn.")); ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Log ind", array("class" => "primary", "wrapper" => "li.login")) ?>
			<li class="forgot">Har du <a href="/login/glemt">glemt din kode</a>?</li>
		</ul>
	<?= $model->formEnd() ?>

</div>
