<?php
	session_start();
	include_once("includes/conn.inc.php");
	include_once("vendor/autoload.php");

	// verifica se o usuário realizou o login
	if (!isset($_SESSION['id'])) {
		header("Location: index.php");
		exit;
	}
	
	$userid = $_SESSION['id'];

	$msg = false;
	$erro = false;
	$ext = false;
	$erroBoleto = false;

	if (isset($_FILES['arquivo'])) {
		$extensao = substr($_FILES['arquivo']['name'], -4);
		
		// se a extensão não for pdf, exibe erro
		if ($extensao != ".pdf") {
			$ext = "Formato de arquivo não suportado.";
		}
		else {
			
			$novo_nome = md5(time()) . '.pdf'; // cria um nome único
			$diretorio = "upload/";

			move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome); // move o arquivo para o diretorio /upload

			// id do usuario que está enviando o boleto
			$userid = $_SESSION['id'];

			$data = date("Y.m.d", time()); // pega a data atual

			// garante que o usuario não executará nenhum script malicioso no banco de dados
			$tipo = mysqli_real_escape_string($conn, $_POST['tipoBoleto']); // tipo: despesa ou receita
			$status = mysqli_real_escape_string($conn, $_POST['status']); // status: pendente ou pago/recebido

			// pegando dados do boleto
			$parser = new \Smalot\PdfParser\Parser();
			$pdf = $parser->parseFile($diretorio.$novo_nome);

			$text = $pdf->getText();

			// identifica o numero do boleto
			preg_match("/\d{5}[.]\d{5}\s\d{5}[.]\d{6}\s\d{5}[.]\d{6}\s\d{1}\s\d{14}/", $text, $resBoleto);

			// nao foi possivel identificar o numero do boleto
			if (count($resBoleto) < 1) {
				unlink($diretorio.$novo_nome);
				$erro = "<strong>Erro!</strong> Boleto inválido.";
			}
			else {
				$numBoleto = $resBoleto[0];
				
				// verifica de boleto já está cadastrado no banco de dados
				$sql = "SELECT numero FROM boletos WHERE numero='$numBoleto' AND userid='$userid';";
				$res = mysqli_query($conn, $sql);
				$row = mysqli_num_rows($res);
				
				// já existe um boleto cadastrado com esse numero
				if ($row > 0) {
					$erroBoleto = "<strong>Erro!</strong> Este boleto já está cadastrado.";
				}
				else {
					// os 10 ultimos digitos do numero de um boleto representam o valor dele
					$valor = substr($numBoleto, -10);

					// conta quantos zeros tem antes do valor do boleto
					$count = 0;
					while ($valor[$count] == "0") {
						$count++;
					}

					// exclui os zeros e coloca o ponto da casa decimal
					$valor = substr($valor, $count);
					$valor = substr($valor, 0, -2) . "." . substr($valor, -2);

					// descobre de qual banco é o boleto
					$banco = substr($numBoleto, 0, 3);

					// extrai data de validade do boleto
					preg_match("/(\d{2})\/(\d{2})\/(\d{2,4})/", $text, $dataVencimento);

					// se o ano não tiver quatro digitos, coloca no formato correto
					if (strlen($dataVencimento[3]) < 4) {
						$dataVencimento[3] = "20" . $dataVencimento[3];
						$dataVencimento[0] = $dataVencimento[1]."/".$dataVencimento[2]."/".$dataVencimento[3];
					}

					// coloca no formato aaaa-mm-dd para guardar no banco
					$dataVencimento = str_replace("/", "-", $dataVencimento[0]);
					$dataVencimento = date('Y-m-d', strtotime($dataVencimento));

					// insere no banco
					$sql = "INSERT INTO boletos VALUES (default, '$userid', '$novo_nome', '$numBoleto', '$valor', '$dataVencimento', '$status', '$tipo', '$data');";

					if (mysqli_query($conn, $sql)) {
						$msg = "<strong>Sucesso!</strong> Seu boleto foi cadastrado.";
					}
					else {
						unlink($diretorio.$novo_nome);
						$msg = "<strong>Erro!</strong> Falha ao enviar o arquivo.";
					}
				}
			}
		}
	}
	
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
		<a class="navbar-brand" href="painel.php">Controle de Boletos</a>
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
							<a href="receita.php">A Receber</a>
						</li>
						<li>
							<a href="despesa.php">A Pagar</a>
						</li>
						<li>
							<a href="cadastrar.php">Cadastrar</a>
						</li>
					</ul>
				</li>

				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
					<a class="nav-link" href="painel.php">
						<i class="fa fa-fw fa-table"></i>
						<span class="nav-link-text">Fluxo de Caixa</span>
					</a>
				</li>

<!--
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
					<a class="nav-link" href="#">
						<i class="fa fa-fw fa-area-chart"></i>
						<span class="nav-link-text">Gráficos</span>
					</a>
				</li>
-->
			</ul>

			<ul class="navbar-nav sidenav-toggler">
				<li class="nav-item">
					<a class="nav-link text-center" id="sidenavToggler">
						<i class="fa fa-fw fa-angle-left"></i>
					</a>
				</li>
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

						<a class="dropdown-item" href="#"> <span class="text-success"> <strong><i
									class="fa fa-long-arrow-up fa-fw"></i>Boletos em Dia</strong>
						</span>
							<div class="dropdown-message small">Voce tem <?php print_r($emDiaReceita)?> boletos a receber <br>
																e <?php print_r($emDiaDespesa)?> a pagar em dia</div>
						</a>

						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#"> <span class="text-danger"> <strong><i
									class="fa fa-long-arrow-down fa-fw"></i>Boletos Atrasados</strong>
						</span>
							<div class="dropdown-message small">Voce tem <?php print_r($atrasadoReceita)?> boletos a receber <br>
																e <?php print_r($atrasadoDespesa)?> a pagar atrasados</div>
						</a>

						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#"> <span class="text-warning"> <strong><i
									class="fa fa-long-arrow-up fa-fw"></i>Boletos próximos do
									vencimento</strong>
						</span>
							<div class="dropdown-message small">Voce tem <?php print_r($prestesAVencerReceita)?> boletos a receber <br>
																e <?php print_r($prestesAVencerDespesa)?> a pagar prestes a vencer</div>
						</a>
					</div></li>


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
				<li class="breadcrumb-item active">Cadastrar</li>
			</ol>

			<div class="container cadastro-form">
				<form action="cadastrar.php" method="post" enctype="multipart/form-data">
					<div class="form-group row">
						<label for="arquivo" class="col-sm-2 col-form-label">Boleto</label>
						<div class="col-sm-10">
							<input class="form-control-file" type="file" required name="arquivo">
						</div>
					</div>
					<div class="form-group row">
						<label for="status" class="col-sm-2 col-form-label">Situação</label>
						<div class="col-sm-10">
							<select class="form-control" name="status">
								<option value="Pendente">Pendente</option>
								<option value="Pago">Pago</option>
							</select>
						</div>
					</div>
					<fieldset class="form-group">
						<div class="row">
							<legend class="col-form-legend col-sm-2">Tipo</legend>
							<div class="col-sm-10">
								<div class="form-check">
									<label class="form-check-label">
										<input class="form-check-input" type="radio" name="tipoBoleto" value="Receita" required>
									  	Receita
									</label>
								</div>
								<div class="form-check">
									<label class="form-check-label">
										<input class="form-check-input" type="radio" name="tipoBoleto" value="Despesa" required>
									  	Despesa
									</label>
								</div>
							</div>
						</div>
					</fieldset>
					<div class="form-group row">
						<div class="col-sm-10">
							<button class="btn btn-primary" type="submit" name="submit">Salvar</button>
						</div>
					</div>
					
					<?php
						if ($msg != false) {
							echo "<div class=\"alert alert-dark\" role=\"alert\">{$msg}</div>"; // exibe mensagem de sucesso/erro
						}
						
						if ($erro != false) {
							echo "<div class=\"alert alert-danger\" role=\"alert\">{$erro}</div>"; // boleto invalido
						}
					
						if ($ext != false) {
							echo "<div class=\"alert alert-danger\" role=\"alert\">{$ext}</div>"; // formato não supostado
						}
					
						if ($erroBoleto != false) {
							echo "<div class=\"alert alert-danger\" role=\"alert\">{$erroBoleto}</div>"; // boleto já cadastrado
						}
					?>

				</form>

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
