 <!DOCTYPE html>
 <html lang="en">
	<head>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
		<meta name="viewport" content="initial-scale=1" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/pikaday.css">
	</head>
	
	<body>
	
<?php
if(isset($_SESSION["user"])) {
	?>
	<div id="topbar">
		<div id="logged_in_area"><?php echo $_SESSION["user"]->username; ?> - <a href="?p=logout">Logout</a></div>
	</div>
	<?php
}
?>