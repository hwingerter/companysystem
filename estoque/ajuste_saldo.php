<?php 
require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

include('../include/usuario.php');
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	//if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	//}
	
	
if ($credencial_editar == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	$acao = '';

	$cod_empresa = $_SESSION["cod_empresa"];
	$cod_produto = $_REQUEST["cod_produto"];
	$cod_estoque = $_REQUEST["cod_estoque"];
	
	if (isset($_REQUEST["cod_produto"])) { $cod_produto = $_REQUEST["cod_produto"]; } else { $cod_produto = "NULL"; }
	if (isset($_REQUEST["dt_ajuste"])) { $dt_ajuste = DataPhpMysql($_REQUEST["dt_ajuste"]); } else { $dt_ajuste = "NULL"; }
	if (isset($_REQUEST["quantidade"])) { $quantidade = $_REQUEST["quantidade"]; } else { $quantidade = "NULL"; }
	if (isset($_REQUEST["custo_medio"])) { $custo_medio = ValorPhpMysql($_REQUEST["custo_medio"]); } else { $custo_medio = "NULL"; }
	if (isset($_REQUEST["obs"])) { $obs = $_REQUEST["obs"]; } else { $obs = "NULL"; }

	$cod_tipo_movimentacao = 8;

	if (isset($_REQUEST['acao'])){
	
		if ($_REQUEST['acao'] == "novo")
		{	

			$sql = "
			INSERT INTO `estoque`
			(`cod_produto`,
			`dt_movimentacao`,
			`cod_tipo_movimentacao`,
			`quantidade`,
			`custo_medio_compra`,
			`obs`)
			VALUES
			('".$cod_produto."',
			'".$dt_ajuste."',
			'".$cod_tipo_movimentacao."',
			'".$quantidade."',
			'".$custo_medio."',
			'".$obs."');
			";

			//echo $sql;die;

			mysql_query($sql);

			echo "<script language='javascript'>window.location='estoque_atual.php?sucesso=1';</script>"; die;
			
		}else if ($_REQUEST['acao'] == "atualizar"){
		

			$sql = "
			UPDATE `claudio_company`.`estoque`
			SET
			`dt_movimentacao` = '".$dt_ajuste."',
			`quantidade` = '".$quantidade."',
			`custo_medio_compra` = '".$custo_medio."',
			`obs` = '".$obs."'
			WHERE cod_estoque = ".$cod_estoque." and `cod_produto` = ".$cod_produto.";";

			//echo $sql;die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='extrato_estoque.php?cod_produto=".$cod_produto."&sucesso=2';</script>";
		
		}	
	}



if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		$cod_estoque = $_REQUEST["cod_estoque"];
		$cod_produto = $_REQUEST["cod_produto"];
		
		$sql = "
		select 		e.dt_movimentacao
					,e.quantidade, e.custo_medio_compra, e.obs
		from 		estoque e
		where		e.cod_produto = ".$cod_produto."
		and 		e.cod_estoque = ".$cod_estoque."";

		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){
				$quantidade			= $rs['quantidade'];
				$dt_ajuste		= DataMysqlPhp($rs['dt_movimentacao']);
				$custo_medio 	= ValorMysqlPhp($rs["custo_medio_compra"]);
				$obs = $rs["obs"];

				$valor_total = number_format($quantidade * $custo_medio, 2);
				$valor_total = ValorMysqlPhp($valor_total);

			}
		}

	}
	
}

?>

	<script language="javascript" type="text/javascript" src="estoque.js"></script>
	<script language="javascript" src="../js/mascaramoeda.js"></script>

	<div class="static-content-wrapper">
        <div class="static-content">
            <div class="page-content">
                <ol class="breadcrumb">                                
					<li><a href="#">Principal</a></li>
					<li class="active"><a href="ajuste_saldo.php">Ajuste de Saldo</a></li>
                </ol>
                <div class="page-heading">            
                    <h1>Ajuste de Saldo</h1>
                    <div class="options">
					</div>
                </div>
                <div class="container-fluid">
                    

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Ajuste de Saldo</h2>
		</div>
		<div class="panel-body">

			<form action="ajuste_saldo.php" class="form-horizontal row-border" name='frm' method="post">
				
              <?php if ($acao=="alterar"){?>
              	  <input type="hidden" name="cod_estoque" value="<?php echo $_REQUEST['cod_estoque']; ?>">
	              <input type="hidden" name="cod_produto" value="<?php echo $_REQUEST['cod_produto']; ?>">
	              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              	<input type="hidden" name="acao" value="novo">
	              <input type="hidden" name="cod_produto" value="<?php echo $_REQUEST['cod_produto']; ?>">
              <?php } ?>				

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data do Ajuste</b></label>
					<div class="col-sm-8">
						<input type="text" id="datepicker" name="dt_ajuste" <?php if ($acao == "alterar"){echo "value='". $dt_ajuste ."'";}?>>
					</div>
				</div>		
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Quantidade em estoque</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="quantidade" id="quantidade"  maxlength="255" onKeyUp="CalcularCustoTotal();" maxlength="255" <?php if ($acao == "alterar"){echo "value='". $quantidade ."'";}?> >
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Custo Unit. Médio de Compra</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="custo_medio" id="custo_medio" maxlength="255" onKeyUp="CalcularCustoTotal();" maxlength="255" onKeyPress="return(moeda(this,'.',',',event));" <?php if ($acao == "alterar"){echo "value='". $custo_medio ."'";}?> >
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Valor total do estoque</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="custo_total" id="custo_total" maxlength="255" readonly value="<?php echo ValorPhpMysql($valor_total); ?>">
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Observações</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $obs ."'";}?> name="obs" maxlength="255">
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='estoque_atual.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 

}

	include('../include/rodape_interno2.php');

?>