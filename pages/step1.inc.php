<div class="standard-content col-md-8 col-md-push-2 text-middle step1 small-frame">
	<div class="title">
		<h3>Where do you want to go for your walk?</h3>
	</div>
	<form action="?p=step2" method="POST" onsubmit="return validateStep1()">
		
		<input type="text" name="loc" id="txtLocation" />
		<div class="err-msg"></div>
		<br />
		<a href="?p=step2&loc=home"><div class="button">Around current location</div></a><input type="submit" value="Next" />
	</form>
</div>

<script type="text/javascript">
	document.getElementById("txtLocation").focus();
	
	function validateStep1() {
		if(document.getElementById("txtLocation").value.length < 3) {
			$('.err-msg').text("Please enter a valid location");
			document.getElementById("txtLocation").focus();
			return false;
		}
		return true;
	}
</script>