<?php
$location = (isset($_GET["loc"]) ? $_GET["loc"] : $_POST["loc"]);
?>
<div class="body_container center" style="width: 400px;">
	<form action="?p=step3" method="POST">
		<h3>When do you want to go?</h3>
		

		<input type="text" name="date" style="width: 100px" id="datepicker"/><br />
		<br />
		<h3>Starting which hour? (00 - 24)</h3>
		<input type="text" name="hour" style="width: 50px" /><br />
		<br />
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
</script>