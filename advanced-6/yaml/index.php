<?php
	$data = file_get_contents("https://dl.dropboxusercontent.com/u/19244701/coderlab_z14.yml");
	
	$yaml = yaml_parse($data);
	//lista zestawow danych: nazwa, opis, data publikacji, publiczny?
	
	foreach($yaml as $content) {
		echo $content['name'] . ", ";
		echo $content['description'] . ", ";
		echo $content['public'] ? " PUBLIC " : " PRIVATE ";
		echo $content['release_date'];
		echo "<hr>";
	}
	
?>