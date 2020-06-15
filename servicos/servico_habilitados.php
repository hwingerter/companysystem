<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "credencial_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "credencial_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	$acao = '';
	
	$cod_empresa = $_SESSION['cod_empresa'];

	if (isset($_REQUEST['id'])) {
		$cod_servico = $_REQUEST["id"];
	}
	
	
	$sql = "
	select 		p.nome
	from 		profissional_servico ps
	inner join	servico s on s.cod_servico = ps.cod_servico
	inner join	profissional p on p.cod_profissional = ps.cod_profissional
	where 		p.cod_empresa = ".$cod_empresa."
	and 		s.cod_servico = ".$cod_servico."
	order by 	p.nome asc; ";
	$query = mysql_query($sql);
	
	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="servico_habilitados.php?id=<?php echo $cod_servico; ?>">Funcionários Habilitados</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Serviços</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Funcionários habilitados</h2>
		</div>
		<div class="panel-body">
			<form action="credenciais.php" class="form-horizontal row-border" name='frm' method="post">
				<div class="form-group">

					<?php 
					while ($rs = mysql_fetch_array($query)) { 
					?>		
						<div class="col-sm-8">
							<b><?php echo $rs["nome"]; ?></b>
						</div>
					<?php 
					}
					?>

				</div>																
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8">
						<button class="btn-default btn" onclick="javascript:window.location='servicos.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
<?php 
} // VER
	include('../include/rodape_interno2.php');
?>