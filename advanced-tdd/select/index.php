<?php
	
?>

<html>
<head>
	<title> Select Form Test</title>
	<style>
		.hidden {
			display: none;
		}
		
		.visible {
			display: block;
		}
	</style>
</head>
<body>
	<div class='hidden'>Text 1</div>
	<div class='hidden'>Text 2</div>
	<div class='hidden'>Text 3</div>
	<div class='hidden'>Text 4</div>
	<div class='hidden'>Text 5</div>
	
	<select id='select-id'>
		<option value='1'> Show Div 1 </option>
		<option value='2'> Show Div 2 </option>
		<option value='3'> Show Div 3 </option>
		<option value='4'> Show Div 4 </option>
		<option value='5'> Show Div 5 </option>
	</select>
	
<script type="text/javascript">
	var options = document.getElementsByTagName('option');
	var divs = document.getElementsByTagName('div');
	var currentDiv = null;

	for(var i=0; i < options.length; i++) {
		options[i].addEventListener('click', onOptionClick);
	}

	function onOptionClick(e) {
		if(currentDiv !== null) currentDiv.className = 'hidden';
		var id = e.target.value -1;
		currentDiv = divs[id];
		currentDiv.className = 'visible';
	}

</script>	

</body>
</html>