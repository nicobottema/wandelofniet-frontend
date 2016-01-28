 <!DOCTYPE html>
 <html lang="en">
	<head>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
		<meta name="viewport" content="initial-scale=1" />
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css"/>
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/pikaday.css">
	</head>
	<body>
		<div class="header">
			<div class="container header-container">
				<div class="row">
					<a href="./">
					<div class="col-md-4 info">
						<div class="logo">
							<img src="img/logo.png" alt="logo">
						</div>
						<div class="title">
							<h1>Wandel of Niet</h1>
						</div>
					</div>
					</a>
					<div class="col-md-4"></div>
					<div class="col-md-4">
								<?php
									if(isset($_SESSION["user"])) {
								?>
						<div id="topbar">
							<div id="logged_in_area"><?php echo $_SESSION["user"]->username; ?> (&euro;<?php echo number_format((float)$_SESSION['user']->balance, 2, ',', ''); ?>) - <a href="?p=logout">Logout</a></div>
						</div>
								<?php
									}
								?>
					</div>
				</div>
			</div>	
		</div>
		<div class="content">
			<div class="container content-container">
				<div class="row">
					<div class="col-md-12">
									<?php
									if(isset($_SESSION["user"])) {
									?>
						<!--<div class="sliders">
						  <div><img src="img/slider1.jpeg"></div>
						  <div><img src="img/slider2.jpeg"></div>
						</div>-->
									<?php
									}
									?>