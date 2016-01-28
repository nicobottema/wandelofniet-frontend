<?php
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://".$apiHost . ":" . $apiPort . "/imdb/".$_GET["id"]);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	$json = json_decode($output);
	if(!$json->success) {
		$error = $json->message;
	} else {
		$movie = $json->result;
	}
?>
<div class="body_container center" style="width: 800px; height: 500px; padding: 20px; text-align: left">
	<form action="?p=step3" method="POST">
		<a href="?p=buymovie&id=<?php echo $_GET["id"]; ?>"><div class="btn-class" style="float: right; padding: 10px 15px 10px 15px;">$ 9,95</div></a>
		<h3><?php echo $movie->title ?></h3>
		<img src="<?php echo $movie->image ?>" width="200" align="left" />
		<div id="movie_details">
			<b>Description</b>
			<p>
				<?php echo $movie->desc ?>
			</p>
			
			<b>Director<?php echo (count($movie->directors) > 1 ? "s" : ""); ?></b>
			<p>
				<?php 
				echo implode(", ", $movie->directors);
				?>
			</p>
			
			<b>Writer<?php echo (count($movie->writers) > 1 ? "s" : ""); ?></b>
			<p>
				<?php 
				echo implode(", ", $movie->writers);
				?>
			</p>
			
			<b>Star<?php echo (count($movie->stars) > 1 ? "s" : ""); ?></b>
			<p>
				<?php 
				echo implode(", ", $movie->stars);
				?>
			</p>
		</div>
	</form>
</div>