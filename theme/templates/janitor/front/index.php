<?php

$IC = new Items();
$qnas = $IC->getItems(array("itemtype" => "qna", "extend" => true));

?>
<div class="scene front">
	<h1><?= SITE_NAME ?></h1>


	<h2>Janitor</h2>
	<p>
		Stopknappen er bygget på <a href="http://janitor.parentnode.dk" target="_blank">Janitor</a>
		- og Janitor er bygget til Stopknappen.
	</p>

	<?= $JML->listUserTodos() ?>

	<?= $JML->listOpenQuestions() ?>

</div>