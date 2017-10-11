<?php
	session_start();

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include('conn.inc.php');

		// garante que o usuario não executará nenhum script malicioso no banco de dados
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$senha = mysqli_real_escape_string($conn, $_POST['senha']);

		// se não informou o email ou a senha
		if (empty($email) || empty($senha)) {
			header("Location: ../index.php?login=empty");
			exit();
		}
		else {
			$sql = "SELECT * FROM usuarios WHERE email='$email'";
			$res = mysqli_query($conn, $sql);
			$row = mysqli_num_rows($res);

			// se o email não está cadastrado
			if ($row < 1) {
				header("Location: ../index.php?login=error");
				exit();
			}
			else {
				if ($row = mysqli_fetch_assoc($res)) {
					$senhaCorreta = password_verify($senha, $row['senha']); // verifica se é a senha correta (codificada)

					// senha errada
					if ($senhaCorreta == false) {
						header("Location: ../index.php?login=error");
						exit();
					}
					elseif ($senhaCorreta == true) {
						$_SESSION['id'] = $row['id'];
						$_SESSION['nome'] = $row['nome'];
						$_SESSION['cnpj'] = $row['cnpj'];
						$_SESSION['email'] = $row['email'];
						header("Location: ../painel.php?login=success");
					}
				}
			}
		}
	}
	else {
		header("Location: ../index.php?login=error");
		exit();
	}
?>
