<?php
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
			error_log("login.php 'POST' : ");

			// Get POST content
			$postData = file_get_contents('php://input');
			$data = json_decode($postData, true);
			$login = $data["login"];
			$password = $data["password"];

			error_log("login.php Alpha");

			// Data processing
			$host = "camagru-postgres-1";
			$port = $_ENV['DB_PORT'];
			$dbname = $_ENV['DB_NAME'];
			$user = $_ENV['DB_USER'];
			$password = $_ENV['DB_PASSWORD'];
			$connection_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
			
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
			error_log("Connexion REUSSIS");
			// TODO player exist? + connected

				
			// Answer
			$response = array(
				"success" => true, 
				"message" => "Connexion réussie bien jouer!"
			);
			header('Content-Type: application/json');
			echo json_encode($response);
	} else {
		error_log("Request != POST");
		error_log($_SERVER["REQUEST_METHOD"]);
	}
?>
