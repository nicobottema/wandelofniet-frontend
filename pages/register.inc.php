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
<div class="small-content col-md-4 col-md-push-4 text-middle small-frame">
	<div class="row">
		<div class="col-md-12 login-form">
			<form method="POST" class="center" autocomplete="off">
				<table>
					<tr>
						<td class="err-msg">
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
							<input type="email" name="e_mail" placeholder="Email" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" name="password" placeholder="Password" />
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
</script>