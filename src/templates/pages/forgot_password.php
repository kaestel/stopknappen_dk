<?php
	
$model = new Model();

$this->pageTitle("Glemt kode?");
?>
<div class="scene login i:login">
	<h1>Har du glemt din kode?</h1>
	<p>Indtast dit brugernavn herunder, så sender vi en email med oplysninger om hvordan du nulstiller din kode.</p>

	<?= $model->formStart("requestReset", array("class" => "labelstyle:inject")) ?>

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
			<?= $model->input("username", array("type" => "string", "label" => "Email", "required" => true, "pattern" => "[\w\.\-\_]+@[\w-\.]+\.\w{2,4}", "hint_message" => "Dit brugernavn er din email-adresse.", "error_message" => "Det indtastede er ikke en gyldig email-adresse.")); ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Anmod om nulstilling af kode", array("class" => "primary", "wrapper" => "li.reset")) ?>
		</ul>
	<?= $model->formEnd() ?>

</div>
