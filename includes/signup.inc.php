<?php
	session_start();

	// para assegurar que o usuário não entrou diretamente pelo link da página sem realizar a autenticação
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include('conn.inc.php');

		// garante que o usuario não executará nenhum script malicioso no banco de dados
		$nome = mysqli_real_escape_string($conn, $_POST['nome']);
		$cnpj = mysqli_real_escape_string($conn, $_POST['cnpj']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$senha = mysqli_real_escape_string($conn, $_POST['senha']);

		// em caso de erros
		if (empty($nome) || empty($cnpj) || empty($email) || empty($senha)) {
			header("Location: ../index.php?signup=empty");
			exit();
		}
		else {
			$sql = "SELECT * FROM usuarios WHERE cnpj='$cnpj';";
			$res = mysqli_query($conn, $sql);
			$row = mysqli_num_rows($res);

			if ($row > 0) {
				header("Location: ../index.php?signup=invalidcnpj");
				exit();
			}
			else {
				$sql = "SELECT * FROM usuarios WHERE email='$email';";
				$res = mysqli_query($conn, $sql);
				$row = mysqli_num_rows($res);

				if ($row > 0) {
					header("Location: ../index.php?signup=invalidemail");
					exit();
				}
				else {
					// codifica a senha
					$hashSenha = password_hash($senha, PASSWORD_DEFAULT);
					// insere no banco de dados
					$sql = "INSERT INTO usuarios VALUES (default, '$cnpj', '$nome', '$email', '$hashSenha');";

					mysqli_query($conn, $sql);
					header("Location: ../index.php?signup=success");

					exit();
				}
			}
		}
	}
	else {
		header("Location: ../index.php");
		exit();
	}
?>
