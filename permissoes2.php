<?php include('topo.php');
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
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
		$licenca = $_REQUEST['id'];
		
		$sql = "Delete from licenca_permissao where cod_licenca = ". $licenca;
		mysql_query($sql);
		
		for($i=1; $i<=$totalcred;$i++) {
			if (isset($_REQUEST['area'.$i])) {
				if ($_REQUEST['area'.$i] != '') {
					$sql = "Insert into licenca_permissao (cod_licenca,cod_permissao) values (". $licenca .",". $_REQUEST['area'.$i] .")";
					mysql_query($sql);
				}
			}
		}
		
		echo "<script language='javascript'>window.location='licencas.php?sucesso=2';</script>";
		die();
	
	}

}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
	
		if (isset($_REQUEST['id'])) {
			$licenca = $_REQUEST["id"];
		}
		
		$sql = "Select count(*) as total from permissoes";
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
		
		$sql = "Select licenca_permissao.cod_permissao from licenca_permissao left join permissoes on  ".
		"licenca_permissao.cod_permissao = permissoes.cod_permissao where licenca_permissao.cod_licenca = " . $licenca;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			$i = 1;
			while ($rs = mysql_fetch_array($query)) { 
				$cred[$i] = $rs["cod_permissao"];
				$i = $i + 1;
			}
		}
		
	}
	
}
	
?>
        <div id="wrapper">
            <div id="layout-static">
                <?php include('menu.php');?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="permissoes.php">Permissões</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Permissões</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Permissões da Licença</h2>
		</div>
		<div class="panel-body">
			<form action="permissoes.php" class="form-horizontal row-border" name='frm' method="post">
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
			  <input type="hidden" name="totalcred" value="<?php echo $totalcred; ?>">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Licença</b></label>
					<div class="col-sm-8">
						<label class="col-sm-2 control-label"><?php echo ExibeLicenca($_REQUEST['id']); ?></label>
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
							> Permite
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo de Conta</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area2" id="area2" value="2"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '2') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Credenciais</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area3" id="area3" value="3"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '3') { echo " checked"; }
							  }
							  ?>							
							> Permite
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
							<input type="checkbox" name="area4" id="area4" value="4"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '4') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Clientes</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area5" id="area5" value="5"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '5') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Fornecedores</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area6" id="area6" value="6"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '6') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Produtos</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area7" id="area7" value="7"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '7') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Grupo de Produtos</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area8" id="area8" value="8"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '8') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Profissional</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area11" id="area11" value="11"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '11') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Serviços</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area10" id="area10" value="10"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '10') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo de Serviços</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area12" id="area12" value="12"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '12') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Cartão</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area13" id="area13" value="13"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '13') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>
				<div class="panel-heading">
					<h2>Financeiro</h2>
				</div>		
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Conta</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area14" id="area14" value="14"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '14') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Fluxo de Caixa</b></label>
					<div class="col-sm-8">
						<label class="checkbox-inline icheck">
							<input type="checkbox" name="area9" id="area9" value="9"
							  <?php 
							  for($i=1; $i<=$totalcred;$i++) {
							  	if ($cred[$i] == '9') { echo " checked"; }
							  }
							  ?>							
							> Permite
						</label>
					</div>
				</div>								
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='licencas.php';">Cancel</button>
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
include('rodape.php')?>