<?php
	
$model = new Model();

$this->pageTitle("Glemt kode?");
?>
<div class="scene login i:login">
	<h1>Har du glemt din kode?</h1>
	<p>Indtast din email herunder, så sender vi en email med oplysninger om hvordan du nulstiller din kode.</p>

	<?= $model->formStart("requestReset", array("class" => "labelstyle:inject")) ?>

		<?= $HTML->serverMessages(array("type" => "error")) ?>

		<fieldset>
			<?= $model->input("username", array("type" => "string", "label" => "Email", "required" => true, "pattern" => "[\w\.\-\_]+@[\w-\.]+\.\w{2,4}", "hint_message" => "Dit brugernavn er din email-adresse.", "error_message" => "Det indtastede er ikke en gyldig email-adresse.")); ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Anmod om nulstilling af kode", array("class" => "primary", "wrapper" => "li.reset")) ?>
			<li class="forgot">Tilbage til <a href="/login">log ind</a>.</li>
		</ul>
	<?= $model->formEnd() ?>

</div>
