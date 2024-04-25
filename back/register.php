<?php
	require_once('tools/sendHttpResponse.php');
	require_once('tools/connectDataBase.php');
	require_once('class/user.php');


	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		error_log("Register.php : POST");

		$postData = file_get_contents('php://input');
		$data = json_decode($postData, true);
		$username = $data["username"];
		$password = $data["password"];
		$email = $data["email"];

		if (!checkInput($username, 4, 16, 0) ||
			!checkInput($password, 8, 32, 1) ||
			!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$response = array(
					"success" => false,
					"message" => "UnvalidData"
				);
				sendHttpResponse(400, $response);
		}
		
		// Check doesn't already exist :
		if (User::isInDatabase($username)) {
			error_log("Register.php : Already Exist");
			$response = array(
				"success" => false,
				"message" => "Error: UserAlreadyUsed"
			);
			sendHttpResponse(400, $response);
			exit();
		}

		// doesn't exist -> create new user + good response
		if (!User::addInDatabase($username, $password, $email)) {
			error_log("Register.php : Error addNewUser");
			$response = array(
				"success" => false,
				"message" => "Error: AddNewUser"
			);
			sendHttpResponse(400, $response);
			exit();
		}

		// Send Mail
		//*  ----- TODO mailing ----- */
		// error_log("send mail");

		// $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

		// $message = "Merci $username pour votre inscription sur Camagru.\r\n";
		// $sendmail = mail(
		// 	$email,
		// 	"Registration CAMAGRU",
		// 	$message
		// );
		// error_log("SUB MAILING");
		// if ($sendmail) {
		// 	error_log("L'e-mail a été accepté pour la livraison.");
		// } else {
		// 	error_log("L'e-mail n'a pas été accepté pour la livraison.");
		// }
		/* ------------------------ */

		// Response
		$response = array(
			"success" => true, 
			"message" => "SuccessRegister"
		);
		sendHttpResponse(200, $response);
	}


	function checkInput($str, $minLen, $maxLen, $majNum): bool {
		if (ctype_alnum($str)
		 && strlen($str) <= $maxLen && strlen($str) >= $minLen
		 && preg_match_all('/[A-Z]/', $str) >= $majNum
		 && preg_match_all('/[0-9]/', $str) >= $majNum)
			return 1;
		return 0;
	}
?>