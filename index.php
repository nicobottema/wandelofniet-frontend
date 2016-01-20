<?php
session_start();

$apiHost = "localhost";
$apiPort = "3000";

$page = "login";


if(isset($_SESSION["user"])) {
	$page = "step1";
	
	if(isset($_GET["p"])) {
		switch($_GET["p"]) {
			case "logout":
				session_unset();
				session_destroy();
				$page = "login";
				break;
			case "step1":
			case "step2":
			case "step3":
			case "alt":
			case "planwalk":
			case "movie":
				$page = $_GET["p"];
				break;
		}
	}
} else {
if(isset($_GET["p"])) {
		switch($_GET["p"]) {
			case "login":
			case "register":
				$page = $_GET["p"];
				break;
		}
	}
}

include("include/header.inc.php");
include("pages/$page.inc.php");
include("include/footer.inc.php");

?>