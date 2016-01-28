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

<div class="standard-content col-md-8 col-md-push-2 text-middle single-movie">
	<div class="buy-movie">
		<form action="?p=step3" method="POST">
			<a href="?p=buymovie&id=<?php echo $_GET['id']; ?>"><div class="btn-class" style="float: right; padding: 10px 15px 10px 15px;">$ 9,95</div></a>
		</form>
	</div>
	<div class="row">
		<div class="title">
			<h3><?php echo $movie->title ?></h3>
		</div>
	</div>
	<div class="row movie-details">
		<div class="col-md-4 img">
			<img src="<?php echo $movie->image ?>" width="200" align="left" />
		</div>
		<div class="col-md-8 text">
			<div class="movie_details">
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
		</div>
	</div>
</div>