<?php
	//Verifica se esta recebendo um POST da página “index.html”.
	//Define as credenciais(appId e appKey) da aplicação.
	$appId = "app3912951746";
	$appKey = "4C807651D0D04FF33422EFABB6C40CCE";


	//Monta a URL da chamada para o PagSeguro.
	$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/authorizations/request?appId=".$appId."&appKey=".$appKey;

	//Cria o XML que será enviado ao PagSeguro.
	$dom = new DOMDocument('1.0', 'utf-8');

	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;
	$authorization = $dom->createElement("authorizationRequest");
	$permission = $dom->createElement("permissions");
	foreach ($_POST['permissions'] as $key => $typeAuthorization) {
		$typeAuthorization = $dom->createElement("code", $typeAuthorization);
		$permission->appendChild($typeAuthorization);
	}
	$redirectURL = $dom->createElement("redirectURL", "http://localhost/PDS/pagseguro3/notification.php");
	$authorization->appendChild($redirectURL);
	$authorization->appendChild($permission);
	$dom->appendChild($authorization);
	$dom->save("teste.xml");

	//Realiza a chamada para o PagSeguro.
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml; charset=ISO-8859-1"));
	curl_setopt($curl, CURLOPT_POSTFIELDS, $dom->saveXML());
	$response = curl_exec($curl);
	$http = curl_getinfo($curl);
	//Imprime na tela o resultado da comunicação com o PagSeguro.
	echo "<b>Resultado da chamada:</b> ".$http['http_code'];
	echo "<br>";

	//Verifica se não ocorreu um Unauthorized
	if ($response == 'Unauthorized') {
		echo "<b>Ocorreu um problema na comunicação com o PagSeguro!</b>";
		echo "<br>";
		echo "<b>Retorno do PagSeguro:</b> ".$response;
		echo "<br>";
		echo "<b>Neste caso, você pode verificar os pontos abaixo:</b><br>";
		echo "<ul>";
		echo "<li>O appId (".$appId.") esta correto?</li>";
		echo "<li>O appKey (".$appKey.") esta correto?</li>";
		echo "<li>O ambiente (Produção ou Sandbox) no qual o appId e o appKey estão sendo informados esta correto?</li>";
		echo "</ul>";
		exit;
	}
	//Encerra a comunicação com o PagSeguro
	curl_close($curl);


	//Transforma o XML recebido em um objeto
	$response_obj = simplexml_load_string($response);
	//Verifica se o PagSeguro não retornou um Bad request
	if (count($response_obj -> error) > 0) {
		//Apresenta todos os erros encontrados
		echo "<ul>";
		echo "<li><b>".$value->code."</b> - ".$value->message."</li>";
		echo "</ul>";
		exit;
	}
	if (isset($response_obj->code)) {
		//Imprimindo o retorno do PagSeguro.
		echo "<b>Código de redirecionamento:</b> ".$response_obj->code;
		echo "<br>";
		echo "<b>Data da chamada:</b> ".$response_obj->date;
		echo "<br>";
		echo "<br>";
		echo "Para concluir a sua autorização clique em “Autorizar”.";
		echo "<br>";
		echo '<a  href="https://sandbox.pagseguro.uol.com.br/v2/authorization/request.jhtml?code='.$response_obj->code.'">Autorizar >>></a>';
	}
	else {
		echo "Você não selecionou as permissões da aplicação.";
		echo "<br>";
		echo "<br>";
		echo '<a  href="index.html"><<< Voltar</a>';
	}
?>
