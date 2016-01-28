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
<div class="standard-content text-middle movie-collection">
	<?php if(isset($error)) echo "<br /><br />$error<br /><Br />"; ?>
	<h3>Alternative Options</h3>
	<h4>Popular Movies</h4>
	<table id="tblMovies">
		<tr>
	<?php
	$i = 0;
	foreach($result as $movie) {
		$i++;
		if ($i == 100){
			break;
		}
		?>
		<td>
			<a href="?p=movie&id=<?php echo $movie->id; ?>" target="_blank">
				<div class="row">
					<div class="col-md-3 img">
						<img src='<?php echo $movie->image; ?>'/>
					</div>
					<div class="col-md-9 text">
						<div class="title">
							<b><?php echo $movie->title; ?></b>
						</div>
						<div class="rating">
							<?php echo $movie->rating; ?>
						</div>
					</div>
				</div>
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