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
	?>
	<div class="small-content col-md-4 col-md-push-4 text-middle small-frame">
		<div class="row">

	<?php 
	if($json->success) {
		?>
			<h2> Bedankt voor de aankoop </h2>
		<?php
	} else {
		//$error = $json->message;
		//echo $error;
		?>
			<h2>Er is iets mis gegaan. Onze excuses voor het ongemak</h2>
		<?php 
	}
	?>
			<a href="./"><div class="btn-class">Back to start</div></a>
		</div>
	</div>
?>