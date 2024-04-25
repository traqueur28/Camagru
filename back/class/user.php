<?php
require_once('tools/connectDataBase.php');
/*
function:
	__construct();
	__destruct();
	updateUsername();
	updatePassword();
	updateEmail();
	getter for each attribut
	setter for each attribut
*/

/*
	Check and add user in DB

*/

class User{
	/* Variable */
	private $username;
	private $authKey;

	/* Public */
	public function __construct($username) {
		$this->username = $username;
	}

	public function setAuthKey($authKey) {
		$this->authKey = $authKey;
	}

	// Construct -> ($username) get depusi la DB
	static public function isInDatabase($username): bool {
		if (!User::checkInput($username, 4, 16, 0))
			return 0;
		$conn = connectDataBase();
		$username = pg_escape_string($conn, $username);
		$query = "SELECT * FROM utilisateurs WHERE nom='$username'";
		$res = pg_query($conn, $query);
		if ($res && pg_num_rows($res) > 0) {
			$user = pg_fetch_assoc($res);
			if ($user["passord"] === $password)
				return 1;
		}
		return 0;
	}

	static public function addInDatabase($username, $password, $email): bool {
		if (User::isInDatabase($username))
			return 0;
		$conn = connectDataBase();
		$username = pg_escape_string($conn, $username);
    	$email = pg_escape_string($conn, $email);
		$password = password_hash($password, PASSWORD_DEFAULT);
		$query = "INSERT INTO utilisateurs (nom, pwd, email) VALUES ('$username', '$password', '$email')";
		$res = pg_query($conn, $query);
		if ($res)
			return 1;
		return 0;
	}

	static public function loginUser($login): bool {
		if (!User::checkInput($login, 4, 16, 0))
			return 0;
		$conn = connectDataBase();
		$login = pg_escape_string($conn, $login);
		$query = "SELECT * FROM utilisateurs WHERE nom='$login'";
		$res = pg_query($conn, $query);
		if ($res && pg_num_rows($res) > 0)
			return 1;
		return 0;
	}

	/* Private */

	static private function checkInput($str, $minLen, $maxLen, $majNum): bool {
		if (ctype_alnum($str)
		 && strlen($str) <= $maxLen && strlen($str) >= $minLen
		 && preg_match_all('/[A-Z]/', $str) >= $majNum
		 && preg_match_all('/[0-9]/', $str) >= $majNum)
			return 1;
		return 0;
	}
}

?>