<?php
	function connectDataBase() {
		$host = "camagru-postgres-1";
		$port = $_ENV['DB_PORT'];
		$dbname = $_ENV['DB_NAME'];
		$user = $_ENV['DB_USER'];
		$password = $_ENV['DB_PASSWORD'];
		$connection_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
		
		$conn = pg_connect($connection_string);
		if (!$conn) {
			error_log("Error register.php: DB access");
			$response = array(
				"success" => false,
				"message" => "ErrorAccessDataBase"
			);
			sendHttpResponse(400, $response);
		}
		return $conn;
	}
?>