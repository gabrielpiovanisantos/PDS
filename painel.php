<?php
	session_start();
	include_once ("includes/conn.inc.php");

	// verifica se o usuario realizou o login
	if (!isset($_SESSION['id'])) {
		header("Location: index.php");
		exit();
	}

	$userid = $_SESSION['id'];

	date_default_timezone_set('America/Sao_Paulo');
	$dateToday = date('m/d/Y h:i:s a', time());
	$dateToday = new DateTime($dateToday);
	$emDiaReceita = 0;
	$prestesAVencerReceita = 0;
	$atrasadoReceita = 0;
	$emDiaDespesa = 0;
	$prestesAVencerDespesa = 0;
	$atrasadoDespesa = 0;

	$sql_dataVencimento = "SELECT vencimento, tipo FROM boletos
							WHERE status = 'Pendente'
							AND userid = '$userid';";

	$res_dataVencimento = mysqli_query($conn, $sql_dataVencimento);
	$numRows = mysqli_num_rows($res_dataVencimento);

	// se retornar resultado
	if ($numRows > 0) {
		while ($row = mysqli_fetch_assoc($res_dataVencimento)) {
			$dataVencimento = new DateTime($row['vencimento']);
			$interval = date_diff($dateToday, $dataVencimento);
			if ($row['tipo'] == 'Receita') {
				if ($interval->d > 7 && $interval->invert == 0)
					$emDiaReceita += 1;
				else if ($interval->d > 0 && $interval->invert == 0)
					$prestesAVencerReceita += 1;
				else
					$atrasadoReceita += 1;
			} else {
				if ($interval->d > 7 && $interval->invert == 0)
					$emDiaDespesa += 1;
				else if ($interval->d > 0 && $interval->invert == 0)
					$prestesAVencerDespesa += 1;
				else
					$atrasadoDespesa += 1;
			}
		}
	}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport"
		content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Painel</title>
	<!-- Bootstrap core CSS-->
	<link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	<!-- Custom fonts for this template-->
	<link href="vendor/font-awesome/css/font-awesome.min.css"
		rel="stylesheet" type="text/css">
	<!-- Page level plugin CSS-->
	<link href="vendor/datatables/dataTables.bootstrap4.css"
		rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="css/sb-admin.css" rel="stylesheet">
	<!-- CSS personalizado -->
	<link rel="stylesheet" href="css/style.css">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
	<!-- Navigation-->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"
		id="mainNav">
		<a class="navbar-brand" href="painel.php">Controle de Boletos</a>
		<button class="navbar-toggler navbar-toggler-right" type="button"
			data-toggle="collapse" data-target="#navbarResponsive"
			aria-controls="navbarResponsive" aria-expanded="false"
			aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
				<li class="nav-item" data-toggle="tooltip" data-placement="right"
					title="Example Pages"><a
					class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
					href="#collapseExamplePages" data-parent="#exampleAccordion"> <i
						class="fa fa-fw fa-file"></i> <span class="nav-link-text">Boletos</span>
				</a>
					<ul class="sidenav-second-level collapse" id="collapseExamplePages">
						<li><a href="boletos.php">Todos</a></li>
						<li><a href="receita.php">A Receber</a></li>
						<li><a href="despesa.php">A Pagar</a></li>
						<li><a href="cadastrar.php">Cadastrar</a></li>
					</ul></li>

				<li class="nav-item" data-toggle="tooltip" data-placement="right"
					title="Tables"><a class="nav-link" href="painel.php"> <i
						class="fa fa-fw fa-table"></i> <span class="nav-link-text">Fluxo
							de Caixa</span>
				</a></li>
			</ul>

			<ul class="navbar-nav sidenav-toggler">
				<li class="nav-item"><a class="nav-link text-center"
					id="sidenavToggler"> <i class="fa fa-fw fa-angle-left"></i>
				</a></li>
			</ul>

			<ul class="navbar-nav ml-auto">

				<li class="nav-item dropdown"><a
					class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown"
					href="#" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="false"> <i class="fa fa-fw fa-bell"></i> <span
						class="d-lg-none">Notificações </span> <span
						class="indicator text-warning d-none d-lg-block"> <i
							class="fa fa-fw fa-circle"></i>
					</span>
				</a>

					<div class="dropdown-menu dropdown-menu-right"
						aria-labelledby="alertsDropdown">
						<h6 class="dropdown-header">Notificações:</h6>
						<div class="dropdown-divider"></div>

						<a class="dropdown-item" href="receita.php"> <span class="text-success"> <strong><i
									class="fa fa-long-arrow-up fa-fw"></i>Receita</strong>
						</span>
							<div class="dropdown-message"><?php print_r($emDiaReceita)?> boletos em dia</div>
							<div class="dropdown-message"><?php print_r($atrasadoReceita)?> boletos atrasados</div>
							<div class="dropdown-message"><?php print_r($prestesAVencerReceita)?> boletos prestes a vencer</div>
						</a>

						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="despesa.php"> <span class="text-danger"> <strong><i
									class="fa fa-long-arrow-down fa-fw"></i>Despesa</strong>
						</span>
							<div class="dropdown-message"><?php print_r($emDiaDespesa)?> boletos em dia</div>
							<div class="dropdown-message"><?php print_r($atrasadoDespesa)?> boletos atrasados</div>
							<div class="dropdown-message"><?php print_r($prestesAVencerDespesa)?> boletos prestes a vencer</div>
						</a>
					</div>

				</li>


				<li class="nav-item"><a class="nav-link" data-toggle="modal"
					data-target="#exampleModal"><i class="fa fa-fw fa-sign-out"></i>Sair</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="painel.php">Painel</a></li>
				<li class="breadcrumb-item active">Fluxo de caixa</li>
			</ol>

			<div>
				<form class="form-inline" method="post" action="painel.php">
					<div class="form-group">
						<label for="ano">Ano</label> <input type="number"
							class="form-control mx-sm-3" id="ano" name="ano" maxlength="4">
					</div>
					<button type="submit" class="btn btn-primary">Buscar</button>
				</form>
				<br>

				<div class="card mb-3">
					<div class="card-header">
						<i class="fa fa-table"></i> Fluxo de caixa
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-sm" width="100%"
								cellspacing="0">
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
								<tbody>
									<?php
										$ano = date("Y"); // pega o ano atual

										// se o usuario escolher o ano
										if (isset($_POST['ano'])) {
											$ano = mysqli_real_escape_string($conn, $_POST['ano']);
										}
										for ($mes = 1; $mes < 13; $mes++) {

											$vencimento = sprintf("%04d-%02d-31", $ano, $mes-1);

											/***** Saldo Inicial *****/

											$sql_receita = "SELECT SUM(soma) AS saldo FROM (
																SELECT soma, vencimento, status, tipo, userid FROM (
																	SELECT vencimento, SUM(valor) as soma, status, tipo, userid FROM boletos
																	GROUP BY status, vencimento, tipo, userid
																) AS aux WHERE vencimento < '$vencimento' and status='Pago' and tipo='Receita' and userid='$userid'
															) AS resultado;";

											$res_receita = mysqli_query($conn, $sql_receita);
											$numRows = mysqli_num_rows($res_receita);

											// se retornar resultado, guarda a receita incial do mês correspondente
											if ($numRows > 0) {
												$row = mysqli_fetch_assoc($res_receita);
												$receitaInicial = $row['saldo'];
											} else {
												$receitaInicial = 0.0;
											}

											$sql_despesa = "SELECT SUM(soma) AS saldo FROM (
																SELECT soma, vencimento, status, tipo, userid FROM (
																	SELECT vencimento, SUM(valor) as soma, status, tipo, userid FROM boletos
																	GROUP BY status, vencimento, tipo, userid
																) AS aux WHERE vencimento < '$vencimento' and status='Pago' and tipo='Despesa' and userid='$userid'
															) AS resultado;";

											$res_despesa = mysqli_query($conn, $sql_despesa);
											$numRows = mysqli_num_rows($res_despesa);

											// se retornar resultado, guarda a despesa inicial do mês correspondente
											if ($numRows > 0) {
												$row = mysqli_fetch_assoc($res_despesa);
												$despesaInicial = $row['saldo'];
											} else {
												$despesaInicial = 0.0;
											}

											$saldoInicial = $receitaInicial - $despesaInicial;
											$inicial[$mes] = $saldoInicial;

											/***** Fim Saldo Inicial *****/

											/***** Receitas Mensais *****/

											// soma as receitas do ano selecionado agrupadas por mês
											$sql = "SELECT ano, mes, soma, tipo, status, userid FROM (
														SELECT YEAR(vencimento) as ano, MONTH(vencimento) as mes, SUM(valor) as soma, tipo, status, userid FROM boletos
														GROUP BY ano, mes, tipo, status, userid
													) AS res WHERE ano='$ano' and mes='$mes' and tipo='Receita' and status='Pago' and userid='$userid';";

											// executa query
											$res = mysqli_query($conn, $sql);
											$numRows = mysqli_num_rows($res);

											// se retornar resultado, guarda a soma do mês correspondente
											if ($numRows > 0) {
												$row = mysqli_fetch_assoc($res);
												$valor = $row['soma'];
											} else {
												$valor = 0.0;
											}

											$receita[$mes] = $valor;

											/***** Fim Receitas Mensais *****/

											/***** Despesas Mensais *****/

											// soma as despesas do ano selecionado agrupadas por mês
											$sql = "SELECT ano, mes, soma, tipo, status, userid FROM (
														SELECT YEAR(vencimento) as ano, MONTH(vencimento) as mes, SUM(valor) as soma, tipo, status, userid FROM boletos
														GROUP BY ano, mes, tipo, status, userid
													) AS res WHERE ano='$ano' and mes='$mes' and tipo='Despesa' and status='Pago' and userid='$userid';";

											// executa query
											$res = mysqli_query($conn, $sql);
											$numRows = mysqli_num_rows($res);

											// se retornar resultado, guarda a soma do mês correspondente
											if ($numRows > 0) {
												$row = mysqli_fetch_assoc($res);
												$valor = $row['soma'];
											} else {
												$valor = 0.0;
											}

											$despesa[$mes] = $valor;

										/***** Fim Despesas Mensais *****/
										}

										mysqli_free_result($res);
										mysqli_free_result($res_receita);
										mysqli_free_result($res_despesa);

										/***** Formatação dos números e cálculo do saldo do mês e do acumulado *****/

										for ($mes = 1; $mes < 13; $mes++) {
											// calcula o saldo mensal
											$saldo[$mes] = $receita[$mes] - $despesa[$mes];
											$saldo[$mes] = number_format($saldo[$mes], 2, ',', '.');

											// calcula saldo acumulado
											$acumulado[$mes] = $inicial[$mes] + $receita[$mes] - $despesa[$mes];
											$acumulado[$mes] = number_format($acumulado[$mes], 2, ',', '.');

											$receita[$mes] = number_format($receita[$mes], 2, ',', '.');
											$despesa[$mes] = number_format($despesa[$mes], 2, ',', '.');

											$inicial[$mes] = number_format($inicial[$mes], 2, ',', '.');
										}

										// imprime a tabela
										printf("<tr>
													<th>Saldo Inicial</th>
													<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
													<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
												</tr>
												<tr class='table-success'>
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
												 </tr>
												 <tr>
													<th>Acumulado</th>
													<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
													<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>
												 </tr>", $inicial[1], $inicial[2], $inicial[3], $inicial[4], $inicial[5], $inicial[6], $inicial[7], $inicial[8], $inicial[9], $inicial[10], $inicial[11], $inicial[12], $receita[1], $receita[2], $receita[3], $receita[4], $receita[5], $receita[6], $receita[7], $receita[8], $receita[9], $receita[10], $receita[11], $receita[12], $despesa[1], $despesa[2], $despesa[3], $despesa[4], $despesa[5], $despesa[6], $despesa[7], $despesa[8], $despesa[9], $despesa[10], $despesa[11], $despesa[12], $saldo[1], $saldo[2], $saldo[3], $saldo[4], $saldo[5], $saldo[6], $saldo[7], $saldo[8], $saldo[9], $saldo[10], $saldo[11], $saldo[12], $acumulado[1], $acumulado[2], $acumulado[3], $acumulado[4], $acumulado[5], $acumulado[6], $acumulado[7], $acumulado[8], $acumulado[9], $acumulado[10], $acumulado[11], $acumulado[12]);
										?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-table"></i> Total Geral
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-sm" width="100%"
							cellspacing="0">
							<thead>
								<tr>
									<th></th>
									<th>Pendente</th>
									<th>Pago</th>
								</tr>
							</thead>
							<tbody>
									<?php
										/***** Receita Pendente *****/
										$sql = "SELECT total, tipo, status, userid FROM (
													SELECT SUM(valor) AS total, tipo, status, userid
													FROM boletos
													GROUP BY tipo, status, userid
												) AS resultado WHERE tipo='Receita' AND status='Pendente' AND userid='$userid';";

										$res = mysqli_query($conn, $sql);

										if ($row = mysqli_fetch_assoc($res)) {
											$receitaPendente = $row['total'];
										} else {
											$receitaPendente = 0.0;
										}

										/***** Receita Recebida *****/
										$sql = "SELECT total, tipo, status, userid FROM (
													SELECT SUM(valor) AS total, tipo, status, userid
													FROM boletos
													GROUP BY tipo, status, userid
												) AS resultado WHERE tipo='Receita' AND status='Pago' AND userid='$userid';";

										$res = mysqli_query($conn, $sql);

										if ($row = mysqli_fetch_assoc($res)) {
											$receitaRecebida = $row['total'];
										} else {
											$receitaRecebida = 0.0;
										}

										/***** Despesa Pendente *****/
										$sql = "SELECT total, tipo, status, userid FROM (
													SELECT SUM(valor) AS total, tipo, status, userid
													FROM boletos
													GROUP BY tipo, status, userid
												) AS resultado WHERE tipo='Despesa' AND status='Pendente' AND userid='$userid';";

										$res = mysqli_query($conn, $sql);

										if ($row = mysqli_fetch_assoc($res)) {
											$despesaPendente = $row['total'];
										} else {
											$despesaPendente = 0.0;
										}

										/***** Despesa Paga *****/
										$sql = "SELECT total, tipo, status, userid FROM (
													SELECT SUM(valor) AS total, tipo, status, userid
													FROM boletos
													GROUP BY tipo, status, userid
												) AS resultado WHERE tipo='Despesa' AND status='Pago' AND userid='$userid';";

										$res = mysqli_query($conn, $sql);

										if ($row = mysqli_fetch_assoc($res)) {
											$despesaPaga = $row['total'];
										} else {
											$despesaPaga = 0.0;
										}

										$totalPendente = $receitaPendente - $despesaPendente;
										$totalPago = $receitaRecebida - $despesaPaga;

										/* Formata os valores */
										$receitaPendente = number_format($receitaPendente, 2, ',', '.');
										$receitaRecebida = number_format($receitaRecebida, 2, ',', '.');
										$despesaPendente = number_format($despesaPendente, 2, ',', '.');
										$despesaPaga = number_format($despesaPaga, 2, ',', '.');
										$totalPendente = number_format($totalPendente, 2, ',', '.');
										$totalPago = number_format($totalPago, 2, ',', '.');

										printf("<tr class='table-success'>
													<th scope='row'>Receita</th>
													<td>%s</td><td>%s</td>
												</tr>
												<tr class='table-danger'>
													<th scope='row'>Despesa</th>
													<td>%s</td><td>%s</td>
												 </tr>
												 <tr>
													<th scope='row'>Total</th>
													<td>%s</td><td>%s</td>
												 </tr>", $receitaPendente, $receitaRecebida, $despesaPendente, $despesaPaga, $totalPendente, $totalPago);

										?>
								</tbody>
						</table>
					</div>
				</div>
			</div>


			<!-- Scroll to Top Button-->
			<a class="scroll-to-top rounded" href="#page-top"> <i
				class="fa fa-angle-up"></i>
			</a>
			<!-- Logout Modal-->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
				aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Tem certeza que
								deseja sair?</h5>
							<button class="close" type="button" data-dismiss="modal"
								aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">Clique em "Sair" se deseja encerrar a
							sessão atual.</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button"
								data-dismiss="modal">Cancelar</button>
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
