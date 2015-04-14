<?php
	function __autoload($name) {
		include "classes/" . $name . ".php";
	}
	
	$set = new PointSet();
	
	$set->add(new Point(1,1));
	$set->add(new Point(3,3));
	$set->add(new Point(9,9));
	
	echo "Total count: " . $set->count() . "<br>";
	echo "Area count: (0,0) -> (5,5): " . $set->countFromArea(new Point(0,0), new Point(5,5));
	echo "<hr>";
	
	print_r($set->sortPoints());
	
	
	// /(\S + \s . + \n) {2,} /m 
	//$subject = "abcdef";
	//$pattern = '/^def/';
	//preg_match($pattern, $subject);
	
	/*$adres = "imie.nazwisko@firma.com.pl";
	
	echo "adres: " . $adres . "<br>";
	
	//Imie Nazwisko:
	$array = explode("@", $adres); //imie.nazwisko, firma.com.pl
	$imieNazwisko = explode(".", $array[0]);
	$firmaIDomena = explode(".", $array[1]);
	
	echo ucfirst($imieNazwisko[0]) . " " . ucfirst($imieNazwisko[1]) . "<br>";
	echo strtoupper($firmaIDomena[0]) . " " .strtoupper($imieNazwisko[0][0]) . "." . ucfirst($imieNazwisko[1]);
	echo "<br>";
	echo ucfirst($imieNazwisko[0][0]) . ". " . ucfirst($imieNazwisko[1][0]) . ".";
	echo "<hr>";
	
	echo str_replace("com.pl", "pl", $adres);
	echo "<hr>";
	
	//25 marzec 2015
	// \d{1,2}  \d{4}
	$subject = "22 styczen 2000";
	$pattern = "/^\d{1,2} (styczen|luty|marzec|kwiecien|maj|czerwiec|lipiec|sierpien|wrzesien|pazdziernik|listopad|grudzien) \d{4}$/";
	//echo preg_match($pattern, $subject);
	
	$mailPattern = "/^[a-z]{4,}\.[a-z]{4,}@[a-z]{4,}\.[a-z]{3}\.[a-z]{2}$/";
	
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		//testDate($pattern);
		testMail($mailPattern);
	}
	
	function testMail($pattern) {
		$mail = $_POST['test'];
		if(preg_match($pattern, $mail))  {
			echo "Valid format";
		} else {
			echo "<div style='color: red'>Invalid format</div>";
		}
	}
	
	function testDate($pattern) {
		$date = trim($_POST['test']);
		//echo $date;
		if(preg_match($pattern, $date))  {
			echo "Valid format";
		} else {
			echo "<div style='color: red'>Invalid date</div>";
		}
	}
	
	echo "<hr>";
	echo $adres;
	
	$imie = [];

	preg_match("/^(?P<imie>[a-z]+)\.(?P<nazwisko>[a-z]+)@(?P<firma>[a-z]+)\.(?P<domena>[a-z]+)\.(?P<ending>[a-z]+)/", $adres, $imie);
	var_dump($imie);
	echo "<hr>";
	
	//preg_grep zlote numery
	//XXX-YYY-ZZZ
	//XYZ-XYZ-XYZ
	//XZY-ZYX-YXZ 
	
	echo "<hr>";
	
	//pattern, input
	$numbers = ["123123123", "111111111", "123456789"];
	$pattern1 = '/(\d{3})\1{2}/';
	$goldArray = preg_grep($pattern1, $numbers);
	
	//echo preg_match($pattern1, $numbers[1]);
	
	var_dump($goldArray); */
?>
<!--
<form method='post'>
<input type='text' name='test'>
<input type='submit'>
</form>
-->