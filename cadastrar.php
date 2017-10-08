<?php
	session_start();
	include("includes/conn.inc.php");

	if (!isset($_SESSION['id'])) {
		header("Location: index.php");
		exit;
	}

	$msg = false;

	if (isset($_FILES['arquivo'])) {
		$novo_nome = md5(time()) . '.pdf';
		$diretorio = "upload/";

		move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome);

		$userid = $_SESSION['id'];

		$data = date("Y.m.d", time());

		$sql = "INSERT INTO boletos VALUES (default, '$userid', '$novo_nome', 'Pendente', '$data');";

		if (mysqli_query($conn, $sql)) {
			$msg = "Aquivo enviado com sucesso!";
		}
		else {
			$msg = "Falha ao enviar o arquivo";
		}

	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Upload de Boletos</title>
</head>
<body>
	<?php
		if ($msg != false) {
			echo "<p>$msg</p>";
		}
	?>

	<form action="cadastrar.php" method="post" enctype="multipart/form-data">
		<input type="file" required name="arquivo">
		<button type="submit" name="submit">Salvar</button>
	</form>
</body>
</html>
