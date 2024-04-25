<?php
	require_once('tools/connectDataBase.php');
	require_once('class/user.php');

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		error_log("login.php 'POST' : ");

		// Get POST content
		$postData = file_get_contents('php://input');
		$data = json_decode($postData, true);
		$login = $data["login"];
		$password = password_hash($data["password"], PASSWORD_DEFAULT);

		// Data processing
		$host = "camagru-postgres-1";
		$port = $_ENV['DB_PORT'];
		$dbname = $_ENV['DB_NAME'];
		$dbuser = $_ENV['DB_USER'];
		$dbpassword = $_ENV['DB_PASSWORD'];
		$connection_string = "host=$host port=$port dbname=$dbname user=$dbuser password=$dbpassword";
			
		error_log("connection_string : " . $connection_string);
		$conn = pg_connect($connection_string);
		error_log(print_r($conn, true));

		if (!$conn) {
			error_log("Error login.php: DB access");
			http_response_code(400);
			$response = array(
				"success" => false,
				"message" => "Error database access login"
			);
			error_log("Error DB access login.php");
			header('Content-Type: application/json');
				echo json_encode($response);
				exit;
		}
		error_log("Connexion DB REUSSIT");
		// User exist ?
			// No -> exit
		if (!User::loginUser($login, $password)) {
			$response = array(
				"succes" => false,
				"message" => "Error : User doesn't exist."
			);
			error_log("Error: User doesn't exist. login.php");
			header('Content-Type: application/json');
			echo json_encode($response);
			exit;
		}
			// Yes -> set cookies in User and _SESSION
		$authKey = bin2hex(random_bytes(16)); // Generate random authKhey
		$res = setcookie("auth", $authKey, time() + 3600, "/", "www.camagru42.fr", true, false);
		$user = new User($login);
		$user->setAuthKey($authKey);
		error_log($authKey);

		session_start();
		$_SESSION[$login] = $user;
			
		// Answer
		$response = array(
			"success" => true, 
			"message" => "SuccessLogin"
		);
		header('Content-Type: application/json');
		echo json_encode($response);
		http_response_code(200);

	} else {
		error_log("Request != POST");
		error_log($_SERVER["REQUEST_METHOD"]);
		http_response_code(400);
	}
?>
