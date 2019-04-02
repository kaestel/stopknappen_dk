<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$model = new User();


$page->bodyClass("verificer");
$page->pageTitle("Bekraeft konto");


// Verification flow
if($action) {

	// verificer/bekraeft
	if($action[0] == "bekraeft") {

		if (count($action) == 1 && $page->validateCsrfToken()) {
			
			$username = session()->value("signup_email");
			$verification_code = getPost("verification_code");
			
			// Verify and enable user
			$result = $model->confirmUsername($username, $verification_code);

			// user has already been verified
			if($result && isset($result["status"]) && $result["status"] == "USER_VERIFIED") {
				message()->addMessage("Din konto er allerede bekræftet! Prøv at logge ind.", array("type" => "error"));
				header("Location: /login");
				exit();
			}

			// code is valid
			else if($result) {
				header("Location: /verificer/kvittering");
				exit();
			}

			// code is not valid
			else {
				message()->addMessage("Forkert kode, prøv igen!", array("type" => "error"));
				header("Location: /verificer");
				exit();
			}
		}

		// verificer/bekraeft/#email|mobile#/#verification_code#
		else if(count($action) == 3) {
			
			$username = $action[1];
			$verification_code = $action[2];
			session()->value("signup_email", $username);

			// Confirm username returns either true, false or an object
			$result = $model->confirmUsername($username, $verification_code);

			// user has already been verified
			if($result && isset($result["status"]) && $result["status"] == "USER_VERIFIED") {
				message()->addMessage("Din konto er allerede bekræftet! Prøv at logge ind.", array("type" => "error"));
				header("Location: /login");
				exit();
			}

			// code is valid
			else if($result) {
				header("Location: /verificer/kvittering");
				exit();
			}

			// code is not valid
			else {
				// redirect to leave POST state
				header("Location: /verificer/fejl");
				exit();
			}
		}

	}

	// verificer/kvittering
	else if($action[0] == "kvittering") {

		$page->page(array(
			"templates" => "verify/confirmed.php"
		));
		exit();
	}
	// verificer/fejl
	else if($action[0] == "fejl") {

		$page->page(array(
			"templates" => "verify/confirmation_failed.php"
		));
		exit();
	}
	// verificer/senere
	else if($action[0] == "senere") {

		$page->page([
			"templates" => "verify/verify_skip.php"
		]);
		exit();
	}

}

// fallback
// /login
$page->page(array(
	"templates" => "verify/verify.php"
));

?>

