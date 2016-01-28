<?php
if(isset($_POST["username"])) {
	$fields = array(
		'username' => urlencode($_POST['username']),
		'password' => urlencode($_POST['password'])
	);
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
		?>
		<script type="text/javascript">
			location.href = "?p=step1";
		</script>
		<?php
	} else {
		$error = "Username or password were wrong";
	}
}
?>
<div class="small-content col-md-4 col-md-push-4 text-middle small-frame">
	<?php if(isset($_GET["reg"])) echo "Registration successfull"; ?>
	<div class="row">
		<div class="col-md-12 login-form">
			<form method="POST" autocomplete="off" onsubmit="return validateLogin()">
				<table>
					<tr>
						<td class="error-msg" id="tdError">
							<?php
								if(isset($error)) echo "Invalid username or password";
							?>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="username" id="txtUsername" placeholder="Username" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" name="password" id="txtPassword" placeholder="Password" />
						</td>
					</tr>
					<tr>
						<td class="submit-td">
							<input class="btn-class" type="submit" value="Login">
						</td>
					</tr>
				</table>
			</form>
			<a href="?p=register">Register</a>
		</div>
	</div>
</div>
	<script>
		$("#txtUsername").focus();
		
		function validateLogin() {
			var valid = false;
			if($("#txtUsername").val() == "") {
				$("#tdError").html("Invalid username");
				$("#txtUsername").focus();
			} else if($("#txtPassword").val() == "") {
				$("#tdError").html("Invalid password");
				$("#txtPassword").focus();
			} else valid = true;
			
			return valid;
		}
	</script>