<?php

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";;

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

$cod_empresa = $_SESSION['cod_empresa'];
$cod_profissional = $_REQUEST['cod_profissional'];
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$acao = '';


	$cod_servico = $_REQUEST['cod_servico'];

if (isset($_REQUEST['acao'])){

	if ($_REQUEST['acao'] == "personalizar"){
		
		if (isset($_REQUEST['cod_tipo_comissao'])) { $cod_tipo_comissao = $_REQUEST['cod_tipo_comissao']; } else { $cod_tipo_comissao = ''; }

		if($cod_tipo_comissao == "1"){

			$comissao_percentual 	=  $_REQUEST["percentual"];
			$comissao_fixa 			= "NULL";

		}elseif ($cod_tipo_comissao == "2"){

			$comissao_percentual 	=  "NULL";
			$comissao_fixa 			=  $_REQUEST["fixa"];

		}

		//echo $cod_tipo_comissao . " - " . $comissao_percentual . " - " . $comissao_fixa;die;


		$sql = "
		select 	*
		from 	profissional_comissao 
		where 	cod_empresa = ".$cod_empresa." 
		and 	cod_profissional = ".$cod_profissional."
		and 	cod_servico = ".$cod_servico."
		";

		//echo $sql;die;

		$query = mysql_query($sql);
		$total = mysql_num_rows($query);
		
		if($total == 0)
		{
		
			$sql = "

			INSERT INTO `profissional_comissao`
			(`cod_empresa`,
			`cod_profissional`,
			`cod_servico`,
			`cod_tipo_comissao`,
			`comissao_percentual`,
			`comissao_fixa`)
			VALUES
			('".$cod_empresa."',
			'".$cod_profissional."',
			'".$cod_servico."',
			'".$cod_tipo_comissao."',
			".ValorPhpMysql($comissao_percentual).",
			".ValorPhpMysql($comissao_fixa).");
			";
			
			//echo $sql;die;
			mysql_query($sql);

		}
		else
		{

			$sql = "
			UPDATE `claudio_company`.`profissional_comissao`
			SET
			`cod_tipo_comissao` = '".$cod_tipo_comissao."',
			`comissao_percentual` = ".ValorPhpMysql($comissao_percentual).",
			`comissao_fixa` = ".ValorPhpMysql($comissao_fixa)."
			WHERE `cod_profissional` = ".$cod_profissional."
			and  cod_servico = ".$cod_servico.";

			";

			//echo $sql;die;
			mysql_query($sql);

		}


		echo "<script language='javascript'>window.location='comissoes.php?sucesso=1';</script>"; die;
		
	}
	elseif ($_REQUEST['acao'] == "restaurar_comissao")
	{
		$sql = "
			DELETE FROM `profissional_comissao` where cod_profissional = ".$cod_profissional." and cod_servico = ".$cod_servico.";
		";
		mysql_query($sql);

		echo "<script language='javascript'>window.location='comissoes.php?sucesso=2';</script>"; die;
	}
	
}

		
$cod_servico		= $_REQUEST["cod_servico"];
$cod_profissional	= $_REQUEST["cod_profissional"];


$sql = "
select		p.nome, c.cod_tipo_comissao
			,case when c.cod_tipo_comissao = 1 then comissao_percentual else comissao_fixa end as valor
from 		profissional_comissao c
inner join	profissional p on p.cod_profissional = c.cod_profissional
where 		p.cod_empresa = ".$cod_empresa."
and 		p.cod_profissional = ".$cod_profissional.";
";
$query = mysql_query($sql);
$registros = mysql_num_rows($query);

if($registros > 0)
{
	$rs = mysql_fetch_array($query);
	$cod_tipo_comissao 	= $rs["cod_tipo_comissao"];
	$valor 				= $rs["valor"];

}
else
{

	$sql2 = "
	select		c.cod_tipo_comissao
				,case when c.cod_tipo_comissao = 1 then comissao_percentual else comissao_fixa end as valor
	from 		servico c
	where 		c.cod_empresa = ".$cod_empresa."
	and 		c.cod_servico = ".$cod_servico.";
	";

	$query2 = mysql_query($sql2);

	$rs2 = mysql_fetch_array($query2);
	$cod_tipo_comissao 	= $rs2["cod_tipo_comissao"];
	$valor 				= $rs2["valor"];

}

?>

	<script src="../js/mascaramoeda.js"></script>
	<script src="../servicos/js/servicos.js"></script>

	<div class="static-content-wrapper">
        <div class="static-content">
            <div class="page-content">
                <ol class="breadcrumb">
                    
					<li><a href="#">Principal</a></li>
					<li class="active"><a href="personalizar_comissao.php?cod_profissional=<?php echo $cod_profissional; ?>">Personalizar Comissão</a></li>

                </ol>
                <div class="page-heading">            
                    <h1>Personalizar Comissão</h1>
                    <div class="options">
					</div>
                </div>
                <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Personalizar Comissão</h2>
		</div>
		<div class="panel-body">

			<form action="personalizar_comissao.php" class="form-horizontal row-border" name='frm' method="post">

              
              <input type="hidden" name="cod_profissional" value="<?php echo $cod_profissional; ?>">
              <input type="hidden" name="cod_servico" value="<?php echo $cod_servico; ?>">
              <input type="hidden" name="acao" value="personalizar">
              
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo de Comissao</b></label>
					<div class="col-sm-4">
					<?php ComboTipoComissao($cod_tipo_comissao); ?>
					</div>
				</div>

				<div class="form-group" id="caixa_percentual">
					<label class="col-sm-2 control-label"><b>Comissao Percentual (%)</b></label>
					<div class="col-md-2">
						<input type="text" class="form-control" value="" name="percentual" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));" > 
					</div>
				</div>

				<div class="form-group" id="caixa_fixo" style="display: none;">
					<label class="col-sm-2 control-label"><b>Comissao Fixa (R$)</b></label>
					<div class="col-md-2">
						<input type="text" class="form-control" value="" name="fixa" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));" >

					</div>
				</div>

						<script>MudarTipoComissao('<?php echo $cod_tipo_comissao; ?>');</script>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Salvar</button> &nbsp;
						<button class="btn-success btn" onclick="javascript:RestaurarComissao('<?php echo $cod_profissional; ?>', '<?php echo $cod_servico; ?>');">Restaurar padrão</button>&nbsp;
						<button class="btn-default btn" onclick="javascript:window.location='comissoes.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



<?php 
} // INCLUIR OU EDITAR

	include('../include/rodape_interno2.php');

?>