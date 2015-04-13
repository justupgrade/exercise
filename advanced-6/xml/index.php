<?php
//lista zajec na uni:
	$file = file_get_contents("http://www.cs.washington.edu/research/xmldatasets/data/courses/reed.xml");
	
//	$xml = simplexml_load_string($file);
	$reader = new XMLReader();
	$reader->xml($file);

	
	$doc = new DOMDocument();
	
	
	while( $reader->read() ) {
	//	echo $reader->name;
		if($reader->name == 'course' && $reader->nodeType == XMLReader::ELEMENT) {
			//echo $reader->name;
			$node = simplexml_import_dom($doc->importNode($reader->expand(), true));
			echo (string) $node->title;
			echo "<br>";
			
		}
	}
?>