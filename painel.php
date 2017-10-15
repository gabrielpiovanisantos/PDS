<?php
	session_start();

	include("includes/conn.inc.php");

	// verifica se o usuario realizou o login
	if (!isset($_SESSION['id'])) {
		header("Location: index.php");
		exit;
	}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Painel</title>
	<!-- Bootstrap core CSS-->
	<link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	<!-- Custom fonts for this template-->
	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Page level plugin CSS-->
	<link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
	<!-- Navigation-->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
		<a class="navbar-brand" href="painel.php">Nome da Aplicação</a>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
					<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
						<i class="fa fa-fw fa-file"></i>
						<span class="nav-link-text">Boletos</span>
					</a>
					<ul class="sidenav-second-level collapse" id="collapseExamplePages">
						<li>
							<a href="boletos.php">Todos</a>
						</li>
						<li>
							<a href="receita.php">A receber</a>
						</li>
						<li>
							<a href="despesa.php">A pagar</a>
						</li>
						<li>
							<a href="cadastrar.php">Cadastrar</a>
						</li>
					</ul>
				</li>

				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
					<a class="nav-link" href="caixa.php">
						<i class="fa fa-fw fa-table"></i>
						<span class="nav-link-text">Fluxo de caixa</span>
					</a>
				</li>

				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
					<a class="nav-link" href="#">
						<i class="fa fa-fw fa-area-chart"></i>
						<span class="nav-link-text">Gráficos</span>
					</a>
				</li>
			</ul>

			<ul class="navbar-nav sidenav-toggler">
				<li class="nav-item">
					<a class="nav-link text-center" id="sidenavToggler">
						<i class="fa fa-fw fa-angle-left"></i>
					</a>
				</li>
			</ul>

			<ul class="navbar-nav ml-auto">
<!--
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-fw fa-bell"></i>
						<span class="d-lg-none">Notificações
							<span class="badge badge-pill badge-warning">6 New</span>
						</span>
						<span class="indicator text-warning d-none d-lg-block">
							<i class="fa fa-fw fa-circle"></i>
						</span>
					</a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
						<h6 class="dropdown-header">Notificações:</h6>
						<div class="dropdown-divider"></div>

						<a class="dropdown-item" href="#">
							<span class="text-success">
								<strong><i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
							</span>
							<span class="small float-right text-muted">11:21 AM</span>
							<div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
						</a>

						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">
							<span class="text-danger">
								<strong><i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
							</span>
							<span class="small float-right text-muted">11:21 AM</span>
							<div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
						</a>

						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">
							<span class="text-success">
								<strong><i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
							</span>
							<span class="small float-right text-muted">11:21 AM</span>
							<div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
						</a>

						<div class="dropdown-divider"></div>
						<a class="dropdown-item small" href="#">Ver todas as notificações</a>
					</div>
				</li>
-->

				<li class="nav-item">
					<a class="nav-link" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-fw fa-sign-out"></i>Sair</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#">Painel</a>
				</li>
				<li class="breadcrumb-item active">Meu Painel</li>
			</ol>

			<!-- Icon Cards-->
			<div class="row">
				<div class="col-xl-3 col-sm-6 mb-3">
					<div class="card text-white bg-primary o-hidden h-100">
						<div class="card-body">
							<div class="card-body-icon">
								<i class="fa fa-fw fa-comments"></i>
							</div>
							<div class="mr-5">26 New Messages!</div>
						</div>
						<a class="card-footer text-white clearfix small z-1" href="#">
							<span class="float-left">View Details</span>
							<span class="float-right">
								<i class="fa fa-angle-right"></i>
							</span>
						</a>
					</div>
				</div>

				<div class="col-xl-3 col-sm-6 mb-3">
					<div class="card text-white bg-warning o-hidden h-100">
						<div class="card-body">
							<div class="card-body-icon">
								<i class="fa fa-fw fa-list"></i>
							</div>
							<div class="mr-5">11 New Tasks!</div>
						</div>
						<a class="card-footer text-white clearfix small z-1" href="#">
							<span class="float-left">View Details</span>
							<span class="float-right">
								<i class="fa fa-angle-right"></i>
							</span>
						</a>
					</div>
				</div>

				<div class="col-xl-3 col-sm-6 mb-3">
					<div class="card text-white bg-success o-hidden h-100">
						<div class="card-body">
							<div class="card-body-icon">
								<i class="fa fa-fw fa-shopping-cart"></i>
							</div>
							<div class="mr-5">123 New Orders!</div>
						</div>
						<a class="card-footer text-white clearfix small z-1" href="#">
							<span class="float-left">View Details</span>
							<span class="float-right">
								<i class="fa fa-angle-right"></i>
							</span>
						</a>
					</div>
				</div>

				<div class="col-xl-3 col-sm-6 mb-3">
					<div class="card text-white bg-danger o-hidden h-100">
						<div class="card-body">
							<div class="card-body-icon">
								<i class="fa fa-fw fa-support"></i>
							</div>
							<div class="mr-5">13 New Tickets!</div>
						</div>
						<a class="card-footer text-white clearfix small z-1" href="#">
							<span class="float-left">View Details</span>
							<span class="float-right">
								<i class="fa fa-angle-right"></i>
							</span>
						</a>
					</div>
				</div>
			</div>

			<!-- Area Chart Example-->
			<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-area-chart"></i> Area Chart Example</div>
				<div class="card-body">
					<canvas id="myAreaChart" width="100%" height="30"></canvas>
				</div>
				<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
			</div>

			<div class="row">
				<div class="col-lg-8">
					<!-- Example Bar Chart Card-->
					<div class="card mb-3">
						<div class="card-header">
							<i class="fa fa-bar-chart"></i> Bar Chart Example</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-8 my-auto">
									<canvas id="myBarChart" width="100" height="50"></canvas>
								</div>
								<div class="col-sm-4 text-center my-auto">
									<div class="h4 mb-0 text-primary">$34,693</div>
									<div class="small text-muted">YTD Revenue</div>
									<hr>
									<div class="h4 mb-0 text-warning">$18,474</div>
									<div class="small text-muted">YTD Expenses</div>
									<hr>
									<div class="h4 mb-0 text-success">$16,219</div>
									<div class="small text-muted">YTD Margin</div>
								</div>
							</div>
						</div>
						<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
					</div>
				</div>
				<div class="col-lg-4">
					<!-- Example Pie Chart Card-->
					<div class="card mb-3">
						<div class="card-header">
							<i class="fa fa-pie-chart"></i> Pie Chart Example</div>
						<div class="card-body">
							<canvas id="myPieChart" width="100%" height="100"></canvas>
						</div>
						<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
					</div>
					<!-- Example Notifications Card-->
					<div class="card mb-3">
						<div class="card-header">
							<i class="fa fa-bell-o"></i> Feed Example</div>
						<div class="list-group list-group-flush small">
							<a class="list-group-item list-group-item-action" href="#">
								<div class="media">
									<img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
									<div class="media-body">
										<strong>David Miller</strong>posted a new article to
										<strong>David Miller Website</strong>.
										<div class="text-muted smaller">Today at 5:43 PM - 5m ago</div>
									</div>
								</div>
							</a>
							<a class="list-group-item list-group-item-action" href="#">
								<div class="media">
									<img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
									<div class="media-body">
										<strong>Samantha King</strong>sent you a new message!
										<div class="text-muted smaller">Today at 4:37 PM - 1hr ago</div>
									</div>
								</div>
							</a>
							<a class="list-group-item list-group-item-action" href="#">
								<div class="media">
									<img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
									<div class="media-body">
										<strong>Jeffery Wellings</strong>added a new photo to the album
										<strong>Beach</strong>.
										<div class="text-muted smaller">Today at 4:31 PM - 1hr ago</div>
									</div>
								</div>
							</a>
							<a class="list-group-item list-group-item-action" href="#">
								<div class="media">
									<img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
									<div class="media-body">
										<i class="fa fa-code-fork"></i>
										<strong>Monica Dennis</strong>forked the
										<strong>startbootstrap-sb-admin</strong>repository on
										<strong>GitHub</strong>.
										<div class="text-muted smaller">Today at 3:54 PM - 2hrs ago</div>
									</div>
								</div>
							</a>
							<a class="list-group-item list-group-item-action" href="#">View all activity...</a>
						</div>
						<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fa fa-angle-up"></i>
		</a>
		<!-- Logout Modal-->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Tem certeza que deseja sair?</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">×</span>
		</button>
					</div>
					<div class="modal-body">Clique em "Sair" se deseja encerrar a sessão atual.</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
						<form action="includes/logout.inc.php" method="post">
							<button class="btn btn-primary" type="submit">Sair</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Bootstrap core JavaScript-->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/popper/popper.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<!-- Core plugin JavaScript-->
		<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
		<!-- Page level plugin JavaScript-->
		<script src="vendor/chart.js/Chart.min.js"></script>
		<script src="vendor/datatables/jquery.dataTables.js"></script>
		<script src="vendor/datatables/dataTables.bootstrap4.js"></script>
		<!-- Custom scripts for all pages-->
		<script src="js/sb-admin.min.js"></script>
		<!-- Custom scripts for this page-->
		<script src="js/sb-admin-datatables.min.js"></script>
		<script src="js/sb-admin-charts.min.js"></script>
	</div>
</body>

</html>