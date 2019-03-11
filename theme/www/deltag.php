<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$model = new User();


$page->bodyClass("signup");
$page->pageTitle("Nysgerrig?");


if(is_array($action) && count($action)) {

	// /deltag/kvittering (user just signed up)
	if($action[0] == "kvittering") {

		$page->page(array(
			"templates" => "signup/receipt.php"
		));
		exit();
	}

	// /deltag/bekraeft/email|mobile/#email|mobile#/#verification_code#
	else if($action[0] == "bekraeft" && count($action) == 4) {

		$username = $action[1];
		$verification_code = $action[2];

		if($model->confirmUsername($username, $verification_code)) {

			// redirect to leave POST state
			header("Location: /deltag/bekraeft/kvittering");
			exit();

		}
		else {

			// redirect to leave POST state
			header("Location: /deltag/bekraeft/fejl");
			exit();

		}
		exit();
	}
	else if($action[0] == "bekraeft" && $action[1] == "kvittering") {

		$page->page(array(
			"templates" => "signup/confirmed.php"
		));
		exit();
	}
	else if($action[0] == "bekraeft" && $action[1] == "fejl") {

		$page->page(array(
			"templates" => "signup/confirmation_failed.php"
		));
		exit();
	}

	// /deltag/tilmelding
	else if($action[0] == "tilmelding" && $page->validateCsrfToken()) {

		// create new user
		$user = $model->newUser(array("newUser"));

		// successful creation
		if(isset($user["user_id"])) {

			// redirect to leave POST state
			header("Location: kvittering");
			exit();

		}

		// user exists
		else if(isset($user["status"]) && $user["status"] == "USER_EXISTS") {
			message()->addMessage("Beklager, serveren siger at du husker dårligt! <br />(Ja, den er lidt grov, men den har nok ret)", array("type" => "error"));
		}
		// something went wrong
		else {
			message()->addMessage("Beklager, serveren siger NEJ! <br />(Den siger ikke noget om hvorfor)", array("type" => "error"));
		}

	}

	// /deltag/afmeld
	// post email + newsletter
	else if($action[0] == "afmeld" && $page->validateCsrfToken()) {

		// TODO

	}

}

// plain signup directly
// /deltag
$page->page(array(
	"templates" => "signup/signup.php"
));

?>
