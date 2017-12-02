<?php
	header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

	$notificationCode = $_POST['notificationCode'];

	echo $notificationCode;
?>
