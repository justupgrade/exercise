<?php
	$content = file_get_contents("https://dl.dropboxusercontent.com/u/19244701/coderlab_z13.json");
	$data = json_decode($content);
	
	//name, surname, friends
	
	//echo count($data);
	
	for($i = 0; $i < count($data); $i++) {
		$person = $data[$i];
		echo $person->name->first . ", " . $person->name->last;
		echo "<br>Friends:<br>";
		
		for($j = 0; $j< count($person->friends); $j++) {
			$firend = $person->friends[$j];
			echo $firend->name;
			echo "<br>";
		}
		echo "<br>";
	}
?>