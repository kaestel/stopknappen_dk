<?php
global $action;
global $model;

$type = $action[1];
$username = $action[2];

?>
<div class="scene newsletter i:scene">

	<h1>Tak!</h1>
	<p>Din <?= $type ?>: <?= $username ?>, er hermed bekræftet.</p>

	<p>
		Via <a href="/janitor/admin/profile">Janitor</a> kan du opdatere din profil eller annullere din nysgerrighed,
		hvis det skulle blive nødvendigt. Dit brugernavn er din email og hvis du ikke selv har valgt et password, står 
		dét i den tilsendte email.
	</p>

	<p>Tak for din nysgerrighed - du hører fra os!</p>

</div>