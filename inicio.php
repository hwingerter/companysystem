<?php 

require_once "include/topo_interno.php";

require_once "include/funcoes.php";

$flg_aviso_dias = "N";
$flg_aviso_atrasado = "N";

if ($cod_empresa != "")
{

	$sql = "select * from empresas_licenca where cod_empresa = ".$cod_empresa." order by cod_empresa_licenca desc limit 1;";

	//echo $sql;die;

	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

	$dt_atual = date("Y-m-d");
	$dt_vencimento 	= $rs['dt_vencimento'];

	$dias_expirar = strtotime($dt_vencimento) - strtotime($dt_atual);
						
	$dias = floor($dias_expirar / (60 * 60 * 24));

	if ($dias > 5){
		$flg_aviso_dias = "N";

	}elseif($dias == 5){
		$flg_aviso_dias = "S";

	}elseif($dias <= 0){
		$flg_aviso_atrasado = "S";

	}

}

?>

<div class="static-content-wrapper">
	<div class="static-content">
		<div class="page-content">
			<ol class="breadcrumb">
				<li><a href="inicio.php">Inicio</a></li>
			</ol>
			<div class="page-heading">            
				<h1></h1>
				<div  style="margin:0 auto; text-align:center;"><img src="<?php echo sistema."/assets/img/COMPANY_SYSTEM_LOGO.png"; ?>" style="width:20%;"></div>
			</div>
			<div class="container-fluid">
								
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">								


					<div class="panel-heading">
						<h2>Empresa: <?php echo $nome_empresa; ?></h2>
					</div>
					<div class="panel-body">
						
						<?php if ($flg_aviso_dias == "S") { ?>

						<div class="alert alert-dismissable alert-warning">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h3>Atenção!</h3> 

							<p>Percebemos que faltam <b><?php echo $dias; ?> dias</b> para a sua renovação.<br>Renove a sua licença.</p>
							<br>
							<p><a class="btn btn-info" href="empresa/empresa_licenca_info.php?acao=ver_licenca">Renovar Licença</a></p>

						</div>
						<?php }?>

						<?php if ($flg_aviso_atrasado == "S") { ?>

						<div class="alert alert-dismissable alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h3>Ops!</h3> 

							<p>A sua licença expirou! <br>Renove a sua licença para continuar usando o sistema.</p>
							<br>
							<p><a class="btn btn-danger" href="empresa/empresa_licenca_info.php?acao=ver_licenca">Renovar Licença</a></p>
						</div>

						<?php }?>


					</div>


</div> <!-- .container-fluid -->
</div>
</div>
<?php 
require_once('include/rodape_interno.php'); 
?>