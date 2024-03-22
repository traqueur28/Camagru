<?php
	require_once('tools/sendHttpResponse.php');
	require_once('tools/connectDataBase.php');

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
		// Connect to DB
		$conn = connectDataBase();

		$query = "SELECT * FROM utilisateurs WHERE email='$email' or nom='$username'";
		$res = pg_query($conn, $query);
		if (pg_num_rows($res) > 0) {
			// Check User exist
			error_log("Register.php : Already Exist");
			$response = array(
				"success" => false,
				"message" => "ErrorUserAlreadyUsed"
			);
			sendHttpResponse(400, $response);
		}
		// doesn't exist -> create new user + good response
		error_log("register.php : add user");
		$password = password_hash($password, PASSWORD_DEFAULT);
		$query = "INSERT INTO utilisateurs (nom, pwd, email) VALUES ('$username', '$password', '$email');";
		$res = pg_query($conn, $query);
		$response = array(
			"success" => true, 
			"message" => "SuccessRegister"
		);
		sendHttpResponse(200, $response);
	}


	function checkInput($str, $minLen, $maxLen, $majNum) {
		if (ctype_alnum($str)
		 && strlen($str) <= $maxLen && strlen($str) >= $minLen
		 && preg_match_all('/[A-Z]/', $str) >= $majNum
		 && preg_match_all('/[0-9]/', $str) >= $majNum)
			return 1;
		return 0;
	}
?>