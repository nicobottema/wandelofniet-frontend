<?php
$date = $_POST["date"];
$hour = $_POST["hour"];
$location = $_POST["loc"];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://".$apiHost . ":" . $apiPort . "/weather/forecast?location=$location&date=$date&hour=$hour");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

$json = json_decode(strtolower($output));
$weather = $json->result->weather->description;
$icon = $json->result->weather->icon;
?>
<div class="standard-content col-md-8 col-md-push-2 text-middle step1 step3 small-frame">
	<form action="?p=step3" method="POST">
		<h3>Weather Forecast (<?php echo "$date $hour:00"; ?>):</h3>
		<?php
			echo "<table class='center'><tr><td><img src='http://openweathermap.org/img/w/$icon.png' ></td><td>$weather</td></tr></table>";
		?> 
		<br />
		<a href="?p=planwalk&date=<?php echo $date; ?>&hour=<?php echo $hour; ?>&location=<?php echo $location; ?>"><span class="btn-class">Plan My Walk</span></a><br /><br />
		<a href="?p=alt"><span class="btn-class margin-left">Check Out Alternatives</span></a>
		<input type="hidden" name="loc" value="<?php echo $location; ?>" /><br />
		<br /><br />
	</form>
</div>