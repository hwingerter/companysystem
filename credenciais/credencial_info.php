<?php

	require_once "../include/topo_interno2.php";

	require_once "../include/funcoes.php";

	require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
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
	
if ($credencial_editar == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
$acao = '';

if (isset($_REQUEST['acao'])){
	
    if ($_REQUEST['acao'] == "atualizar"){
		
		$totalcred = $_REQUEST['totalcred'];
		$tipo_conta = $_REQUEST['id'];
		$voltar = $_REQUEST['voltar'];
		
		$sql = "Delete from tipo_conta_credencial where cod_tipo_conta = ". $tipo_conta;
		mysql_query($sql);
		
		for($i=1; $i<=$totalcred;$i++) {
			if (isset($_REQUEST['area'.$i])) {
				if ($_REQUEST['area'.$i] != '') {
					$sql = "Insert into tipo_conta_credencial (cod_tipo_conta,cod_credencial) values (". $tipo_conta .",". $_REQUEST['area'.$i] .")";
					//echo $sql."<br>";
					mysql_query($sql);
				}
			}
		}

		//die;
		
		if($voltar != ""){
			echo "<script language='javascript'>window.location='".$voltar."?sucesso=2';</script>";
			die();
		}else{
			echo "<script language='javascript'>window.location='credenciais.php?sucesso=2';</script>";
			die();
		}


	
	}

}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
	
		if (isset($_REQUEST['id'])) {
			$tipo_conta = $_REQUEST["id"];
			$voltar = $_REQUEST["voltar"];
		}
		
		$sql = "Select count(*) as total from credenciais";
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)) { 
				$totalcred = $rs["total"];
			}
		}
		
		// ZERA O VETOR
		for($i=1; $i<=$totalcred;$i++) {
			$cred[$i] = 0;
		}
		
		$sql = "Select tipo_conta_credencial.cod_credencial from tipo_conta_credencial inner join credenciais on  ".
		"tipo_conta_credencial.cod_credencial = credenciais.cod_credencial where tipo_conta_credencial.cod_tipo_conta = " . $tipo_conta ." order by tipo_conta_credencial.cod_credencial asc";

		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			$i = 1;
			while ($rs = mysql_fetch_array($query)) { 
				$cred[$i] = $rs["cod_credencial"];
				$i = $i + 1;
			}
		}
		
	}
	
}
	
?>

<script language="javascript">

	function SelecionarTodosCadastros(){

		for(i=1; i<=12; i++){

			var item = "cheque_" + i;

			document.getElementById(item).style.display = "none";

		}

		for(i=1; i<=numero; i++){

			var item = "cheque_" + i;

			document.getElementById(item).style.display = "block";

		}

	}

</script>


				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="credenciais.php">Credenciais</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Credenciais</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Credencial do Tipo de Conta</h2>
		</div>
		<div class="panel-body">
			<form action="credencial_info.php" class="form-horizontal row-border" name='frm' method="post">
              
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
			  <input type="hidden" name="totalcred" value="<?php echo $totalcred; ?>">
			  <input type="hidden" name="voltar" value="<?php echo $voltar; ?>">

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo de Conta</b></label>
					<div class="col-sm-8">
						<label class="col-sm-2 control-label"><?php echo ExibeNomeTipoConta($_REQUEST['id']); ?></label>
					</div>
				</div>
				<div class="panel-heading">
					<h2>Sistema</h2>
				</div>			
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Selecionar Todos</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area1" id="area1" onclick="javascript:SelecionarTodosCadastros();" >
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Usuários</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area1" id="area1" value="1"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '1') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area2" id="area2" value="2"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '2') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area3" id="area3" value="3"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '3') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area4" id="area4" value="4"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '4') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo de Conta</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area5" id="area5" value="5"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '5') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area6" id="area6" value="6"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '6') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area7" id="area7" value="7"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '7') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area8" id="area8" value="8"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '8') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Credenciais</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area9" id="area9" value="9"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '9') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area10" id="area10" value="10"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '10') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>						
					</div>
				</div>
				<div class="panel-heading">
					<h2>Cadastros</h2>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Empresas</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area32" id="area32" value="32"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '32') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area33" id="area33" value="33"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '33') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area34" id="area34" value="34"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '34') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area35" id="area35" value="35"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '35') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Clientes</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area11" id="area11" value="11"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '11') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area12" id="area12" value="12"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '12') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area13" id="area13" value="13"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '13') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area14" id="area14" value="14"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '14') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Fornecedores</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area20" id="area20" value="20"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '20') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area21" id="area21" value="21"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '21') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area22" id="area22" value="22"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '22') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area23" id="area23" value="23"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '23') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Produtos</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area24" id="area24" value="24"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '24') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area25" id="area25" value="25"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '25') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area26" id="area26" value="26"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '26') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area27" id="area27" value="27"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '27') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Grupo de Produtos</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area28" id="area28" value="28"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '28') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area29" id="area29" value="29"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '29') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area30" id="area30" value="30"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '30') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area31" id="area31" value="31"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '31') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Profissionais</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area36" id="area36" value="36"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '36') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area37" id="area37" value="37"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '37') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area38" id="area38" value="38"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '38') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area39" id="area39" value="39"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '39') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Serviços</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area40" id="area40" value="40"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '40') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area41" id="area41" value="41"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '41') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area42" id="area42" value="42"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '42') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area43" id="area43" value="43"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '43') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo de Serviços</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area44" id="area44" value="44"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '44') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area45" id="area45" value="45"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '45') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area46" id="area46" value="46"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '46') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area47" id="area47" value="47"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '47') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Cartão</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area48" id="area48" value="48"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '48') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area49" id="area49" value="49"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '49') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area50" id="area50" value="50"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '50') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area51" id="area51" value="51"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '51') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
					</div>
				</div>
				<div class="panel-heading">
					<h2>Financeiro</h2>
				</div>		
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Comanda</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area60" id="area60" value="60"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '60') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area61" id="area61" value="61"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '61') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area62" id="area62" value="62"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '62') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area63" id="area63" value="63"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '63') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Caixa</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area56" id="area56" value="56"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '56') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area57" id="area57" value="57"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '57') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area58" id="area58" value="58"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '58') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area59" id="area59" value="59"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '59') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Contas a Pagar/Despesas</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area52" id="area52" value="52"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '52') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area53" id="area53" value="53"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '53') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area54" id="area54" value="54"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '54') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area55" id="area55" value="55"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '55') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Fluxo de Caixa</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area15" id="area15" value="15"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '15') { echo " checked"; }
							  }
							  ?>							
							> Ver
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area16" id="area16" value="16"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '16') { echo " checked"; }
							  }
							  ?>							
							> Incluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area17" id="area17" value="17"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '17') { echo " checked"; }
							  }
							  ?>							
							> Editar
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area18" id="area18" value="18"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '18') { echo " checked"; }
							  }
							  ?>							
							> Excluir
						</label>
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area19" id="area19" value="19"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '19') { echo " checked"; }
							  }
							  ?>							
							> Gerar Boleto
						</label>
					</div>
				</div>								
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='<?php echo $voltar; ?>';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 
} // EDITAR
	
	include('../include/rodape_interno2.php');

?>