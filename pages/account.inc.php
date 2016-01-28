<?php
	if(isset($_POST["submit"])) {
		$updates = array();
		if(!isset($_POST["password"]) || !isset($_POST["confirm"])) {
			$page = $_SERVER['PHP_SELF'] . "?error=pw";
			header("Refresh: 0; url=$page");
		} else if(isset($_POST["password"]) && isset($_POST["confirm"])) {
			$updates["password"] = $_POST["password"];
		}
		if(isset($_POST["email"])) {
			$updates["email"] = $_POST["email"];
		}
		if(isset($_POST["display_name"])) {
			$updates["display_name"] = $_POST["display_name"];
		}
		if(isset($_POST["balance"])) {
			$updates["balance"] = $_POST["balance"];
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://".$apiHost . ":" . $apiPort . "/users/" . $_SESSION["user"]->_id);
		//curl_setopt($ch, CURLOPT_POST, count($updates));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($updates));
		$output = curl_exec($ch);
		curl_close($ch);
		$json = json_decode($output);

		if($json->success) {
			?>
			<html>
				<h2> Account changed </h2>
			</html>
			<?php
		} else {
			$error = $json->message;
			echo $error;
		}
	} else {
		if(isset($_GET["error"])) {
			echo "<script>error('" . $_GET["error"] . "')</script>";
		}
		$fields = array(
			'email' => $_SESSION["user"]->e_mail,
			'password' => "",
			'display_name' => $_SESSION["user"]->display_name,
			'balance' => $_SESSION["user"]->balance
		);
		echo "<html>";
		echo "<div class =\"error-message\"></div>";
		echo "<form method = \"POST\" >";
		foreach($fields as $key=>$value) {
			if($key == "password") {
				echo "<p>password: </p><input type=\"password\" name=\"password\" placeholder=\"Enter a new password\"><br>";
				echo "<p>confirm: </p><input type=\"password\" name=\"confirm\" placeholder=\"Confirm the new password\"><br>";
			} else {
				echo "<p>" . $key . ": </p><input type=\"text\" name=\"" . $key . "\" placeholder=\"" . $value . "\"><br>";
			}
		}
		echo "<p>Please fill in the things you want to change, then press save. </p><input type=\"submit\" value=\"Save\" name=\"submit\">";
		echo "</form>";
		echo "</html>";
	}
?>
<script type="text/javascript">
	function error(message) {
		if(message == 'pw') {
			$('.error-message').text('Please fill in both password fields!');
		} else {
			$('.error-message').text('An unknown error occurred, please fill in the form')
		}
	}
</script>