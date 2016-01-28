<?php
if(isset($_POST["username"])) {
	$fields = array(
		'username' => urlencode($_POST['username']),
		'display_name' => urlencode("Anon"),
		'e_mail' => urlencode($_POST['e_mail']),
		'password' => urlencode($_POST['password'])
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
<div class="center">
<h1>Walk Or Not</h1>
	<form method="POST"  id="login_form" class="center">
		<table style="margin-left: 25px;">
			<tr>
				<td colspan="2" align="center">
					Register a new account
					<?php
						if(isset($error)) echo "<br /><br />$error<br /><Br />";
					?>
				</td>
			</tr>
			<tr>
				<td align="left">
					Username
				</td>
				<td>
					<input type="text" name="username" id="txtUsername" />
				</td>
			</tr>
			<tr>
				<td align="left">
					Email
				</td>
				<td>
					<input type="text" name="e_mail" />
				</td>
			</tr>
			<tr>
				<td align="left">
					Password
				</td>
				<td>
					<input type="password" name="password" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<a href="?p=login">Login</a>
					<input type="submit" value="Register" style="margin-left: 130px;"/>
				</td>
			</tr>
		</table>
	</form>
</div>

<script>
	$("#txtUsername").focus();
</script>