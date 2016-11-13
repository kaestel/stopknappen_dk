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

	// /nysgerrig/kvittering (user just signed up)
	if($action[0] == "kvittering") {

		$page->page(array(
			"templates" => "signup/receipt.php"
		));
		exit();
	}

	// /nysgerrig/bekraeft/email|mobile/#email|mobile#/#verification_code#
	else if($action[0] == "bekraeft" && count($action) == 4) {

		if($model->confirmUser($action)) {


			// redirect to leave POST state
			header("Location: /nysgerrig/bekraeft/kvittering");
			exit();

		}
		else {

			// redirect to leave POST state
			header("Location: /nysgerrig/bekraeft/fejl");
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

	// /nysgerrig/tilmelding
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
			message()->addMessage("Beklager, serveren siger du enten har dårlig samvittighed eller dårlig hukommelse!", array("type" => "error"));
		}
		// something went wrong
		else {
			message()->addMessage("Beklager, serveren siger NEJ!", array("type" => "error"));
		}

	}

	// /nysgerrig/afmeld
	// post email + newsletter
	else if($action[0] == "afmeld" && $page->validateCsrfToken()) {

		// TODO

	}

}

// plain signup directly
// /curious
$page->page(array(
	"templates" => "signup/signup.php"
));

?>
