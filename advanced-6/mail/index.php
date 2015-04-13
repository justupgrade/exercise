<?php
	$to = 'justupgrade@o2.pl';
	$subject = 'php-mail-test';
	$message = 'test message';
	$headers = 'From: tomasz@tomasz.com';
	
	echo "Email sent? " . mail($to,$subject,$message,$headers);
?>