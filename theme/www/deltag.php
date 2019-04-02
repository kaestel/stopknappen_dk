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


if($action) {

	// /deltag/tilmelding
	if($action[0] == "tilmelding" && $page->validateCsrfToken()) {

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

	// /deltag/kvittering (user just signed up)
	else if($action[0] == "kvittering") {

		$page->page(array(
			"templates" => "signup/receipt.php"
		));
		exit();
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
