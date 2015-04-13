<?php 
	$content = file_get_contents("https://dl.dropboxusercontent.com/u/19244701/coderlab_z13.json");
	$data = json_decode($content);
	
	$tags = array();
	
	foreach($data as $person) {
		$personTags = $person->tags;
		//echo count($personTags) . "<br>";
		
		for($i = 0; $i < count($personTags); $i++) {
			$tags = addTag($tags, $personTags[$i]);
		}
	}
	
	//var_dump($tags);
	//
	$tags = json_encode($tags, JSON_PRETTY_PRINT);
	print_r("<pre>" . $tags . "</pre>");
	
	function addTag($tags, $tagName) {
		if(isset($tags[$tagName])) $tags[$tagName]++;		
		else $tags[$tagName] = 1;
		
		return $tags;
	}
?>