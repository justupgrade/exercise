<?php
	$host_db = "localhost";
	$user_db = "justupgrade";
	$pass_db = "test";
	$name_db = "pagination_test";


	$connection = new mysqli($host_db, $user_db, $pass_db, $name_db);
	if($connection->connect_error) {
		die("ERROR: " . $connection->connect_error);
	}
	
	for($i = 0; $i < 1000; $i++){
		$query = "INSERT INTO test_table (name,content) VALUES ('";
		$query .= getRandomName() . "', '" . getRandomContent() . "')";
		
		if($connection->query($query)) echo "Successfully inserted data!<br>";
	}
	
	function getRandomName() {
		return getRandomString(10);
	}
	
	function getRandomContent() {
		return getRandomString(100);
	}
	
	function getRandomString($length) {
		$alfa = 'abcdefg hijklmno pqrstwuxyz ';
		$alfa_length = strlen($alfa);
		
		$out = "";
		for($i=0;$i<$length;$i++) {
			$rand = rand(0,$alfa_length-1);
			$out .= substr($alfa, $rand, 1);
		}
		return $out;
	}
?>