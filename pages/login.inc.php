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
<div class="text-middle">
	<h1>Walk Or Not</h1>
	<?php if(isset($_GET["reg"])) echo "Registration successful"; ?>
	<form method="POST"  id="login_form" class="center">
		<table style="margin-left: 25px;">
			<tr>
				<td colspan="2" align="center">
					Login
					<?php
						if(isset($error)) echo "<br /><br />$error<br /><Br />";
					?>
				</td>
			</tr>
			<tr>
				<td>
					Username
				</td>
				<td>
					<input type="text" name="username" id="txtUsername" />
				</td>
			</tr>
			<tr>
				<td>
					Password
				</td>
				<td>
					<input type="password" name="password" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<a href="?p=register">Register</a>
					<input type="submit" value="Login" style="margin-left: 130px;"/>
				</td>
			</tr>
		</table>
	</form>
</div>
	<script>
		$("#txtUsername").focus();
	</script>