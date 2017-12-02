<?php
	function get_data($url)
	{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml; charset=ISO-8859-1"));
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	$appId = "app3912951746";
	$appKey = "4C807651D0D04FF33422EFABB6C40CCE";
	$notificationCode = $_GET['notificationCode'];

	echo $notificationCode;

	$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/authorizations/notifications/".$notificationCode."?appId=".$appId."&appKey=".$appKey;

	echo $url."<br><br>";

	$xml = get_data($url);
	$xml = simplexml_load_string($xml);
	$code = $xml->code;
	$authorizerEmail = $xml->authorizerEmail;

	echo "Authorization Code: $code<br>Authorizer Email: $authorizerEmail<br>";

?>
