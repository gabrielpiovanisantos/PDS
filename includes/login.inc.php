<?php
	session_start();

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include('conn.inc.php');

		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$senha = mysqli_real_escape_string($conn, $_POST['senha']);

		if (empty($email) || empty($senha)) {
			header("Location: ../index.php?login=empty");
			exit();
		}
		else {
			$sql = "SELECT * FROM usuarios WHERE email='$email'";
			$res = mysqli_query($conn, $sql);
			$row = mysqli_num_rows($res);

			if ($row < 1) {
				header("Location: ../index.php?login=error");
				exit();
			}
			else {
				if ($row = mysqli_fetch_assoc($res)) {
					$senhaCorreta = password_verify($senha, $row['senha']);

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
