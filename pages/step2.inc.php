<?php
$location = (isset($_GET["loc"]) ? $_GET["loc"] : $_POST["loc"]);
?>
<div class="standard-content col-md-8 col-md-push-2 text-middle step1 step2 small-frame">
	<form action="?p=step3" method="POST" onsubmit="return validateStep2()">
		<h3>When do you want to go?</h3>
		
		<input type="text" name="date" id="datepicker"/>
		<div class="err-msg"></div>
		<h3>Starting which hour? (00 - 24)</h3>
		<input type="number" name="hour" id="txtStartingHour" min="0" max="24"/>
		<div class="err-msg1"></div>
		<br />
		<input type="submit" value="Check" />
		<input type="hidden" name="loc" value="<?php echo $location; ?>" />
	</form>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="js/pikaday.js"></script>
<script>
	var curDate = new Date();
	var picker = new Pikaday(
	{
		field: document.getElementById('datepicker'),
		firstDay: curDate.getDate(),
		format: 'MM/DD/YYYY',
		minDate: new Date(curDate.getFullYear(), curDate.getMonth(), curDate.getDate()),
		maxDate: new Date(curDate.getFullYear(), curDate.getMonth(), curDate.getDate() + 5),
		yearRange: [curDate.getFullYear(),curDate.getFullYear()]
		
	});
	
	$("#datepicker").focus();
	
	function validateStep2() {
		var boolean = true;
		if(document.getElementById("datepicker").value.length < 8) {
			$('.err-msg').text('Please enter a valid date');
			document.getElementById("datepicker").focus();
			boolean = false;
		} else {
			$('.err-msg').text('');
		}
		if(document.getElementById("txtStartingHour").value.length < 1) {
			$('.err-msg1').text('Please enter a valid starting hour');
			document.getElementById("txtStartingHour").focus();
			boolean = false;
		} else {
			$('.err-msg1').text('');
		}
		return boolean;
	}
</script>