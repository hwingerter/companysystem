<?php include('topo.php');
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$acao = '';
	
	if (isset($_REQUEST['cod_financeiro'])) { $cod_financeiro = $_REQUEST['cod_financeiro']; } else { $cod_financeiro = ''; }
	if (isset($_REQUEST['cod_cliente'])) { $cod_cliente = $_REQUEST['cod_cliente']; } else { $cod_cliente = ''; }
	if (isset($_REQUEST['vencimento'])) { $vencimento = $_REQUEST['vencimento']; } else { $vencimento = '';	}
	if (isset($_REQUEST['pagamento'])) { $pagamento = $_REQUEST['pagamento']; } else { $pagamento = '';	}
	if (isset($_REQUEST['parcela'])) { $parcela = $_REQUEST['parcela']; } else { $parcela = '';	}
	if (isset($_REQUEST['total_parcela'])) { $total_parcela = $_REQUEST['total_parcela']; } else { $total_parcela = ''; }
	if (isset($_REQUEST['obs'])) { $obs = $_REQUEST['obs']; } else { $obs = ''; }
	if (isset($_REQUEST['valor'])) { $valor = $_REQUEST['valor']; } else { $valor = ''; }

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "incluir"){
		
		$sql = "insert into fluxo_caixa (cod_financeiro, vencimento, parcela, total_parcelas, obs, valor";
		if ($pagamento != '') { $sql .= ", pagamento"; }
		if ($cod_cliente != '') { $sql .= ", cod_cliente"; }
		$sql .= ") values (".limpa_int($cod_financeiro).", '". DataPhpMysql($vencimento) ."', ". limpa_int($parcela) . ",". limpa_int($total_parcela) .",'". limpa($obs) ."', '". ValorPhpMysql($valor) ."'";
		if ($pagamento != '') { $sql .= ",'". DataPhpMysql($pagamento) ."'"; }
		if ($cod_cliente != '') { $sql .= ",". limpa_int($cod_cliente); }
		$sql .= ")";
		mysql_query($sql);
		
		if ($total_parcela > 1) {
			for ($i=2; $i<=$total_parcela;$i+=1) {
				
				$vencimento_parcelas = somar_data($vencimento, 0, $i-1, 0);
				
				$sql = "insert into fluxo_caixa (cod_financeiro, vencimento, parcela, total_parcelas, obs, valor";
				if ($cod_cliente != '') { $sql .= ", cod_cliente"; }
				$sql .= ") values (".limpa_int($cod_financeiro).", '". DataPhpMysql($vencimento_parcelas) ."', ". $i . ",". limpa_int($total_parcela) .",'". limpa($obs) ."', '". ValorPhpMysql($valor) ."'";
				if ($cod_cliente != '') { $sql .= ",". limpa_int($cod_cliente); }
				$sql .= ")";
				mysql_query($sql);
				
			}
		}
		
		echo "<script language='javascript'>window.location='fluxo_caixa.php?sucesso=1';</script>";
		
	}else if ($_REQUEST['acao'] == "atualizar"){
		
		$sql = "update fluxo_caixa set cod_financeiro=". limpa_int($cod_financeiro). ", vencimento='". DataPhpMysql($vencimento) ."', parcela = ". limpa_int($parcela) .",";
		$sql .= " total_parcelas = ". limpa_int($total_parcela) . ", obs = '". limpa($obs) ."',valor = '". ValorPhpMysql($valor) ."'";
		if ($pagamento != '') { $sql .= ", pagamento = '". DataPhpMysql($pagamento) ."'"; }
		if ($cod_cliente != '') { $sql .= ", cod_cliente = ". $cod_cliente; }
		$sql .= " where cod_fluxo = ".$_REQUEST['id'];
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='fluxo_caixa.php?sucesso=2';</script>";
		
	}
	
}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['id'])) {
			$fluxo = $_REQUEST["id"];
		}
		
		$sql = "Select * from fluxo_caixa where cod_fluxo = " . $fluxo;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){
				$vencimento = DataMysqlPhp($rs['vencimento']);
				$pagamento = $rs['pagamento'];
				if ($pagamento != '') { $pagamento = DataMysqlPhp($pagamento); }
				$valor = ValorMysqlPhp($rs['valor']);
				$obs = $rs['obs'];
				$parcela = $rs['parcela'];
				$total_parcelas = $rs['total_parcelas'];
				$cod_cliente = $rs['cod_cliente'];
				$cod_financeiro = $rs['cod_financeiro'];
				
			}
		}
	
	}
	
}
	
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
<li class="active"><a href="fluxo_caixa.php">Fluxo de Caixa</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Fluxo de Caixa</h1>
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
			<form action="fluxo_caixa_info.php" class="form-horizontal row-border" name='frm' method="post">
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Cliente</b></label>
					<div class="col-sm-8">
						<?php ComboCliente($cod_cliente);?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descrição</b></label>
					<div class="col-sm-8">
						<?php ComboFinanceiro($cod_financeiro);?>
					</div>
				</div>								
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data do Vencimento</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control mask" data-inputmask="'alias': 'date'" name="vencimento" value="<?php echo $vencimento; ?>" maxlength="10"> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Valor</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="valor" value="<?php echo $valor; ?>" maxlength="15"> 
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data do Pagamento</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control mask" data-inputmask="'alias': 'date'" name="pagamento" value="<?php echo $pagamento; ?>" maxlength="10"> 
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Parcela</b></label>
					<div class="col-sm-8">
						<select class="form-control" id="source" name="parcela">
							<?php for ($i=1; $i<=36; $i+=1) {?>
							<option value="<?php echo $i;?>" <?php if ($acao == "alterar"){ if ($parcela == $i) { echo "selected"; } }?>><?php echo $i;?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Total de Parcelas</b></label>
					<div class="col-sm-8">
						<select class="form-control" id="source" name="total_parcela">
							<?php for ($i=1; $i<=36; $i+=1) {?>
							<option value="<?php echo $i;?>" <?php if ($acao == "alterar"){ if ($total_parcela == $i) { echo "selected"; } }?>><?php echo $i;?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Observações</b></label>
					<div class="col-sm-8">
						<textarea class="form-control" name="obs"><?php echo $obs;?></textarea>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
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