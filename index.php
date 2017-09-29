<?php
	session_start();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Nome da Aplicação</title>

	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom fonts for this template -->
	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css">

	<!-- Custom styles for this template -->
	<link href="css/agency.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
</head>

<body id="page-top">
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
		<div class="container">
			<a class="navbar-brand js-scroll-trigger" href="#page-top">Nome da Aplicação</a>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link js-scroll-trigger" href="#cadastrar">Cadastrar</a>
					</li>
					<li class="nav-item">
						<a class="nav-link js-scroll-trigger" href="#team">Sobre</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<header class="masthead">
		<div class="container">
			<div class="card-body">
				<div class="form-group" style="margin-top: 120px; width: 45%">
					<form method="post" action="includes/login.inc.php">
						<div style="font-family: Kaushan Script; color: #fed136; font-size: 30px;">
							<label>Login</label>
						</div>
						<input class="form-control" name="email" type="email" aria-describedby="email" placeholder="Email" style="margin-top: 20px">
						<input class="form-control" name="senha" type="password" aria-describedby="senha" placeholder="Senha" style="margin-top: 20px">
						<button type="submit" class="btn btn-xl js-scroll-trigger" style="margin-top: 20px;">Entrar</button>
					</form>
					<div>
						<label style="text-align: left; color: white; margin-top: 60px; font-family: 'Kaushan Script'; font-size: 35px;">Ainda não faz parte? Cadastre-se agora!</label>
					</div>
					<a class="btn btn-xl js-scroll-trigger" href="#cadastrar" style="margin-top: 5px; margin-bottom: 10px;">Cadastrar</a>
				</div>
			</div>
		</div>
	</header>

	<!-- Cadastrar -->
	<section id="cadastrar">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<h2 class="section-heading">Cadastrar</h2>
					<h3 class="section-subheading text-muted">Blá-blá-blá</h3>
					<div class="form-group signup-form">
						<form method="post" action="includes/signup.inc.php">
							<input class="form-control" name="nome" type="text" aria-describedby="nome da empresa" placeholder="Nome da Empresa" style="margin-top: 15px" required>
							<input class="form-control" name="cnpj" type="text" aria-describedby="CNPJ" placeholder="CNPJ (00.000.000/0000-00)" pattern="\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}" style="margin-top: 20px" required>
							<input class="form-control" name="email" type="email" aria-describedby="email" placeholder="Email" style="margin-top: 20px" required>
							<input class="form-control" name="senha" type="password" maxlength="20" aria-describedby="senha" placeholder="Senha (até 20 caracteres)" style="margin-top: 20px" required>
							<button type="submit" class="btn btn-xl js-scroll-trigger" style="margin-top: 30px;">Enviar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Team -->
	<section class="bg-light" id="team">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<h2 class="section-heading">Sobre</h2>
					<h3 class="section-subheading text-muted">Blá-blá-blá</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div class="team-member">
						<img class="mx-auto rounded-circle" src="img/team/1.jpg" alt="">
						<h4>Gabriel Piovani</h4>
						<p class="text-muted">Desenvolvedor</p>
						<ul class="list-inline social-buttons">
							<li class="list-inline-item">
								<a href="https://www.facebook.com/gabriel.piovani.7" target="_blank">
									<i class="fa fa-facebook"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="team-member">
						<img class="mx-auto rounded-circle" src="img/team/2.jpg" alt="">
						<h4>Isabela Salmeron</h4>
						<p class="text-muted">Desenvolvedora & Tester</p>
						<ul class="list-inline social-buttons">
							<li class="list-inline-item">
								<a href="https://www.facebook.com/isabela.salmeron.9" target="_blank">
									<i class="fa fa-facebook"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="team-member">
						<img class="mx-auto rounded-circle" src="img/team/3.jpg" alt="">
						<h4>Leonardo Zaccarias</h4>
						<p class="text-muted">Desenvolvedor & Scrum Master</p>
						<ul class="list-inline social-buttons">
							<li class="list-inline-item">
								<a href="https://www.facebook.com/leonardo.zaccarias.7" target="_blank">
									<i class="fa fa-facebook"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="team-member">
						<img class="mx-auto rounded-circle" src="img/team/4.jpg" alt="">
						<h4>Luciane Lopes</h4>
						<p class="text-muted">Desenvolvedora</p>
						<ul class="list-inline social-buttons">
							<li class="list-inline-item">
								<a href="https://www.facebook.com/lucianeslopes" target="_blank">
									<i class="fa fa-facebook"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/popper/popper.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	<!-- Plugin JavaScript -->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Contact form JavaScript -->
	<script src="js/jqBootstrapValidation.js"></script>
	<script src="js/contact_me.js"></script>

	<!-- Custom scripts for this template -->
	<script src="js/agency.min.js"></script>
</body>

</html>
