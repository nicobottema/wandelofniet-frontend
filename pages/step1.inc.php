<div class="body_container center" style="width: 400px;">
	<form action="?p=step2" method="POST">
		<h3>Where do you want to go for your walk?</h3>
		<input type="text" name="loc" id="txtLocation" style="width: 150px" /><br />
		<br />
		<a href="?p=step2&loc=home">Around home</a><br />
		<br />
		<input type="submit" value="Next" />
	</form>
</div>

<script type="text/javascript">
	document.getElementById("txtLocation").focus();
</script>