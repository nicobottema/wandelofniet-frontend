<?php
	$valid = false;
	$formerr = '';
	if(isset($_POST['submit'])) {
		if($_POST['e_mail'] == '' && $_POST['display_name'] == '' && $_POST['balance'] == '' && $_POST['password'] == '') {
			$formerr .= 'Please fill in at least one field';
		} else {
			if(!($_POST['password'] == '' && $_POST['confirm'] == '')) {
				if($_POST['password'] != $_POST['confirm']) {
					$formerr .= 'Please make sure that the password and password confirm match';
				} else {
					$valid = true;
				}
			} else {
				$valid = true;
			}
		}
	}

	if($valid) {
		$updates = array();
		if(isset($_POST["password"])) {
			$updates["password"] = $_POST["password"];
		}
		if(isset($_POST["e_mail"])) {
			$updates["e_mail"] = $_POST["e_mail"];
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
		$fields = array(
			'e_mail' => $_SESSION["user"]->e_mail,
			'password' => "",
			'display_name' => $_SESSION["user"]->display_name,
			'balance' => $_SESSION["user"]->balance
		);
		echo "<html>";
		echo "<div class =\"error-message\">$formerr</div>";
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