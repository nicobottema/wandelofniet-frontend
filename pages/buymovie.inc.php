<?php
	// var_dump($_SESSION["user"]->_id);
	// die();
	$fields = array(
		'desc' => urlencode($_GET['id']),
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
		<div class="row film-message">

	<?php 
	if($json->success) {
		
		$fields = array(
			'username' => urlencode($_SESSION['user']->username),
			'password' => urlencode($_SESSION['user']->password)
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
			<h2> Thanks for your purchase. Enjoy the film! </h2>
				<?php
		} else {

				?>
			<h2>Something went wrong. Our apologies.</h2>
				<?php 
		}
	} else {

		if ($json->message == 'Account balance insufficient.'){
			echo "<h2>". $json->message . "</h2>";
		} else {
				?>
			<h2>Something went wrong. We apologize.</h2>
				<?php 
		}	
	}
	?>
			<a href="./"><div class="btn-class">Back to start</div></a>
		</div>
	</div>