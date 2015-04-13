<?php
	if(!apc_exists("blabla")){
		apc_store("blabla",1);
	}
	echo "Number of visits: " . apc_fetch("blabla");
	apc_inc("blabla");
?>
<html>
<head>
<title>APC</title></head>
</html>