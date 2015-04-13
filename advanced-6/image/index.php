<?php
/*
 * Napisać stronę która po podaniu adresu obrazka zwróci
	ten obrazek z nałożonym tekstem „Coders Lab” w 
	prawym dolnym rogu.
 */

	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(isset($_POST['img_url'])) {
			$url = $_POST['img_url'];
			//find out the type:
			$pos = strrpos($url, ".");
			$type = substr($url, $pos+1);
			
			$logo = imagecreatefrompng("logo.png");

			//load image
			if($type = "jpg") $img = imagecreatefromjpeg($url);
			elseif($type = "gif") $img = imagecreatefromgif($url);
			//edit image
			if($img) {
				$str = "Coders Lab";
				$px = (imagesx($img) - 7.5*strlen($str));
				$py = (imagesy($img) - 15);
				imagestring($img, 5, $px, $py, $str,null);
				
				imagecopymerge($img, $logo, imagesx($img)-imagesx($logo), imagesy($img)-imagesy($logo), 0, 0, imagesx($logo), imagesy($logo), 25);
			}
			
			//send to browser
			if($img && $type = "jpg") {
				//Header('Content-type: image/jpeg');
				//$file = imagejpeg($img);
				file_put_contents('filename.jpeg',imagejpeg($img));
				echo "<a href='filename.jpeg'>Download File </a>";
			} elseif($img && $type="gif") {
				//Header('Content-type: image/gif');
				//$file = imagegif($img);
				file_put_contents('filename.gif',imagegif($img));
				//imagegif($img);
				echo "<a href='filename.gif'>Download File </a>";
			}
			
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