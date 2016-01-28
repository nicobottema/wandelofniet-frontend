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
			//var_dump($_SESSION['user']->balance);
			//die();
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
			$fields = array();
			if(!($_POST['password'] == '' && $_POST['confirm'] == '')) {
				$fields = array(
					'username'=>urlencode($_SESSION['user']->username),
					'password'=>urlencode($_POST['password'])
				);
			} else {
				$fields = array(
					'username' => urlencode($_SESSION['user']->username),
					'password' => urlencode($_SESSION['user']->password)
				);
			}
			$fields_string = "";
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://".$apiHost . ":" . $apiPort . "/users/login");
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
			$json = json_decode($output);
			
			if($json->success) {
				$_SESSION["user"] = $json->user;
				header("Refresh:0");
			} else {
				$formerr = "update failed";
			}

		} else {
			$error = $json->message;
			echo $error;
			$formerr = "update failed";
			header("Refresh:0");
		}
	} else {
		$fields = array(
			'e_mail' => $_SESSION["user"]->e_mail,
			'password' => "",
			'display_name' => $_SESSION["user"]->display_name,
			'balance' => $_SESSION["user"]->balance
		);
		?> 
		<div class="small-content col-md-4 col-md-push-4 text-middle">
			<h1>Edit profile</h1>
			<div class="err-msg"><?php echo $formerr ?></div>
			<form method="POST" class="login-form edit-form">
				<span>Password</span><br>
				<input class="pw" type="password" name="password" placeholder="new password"><br>
				<input class="pw" type="password" name="confirm" placeholder="Confirm new password"><br>
				<?php 

				foreach($fields as $key=>$value){
					if ($key != "password"){
						$key1 = $key;
						switch ($key){
							case 'e_mail':
								$key1="Email";
								break;
							case 'display_name':
								$key1="Display name";
								break;
							case 'balance':
								$key1="Balance";
								break;
						}
						echo "<span>$key1</span><br>";
						//echo "$value";
						?> 
						<input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>"><br>
						<?php 
					}
				}
				?>
				<input class="btn-class" type="submit" value="Save" name="submit">
			</form>	
		</div>
		<?php 
	}
?>