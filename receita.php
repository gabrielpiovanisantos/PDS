<?php
session_start();
include_once ("includes/conn.inc.php");

// verifica se o usuario realizou o login
if (! isset($_SESSION['id'])) {
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
				<li class="breadcrumb-item active">Receita</li>
			</ol>

			<div>
				<!--	Boletos		-->
				<div class="card mb-3">
					<div class="card-header">
						<i class="fa fa-table"></i> Boletos a Receber
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-hover" id="dataTable"
								width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Número</th>
										<th>Valor (R$)</th>
										<th>Vencimento</th>
										<th>Status</th>
										<th>Alterar Status</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Número</th>
										<th>Valor (R$)</th>
										<th>Vencimento</th>
										<th>Status</th>
										<th>Alterar Status</th>
									</tr>
								</tfoot>
								<tbody>
									<?php
        // altera o status do boleto selecionado
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $id = $_GET['id'];
            $status = mysqli_real_escape_string($conn, $_GET['status']);
            
            if ($status == "Pago") {
                $sql = "UPDATE boletos SET status='Pago' WHERE id='$id';";
                mysqli_query($conn, $sql);
            } else if ($status == "Pendente") {
                $sql = "UPDATE boletos SET status='Pendente' WHERE id='$id';";
                mysqli_query($conn, $sql);
            } else if ($status == "Atrasado") {
                $sql = "UPDATE boletos SET status='Atrasado' WHERE id='$id';";
                mysqli_query($conn, $sql);
            }
        }
        
        // busca pelos boletos de receitas a receber
        $sql = "SELECT id, nome, numero, valor, vencimento, status FROM boletos WHERE userid='$userid' AND tipo='Receita' AND status='Pendente'";
        
        // se a busca retornar resultados
        if ($res = mysqli_query($conn, $sql)) {
            // percorre pelos resultados
            while ($row = mysqli_fetch_assoc($res)) {
                $vencimento = str_replace("-", "/", $row['vencimento']);
                $valor = number_format($row['valor'], 2, ",", ".");
                
                // link do boleto
                $linkPdf = $row['numero'] . " <a href='upload/" . $row['nome'] . "'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
                
                /*
                 * links para alterar os status dos boletos.
                 * passa por parametro o id do boleto e o novo status
                 */
                $alterar = "<div>
																<i class='fa fa-calendar-check-o' aria-hidden='true'></i>
																<a href=receita.php?id=" . $row['id'] . "&status=Pago>Pago</a>
															</div>
															<div>
																<i class='fa fa-calendar-minus-o' aria-hidden='true'></i>
																<a href=receita.php?id=" . $row['id'] . "&status=Pendente>Pendente</a>
															</div>
															<div>
																<i class='fa fa-calendar-times-o' aria-hidden='true'></i>
																<a href=receita.php?id=" . $row['id'] . "&status=Atrasado>Atrasado</a>
															</div>";
                
                // imprime as linhas da tabela
                printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $linkPdf, $valor, $vencimento, $row['status'], $alterar);
            }
            
            mysqli_free_result($res);
        }
        ?>
								</tbody>
							</table>
						</div>
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

		<script>
			$('#dataTable').dataTable( {
			  "columnDefs": [ {
				  "targets": 1,
				  "orderable": false
				} ]
			} );
		</script>
	</div>
</body>

</html>
