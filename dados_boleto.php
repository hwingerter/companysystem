<?php include('topo.php');
	
	//*********** VERIFICA CREDENCIAIS DE USU¡RIOS *************
	$credencial_boleto = 0;
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_boleto") {
			$credencial_boleto = 1;
			break;
		}
	}
	
	
if ($credencial_boleto == '1') { // Verifica se o usu·rio tem a credencial de incluir ou editar	
	
	$acao = '';
	
	if (isset($_REQUEST['id'])) { $cod_fluxo = $_REQUEST['id']; } else { $cod_fluxo = ''; }
	if (isset($_REQUEST['cod_cliente'])) { $cod_cliente = $_REQUEST['cod_cliente']; } else { $cod_cliente = ''; }
	if (isset($_REQUEST['vencimento'])) { $vencimento = $_REQUEST['vencimento']; } else { $vencimento = '';	}
	if (isset($_REQUEST['nosso_numero'])) { $nosso_numero = $_REQUEST['nosso_numero']; } else { $nosso_numero = '';	}
	if (isset($_REQUEST['numero_documento'])) { $numero_documento = $_REQUEST['numero_documento']; } else { $numero_documento = ''; }
	if (isset($_REQUEST['valor'])) { $valor = $_REQUEST['valor']; } else { $valor = ''; }

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "incluir"){
		
		$sql = "insert into boletos (emissao, vencimento, nosso_numero, numero_documento, valor, cod_fluxo) values ('". date('Y-m-d') ."', ".
		"'". DataPhpMysql($vencimento) ."', '". limpa($nosso_numero) . "','". limpa($numero_documento) ."','". ValorPhpMysql($valor) ."',". limpa_int($cod_fluxo). ")";
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='boleto_itau.php?fluxo=". $cod_fluxo ."';</script>";
		
	}else if ($_REQUEST['acao'] == "atualizar"){
		
		$sql = "update boletos set emissao='". date('Y-m-d') . "', vencimento='". DataPhpMysql($vencimento) ."', nosso_numero = '". limpa($nosso_numero) ."',";
		$sql .= " numero_documento = '". limpa($numero_documento) . "',valor = '". ValorPhpMysql($valor) ."'";
		$sql .= " where cod_fluxo = ".$_REQUEST['id'];
		mysql_query($sql);
		
		//echo "<script language='javascript'>window.location='boleto_itau.php?fluxo=". $cod_fluxo ."';</script>";
		echo "<script language='javascript'>window.location='fluxo_caixa.php';</script>";
		die;
		
	}
	
}

		
if (isset($_REQUEST['id'])) {
	$fluxo = $_REQUEST["id"];
}

$sql = "Select * from boletos where cod_fluxo = " . limpa_int($fluxo);
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
if ($registros > 0) {
	if ($rs = mysql_fetch_array($query)){
		$emissao = $rs['emissao'];
		$nosso_numero = $rs['nosso_numero'];
		$numero_documento = $rs['numero_documento'];
		
		$acao = "alterar";
		
	}
}

$sql = "Select * from fluxo_caixa where cod_fluxo = " . limpa_int($fluxo);
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
if ($registros > 0) {
	if ($rs = mysql_fetch_array($query)){
		$cod_cliente = $rs['cod_cliente'];
		$cod_financeiro = $rs['cod_financeiro'];
		$vencimento = DataMysqlPhp($rs['vencimento']);
		$valor = ValorMysqlPhp($rs['valor']);
		$parcela = $rs['parcela'];
		$total_parcelas = $rs['total_parcelas'];
		$obs = $rs['obs'];
	}
}

/*	NOSSO NUMERO A REGRA SER¡ SEMPRE 
DATA DA GERA«√O DO BOLETO + CODIGO DO CLIENTE + CODIGO DO FLUXO
*/

//if ($numero_documento == '') { $numero_documento = date('Ymd') . $cod_cliente . $fluxo; }

if ($nosso_numero == '') { // PEGA O ULTIMO N⁄MERO GERADO
	$sql = "Select * from boletos order by nosso_numero desc Limit 0,1";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$nosso_numero = $rs['nosso_numero'] + 1;
			$nosso_numero = str_pad($nosso_numero, 8, "0", STR_PAD_LEFT);
		}
	} else {
		$nosso_numero = '00000001';
	}
}

if ($numero_documento == '') { $numero_documento = $nosso_numero; }

?>
	 <script src="cidade_ComboAjax.js"></script>
        <div id="wrapper">
            <div id="layout-static">
                <?php include('menu.php');?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="dados_boleto.php">Dados do Boleto</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Dados do Boleto</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Fluxo de Caixa</h2>
		</div>
		<div class="panel-body">
			<form action="dados_boleto.php" class="form-horizontal row-border" name='frm' method="post">
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>				
			  <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Cliente</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php ExibeCliente($cod_cliente);?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descri√ß√£o</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php ExibeFinanceiro($cod_financeiro);?></label>
					</div>
				</div>								
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data do Vencimento</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="vencimento" value="<?php echo $vencimento; ?>" maxlength="10"> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Parcela</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $parcela;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Total de Parcelas</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $total_parcelas;?></label>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Valor</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="valor" value="<?php echo $valor; ?>" maxlength="10"> 
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Nosso N√∫mero</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="nosso_numero" value="<?php echo $nosso_numero; ?>" maxlength="8"> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>N√∫mero do Documento</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="numero_documento" value="<?php echo $numero_documento; ?>" maxlength="20">
						<!--<label class="control-label">Data - Cliente - Fluxo</label> -->
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Observa√ß√µes</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo "<p align='left'>". $obs . "</p>"; ?></label>
					</div>
				</div>
			
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gerar Boleto</button>
						<button class="btn-default btn" onclick="javascript:window.location='fluxo_caixa.php';">Cancel</button>
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
	
include('rodape.php');
?>