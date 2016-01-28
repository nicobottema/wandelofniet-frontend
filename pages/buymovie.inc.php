<?php
	// var_dump($_SESSION["user"]->_id);
	// die();
	$fields = array(
		'description' => urlencode($_GET['id']),
		'amount' => 9.95,
		'user_id' => $_SESSION["user"]->_id
		
	);

	$fields_string = "";
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://".$apiHost . ":" . $apiPort . "/users/transaction");
	curl_setopt($ch, CURLOPT_POST, count($fields));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	// var_dump($output);
	// die();
	$json = json_decode($output);
	//var_dump($json);
//	die();
	if($json->success) {
		?>
		<html>
			<h2> Bedankt voor de aankoop </h2>
		</html>
		<script type="text/javascript">
			
		</script>
		<?php
	} else {
		$error = $json->message;
		echo $error;
	}
?>