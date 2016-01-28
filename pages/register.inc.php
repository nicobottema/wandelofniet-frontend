<?php
if(isset($_POST["username"])) {
	$fields = array(
		'username' => urlencode($_POST['username']),
		'display_name' => urlencode("Anon"),
		'e_mail' => urlencode($_POST['e_mail']),
		'password' => urlencode($_POST['password1'])
	);
	$fields_string = "";
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://".$apiHost . ":" . $apiPort . "/users");
	curl_setopt($ch, CURLOPT_POST, count($fields));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	$json = json_decode($output);
	if($json->success) {
		?>
		<script type="text/javascript">
			location.href = "?p=login&reg=1";
		</script>
		<?php
	} else {
		$error = $json->message;
	}
}
?>
<div class="small-content col-md-4 col-md-push-4 text-middle small-frame">
	<div class="row">
		<div class="col-md-12 login-form">
			<form method="POST" class="center" autocomplete="off" onsubmit="return validateRegistration()">
				<table>
					<tr>
						<td class="err-msg" id="tdError">
							<?php
								if(isset($error)) echo "$error";
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
							<input type="email" name="e_mail" id="txtEmail" placeholder="Email" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" name="password1" id="txtPassword1" placeholder="Password" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" name="password2" id="txtPassword2" placeholder="Password again" />
						</td>
					</tr>
					<tr>
						<td>
							<input class="btn-class" type="submit" value="Register"/>
						</td>
					</tr>
				</table>
			</form>
			<a href="?p=login">Login</a>
		</div>
	</div>
</div>

<script>
	$("#txtUsername").focus();
	
	function validateRegistration() {
		var valid = false;
		if($("#txtUsername").val().length < 3) {
			$("#tdError").html("Please enter a username of at least 3 characters");
			$("#txtUsername").focus();
		} else if($("#txtEmail").val().length < 3 || !isEmail($("#txtEmail").val())) {
			$("#tdError").html("Please enter a valid email address");
			$("#txtEmail").focus();
		} else if($("#txtPassword1").val().length < 3) {
			$("#tdError").html("Please enter a password of at least 3 characters");
			$("#txtPassword1").focus();
		} else if($("#txtPassword1").val() != $("#txtPassword2").val()) {
			$("#tdError").html("Please make sure both passwords match");
			$("#txtPassword1").focus();
		} else {
			valid = true;
		}
			
		return valid;
	}
	
	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
</script>