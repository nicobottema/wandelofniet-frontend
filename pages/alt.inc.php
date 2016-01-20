<?php
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://".$apiHost . ":" . $apiPort . "/imdb/popular");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	$json = json_decode($output);
	if(!$json->success) {
		$error = $json->message;
	} else {
		$result = $json->result;
	}
?>
<div class="body_container center" style="width: 1000px;">
	<?php if(isset($error)) echo "<br /><br />$error<br /><Br />"; ?>
	<h3>Alternative Options</h3>
	<h4>Popular Movies</h4>
	<table id="tblMovies">
		<tr>
	<?php
	$i = 0;
	foreach($result as $movie) {
		$i++;
		?>
		<td>
			<a href="?p=movie&id=<?php echo $movie->id; ?>" target="_blank">
				<table class="tblMovie">
					<tr>
						<td>
							<img src='<?php echo $movie->image; ?>'/>
						</td>
						<td align="left">
							<b><?php echo $movie->title; ?></b><br />
							<br />
							<?php echo $movie->rating; ?>
						</td>
					</tr>
				</table>
			</a>
		</td>
		<?php
		if($i % 3 == 0) {
			echo "</tr><tr>";
		}
	}
	?>
	</tr>
	</table>
</div>