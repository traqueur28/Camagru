<?php
	function sendHttpResponse($code, $response) {
		http_response_code($code);
		header('Content-Type: application/json');
		echo json_encode($response);
		exit;
	}
?>