<?php
/*
 * Napisać stronę która po podaniu adresu obrazka zwróci
	ten obrazek z nałożonym tekstem „Coders Lab” w 
	prawym dolnym rogu.
 */

	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(isset($_POST['img_url'])) {
			$url = $_POST['img_url'];
			//find out type of image:
			$img = imagecreatefromjpeg($url);
			$str = "Coders Lab";
			$px = (imagesx($img) - 7.5*strlen($str));
			$py = (imagesy($img) - 15);
			imagestring($img, 3, $px, $py, $str,null);
			Header('Content-type: image/jpeg');
			imagejpeg($img);
		}
	}
?>

<html>
<head>
<title>image test</title>
</head>
<body>
	<form method='post'>
		<input type='text' name='img_url'>
		<input type='submit' value='Go'>
	</form>
</body>
</html>