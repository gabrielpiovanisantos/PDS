<?php
	session_start();
	include("includes/conn.inc.php");
	
	// verifica se o usuario realizou o login
	if (!isset($_SESSION['id'])) {
		header("Location: index.php");
		exit;
	}

	$userid = $_SESSION['id'];
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
	<!-- CSS personalizado -->
	<link rel="stylesheet" href="css/style.css">
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
					<a href="painel.php">Painel</a>
				</li>
				<li class="breadcrumb-item active">Fluxo de caixa</li>
			</ol>

			<div>
				<form class="form-inline" method="post" action="caixa.php">
					<div class="form-group">
						<label for="ano">Ano</label>
						<input type="number" class="form-control mx-sm-3" id="ano" name="ano" maxlength="4">
					</div>
					<button type="submit" class="btn btn-primary">Buscar</button>
				</form>
				<br>
				
				<div class="card mb-3">
					<div class="card-header"><i class="fa fa-table"></i> Fluxo de caixa</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th></th>
										<th>Janeiro</th>
										<th>Fevereiro</th>
										<th>Março</th>
										<th>Abril</th>
										<th>Maio</th>
										<th>Junho</th>
										<th>Julho</th>
										<th>Agosto</th>
										<th>Setembro</th>
										<th>Outubro</th>
										<th>Novembro</th>
										<th>Dezembro</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th></th>
										<th>Janeiro</th>
										<th>Fevereiro</th>
										<th>Março</th>
										<th>Abril</th>
										<th>Maio</th>
										<th>Junho</th>
										<th>Julho</th>
										<th>Agosto</th>
										<th>Setembro</th>
										<th>Outubro</th>
										<th>Novembro</th>
										<th>Dezembro</th>
									</tr>
								</tfoot>
								<tbody>
									<?php							
										$ano = date("Y"); // pega o ano atual
									
										// se o usuario escolher o ano
										if (isset($_POST['ano'])) {
											$ano = $_POST['ano'];
										}
																		
										// calcula as despesas mensais
										for ($mes = 1; $mes < 13; $mes++) {

											// soma as despesas do ano selecionado agrupadas por mês
											$sql = "SELECT ano, mes, soma, tipo, status FROM (
														SELECT YEAR(vencimento) as ano, MONTH(vencimento) as mes, SUM(valor) as soma, tipo, status FROM boletos
														GROUP BY ano, mes, tipo, status
													) AS res WHERE ano='$ano' and mes='$mes' and tipo='Despesa' and status='Pago';";

											// executa query
											$res = mysqli_query($conn, $sql);
											$numRows = mysqli_num_rows($res);

											// se retornar resultado, guarda a soma do mês correspondente
											if ($numRows > 0) {
												$row = mysqli_fetch_assoc($res);
												$valor = $row['soma'];
											}
											else {
												$valor = 0.0;
											}											

											$despesa[$mes] = number_format($valor, 2, ",", "");
										}

										mysqli_free_result($res);
									
										// calcula as receitas mensais
										for ($mes = 1; $mes < 13; $mes++) {

											// soma as despesas do ano selecionado agrupadas por mês
											$sql = "SELECT ano, mes, soma, tipo, status FROM (
														SELECT YEAR(vencimento) as ano, MONTH(vencimento) as mes, SUM(valor) as soma, tipo, status FROM boletos
														GROUP BY ano, mes, tipo, status
													) AS res WHERE ano='$ano' and mes='$mes' and tipo='Receita' and status='Pago';";

											// executa query
											$res = mysqli_query($conn, $sql);
											$numRows = mysqli_num_rows($res);

											// se retornar resultado, guarda a soma do mês correspondente
											if ($numRows > 0) {
												$row = mysqli_fetch_assoc($res);
												$valor = $row['soma'];
											}
											else {
												$valor = 0.0;
											}											

											$receita[$mes] = number_format($valor, 2, ',', '');
										}

										mysqli_free_result($res);
									
										// calcula o saldo mensal
										for ($mes = 1; $mes < 13; $mes++) {
											$saldo[$mes] = $receita[$mes] - $despesa[$mes];
											$saldo[$mes] = number_format($saldo[$mes], 2, ',', '');
										}

										// imprime a tabela
										printf("<tr class='table-success'>
													<th scope='row'>Receita</th>
													<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
													<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
												</tr>
												<tr class='table-danger'>
													<th scope='row'>Despesa</th>
													<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
													<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
												 </tr>
												 <tr>
													<th>Lucro/Prejuízo</th>
													<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
													<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
												 </tr>", $receita[1], $receita[2], $receita[3], $receita[4], $receita[5], $receita[6], $receita[7], $receita[8], $receita[9], $receita[10], $receita[11], $receita[12], $despesa[1], $despesa[2], $despesa[3], $despesa[4], $despesa[5], $despesa[6], $despesa[7], $despesa[8], $despesa[9], $despesa[10], $despesa[11], $despesa[12], $saldo[1], $saldo[2], $saldo[3], $saldo[4], $saldo[5], $saldo[6], $saldo[7], $saldo[8], $saldo[9], $saldo[10], $saldo[11], $saldo[12]);					
									?>
								</tbody>
							</table>
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