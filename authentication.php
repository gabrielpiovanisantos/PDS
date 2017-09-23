<!DOCTYPE html>

<?php
	include('class/connection.php');
?>

<html>
<head>
	<title>Redirecting...</title>
</head>

<body>

	<script>
		function success () {
			setTimeout("window.location='painel.php'", 500);
		}

		function failure () {
			setTimeout("window.location='login.html'", 3000);
		}
	</script>
</body>
</html>

<?php
	$email = $_POST['inputEmail'];
	$password = $_POST['inputPassword'];
	$sql = "SELECT * FROM users WHERE email = '$email' AND pass = '$password'";
	$res = mysqli_query($conn, $sql);

	if (mysqli_num_rows($res)) {
		session_start();
		$_SESSION['email'] = $email;
		$_SESSION['password'] = $password;

		echo "<script>success()</script>";
	}
	else {
		echo "<center>Nome de usuário ou senha inválidos!";
		echo "<br>Redirecionando...";
		echo "<script>failure()</script>";
	}
?>
