<?php
	
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$name = $_POST['username'];
		$password = $_POST['password'];
		$msg = "";
		if($name === "test@test.com" && $password === "test") {
			$msg = "Success";
		} else {
			$msg = "Failure";
		}
	}
?>
<html>
<head>
	<title> Input Form Test</title>
</head>
<body>
	<div id='info'><?php if($msg !== "") echo $msg; ?></div>
	<form method='post'>
		<input type='text' name='username'>
		<input type='password' name='password'>
		<input type='submit' value='login'>
	</form>
</body>
</html>