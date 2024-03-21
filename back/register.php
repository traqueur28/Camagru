<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		error_log("Register.php : POST");

		$postData = file_get_contents('php://input');
		$data = json_decode($postData, true);
		$username = data["username"];
		$password = data["password"];
		$email = data["email"];

		if (!checkInput($username, 4, 16, 0) &&
			!checkInput($password, 8, 32, 1) &&
			!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				http_response_code(400);
				$response = array(
					"success" => false,
					"message" => "Les informations fournies est incorrecte."
				);
				header('Content-Type: application/json');
				echo json_encode($response);
				exit;
			}

		// Check doesn't already exist :
		// Connect to db
		$host = "camagru-postgres-1";
		$port = $_ENV['DB_PORT'];
		$dbname = $_ENV['DB_NAME'];
		$user = $_ENV['DB_USER'];
		$password = $_ENV['DB_PASSWORD'];
		$connection_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

		$conn = pg_connect($connection_string);
		if (!$conn) {
			error_log("Error register.php: DB access");
			http_response_code(400);
			$response = array(
				"success" => false,
				"message" => "Error database access register"
			);
			header('Content-Type: application/json');
			echo json_encode($response);
			exit;
		}
		// exist -> send error
		// doesn't exist -> create new user + good response
	}


	function checkInput($str, $minLen, $maxLen, $majNum) {
		if (ctype_alnum(str)
		 && strlen($str) <= $maxLen && strlen($str) >= $minLen
		 && preg_match_all('/[A-Z]/', $str) >= $majNum
		 && preg_match_all('/[0-9]/', $str) >= $majNum)
			return 1;
		return 0;
	}
?>