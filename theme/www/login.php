<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$model = new User();


$page->bodyClass("login");
$page->pageTitle("Login");


if(is_array($action) && count($action)) {

	// login/glemt
	if(count($action) == 1 && $action[0] == "glemt") {

		$page->page(array(
			"templates" => "pages/forgot_password.php"
		));
		exit();
	}
	// login/glemt/kvittering
	else if(count($action) == 2 && $action[0] == "glemt" && $action[1] == "kvittering") {

		$page->page(array(
			"templates" => "pages/forgot_password_receipt.php"
		));
		exit();
	}
	// login/requestReset
	else if(count($action) == 1 && $action[0] == "requestReset" && security()->validateCsrfToken()) {

		// request password reset
		if($model->requestPasswordReset($action)) {
			header("Location: glemt/kvittering");
			exit();
		}

		// could not create reset request
		else {
			message()->addMessage("Beklager, du kan ikke nulstille koden for den angivne bruger!", array("type" => "error"));
			header("Location: glemt");
			exit();
		}
	}

}

// plain login
$page->page(array(
	"templates" => "pages/login.php"
));

?>
