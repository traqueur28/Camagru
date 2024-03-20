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
			$host = "localhost";
			$port = $_ENV['DB_PORT'];
			$dbname = $_ENV['DB_NAME'];
			$user = $_ENV['DB_USER'];
			$password = $_ENV['DB_PASSWORD'];
			$connection_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
			
			error_log("bonjour test log");
			$conn = pg_connect($connection_string);
			error_log(print_r($conn, true));
			

			if (!$conn) {
				error_log("Connexion impossible");
			} else {
				error_log("Connexion REUSSIS");
				
				// Answer
				$response = array(
					"success" => true, 
					"message" => "Connexion réussie bien jouer!"
				);
				header('Content-Type: application/json');
				echo json_encode($response);
			}
	} else {
		error_log("Request != POST");
		error_log($_SERVER["REQUEST_METHOD"]);
	}
?>
