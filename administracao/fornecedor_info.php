<?php

	include('../include/topo_interno.php');
	
	//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fornecedor_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fornecedor_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fornecedor_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fornecedor_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if ($_SESSION['usuario_conta'] == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	$acao = '';

	$cod_empresa = $_SESSION['cod_empresa'];
	
	if (isset($_REQUEST['empresa'])) { $empresa = $_REQUEST['empresa']; } else { $empresa = ''; }
	if (isset($_REQUEST['email'])) { $email = $_REQUEST['email']; } else { $email = '';	}
	if (isset($_REQUEST['tipo_pessoa'])) { $tipo_pessoa = $_REQUEST['tipo_pessoa']; } else { $tipo_pessoa = '';	}
	if (isset($_REQUEST['cnpj'])) { $cnpj = $_REQUEST['cnpj']; } else { $cnpj = '';	}
	if (isset($_REQUEST['endereco'])) { $endereco = $_REQUEST['endereco']; } else { $endereco = ''; }
	if (isset($_REQUEST['cep'])) { $cep = $_REQUEST['cep']; } else { $cep = ''; }
	if (isset($_REQUEST['codestado'])) { $estado = $_REQUEST['codestado']; } else { $estado = ''; }
	if (isset($_REQUEST['codcidade'])) { $cidade = $_REQUEST['codcidade']; } else { $cidade = ''; }
	if (isset($_REQUEST['telefone'])) { $telefone = $_REQUEST['telefone']; } else { $telefone = ''; }
	if (isset($_REQUEST['obs'])) { $obs = $_REQUEST['obs']; } else { $obs = ''; }
	
	if (isset($_REQUEST['inscricao_estadual'])) { $inscricao_estadual = $_REQUEST['inscricao_estadual']; } else { $inscricao_estadual = ''; }
	if (isset($_REQUEST['inscricao_municipal'])) { $inscricao_municipal = $_REQUEST['inscricao_municipal']; } else { $inscricao_municipal = ''; }
	
	
	if (isset($_REQUEST['atualizar'])) { $atualizar = $_REQUEST['atualizar']; } else { $atualizar = ''; }
	
if ($atualizar != '1') {
	
	if (isset($_REQUEST['acao'])) {
		
		if ($_REQUEST['acao'] == "incluir"){
			
			$sql = "insert into fornecedores_company (empresa, email, cnpj, endereco, cep, telefone, inscricao_estadual, inscricao_municipal, obs ";
			if ($estado != '') { $sql .= ", estado"; }
			if ($cidade != '') { $sql .= ", cidade"; }
			$sql .= ") values ('". limpa($empresa) ."','". limpa($email) ."', '". limpa($cnpj) ."','". limpa($endereco) ."','". limpa($cep) ."','". limpa($telefone) ."','". limpa($inscricao_estadual) ."','". limpa($inscricao_municipal) ."', '".$obs."' ";
			if ($estado != '') { $sql .= ",". limpa_int($estado); }
			if ($cidade != '') { $sql .= ",". limpa_int($cidade); }
			$sql .= ")";

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='fornecedores.php?sucesso=1';</script>";
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			
			$sql = "update fornecedores_company set empresa='". limpa($empresa) ."', email = '". limpa($email) ."', cnpj = '". limpa($cnpj) ."',".
			" endereco = '". limpa($endereco) ."', cep = '". limpa($cep) ."', telefone = '". limpa($telefone) ."', obs='".$obs."', inscricao_estadual = '". limpa($inscricao_estadual) ."', inscricao_municipal = '". limpa($inscricao_municipal) ."'";
			if ($estado != '') { $sql .= ", estado = ". limpa_int($estado); }
			if ($cidade != '') { $sql .= ", cidade = ". limpa_int($cidade); }
			$sql .= " where cod_fornecedor = ".$_REQUEST['id'];

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='fornecedores.php?sucesso=2';</script>";
			
		}
		
	}
	
	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "alterar"){
			
			$acao = $_REQUEST['acao'];
			
			if (isset($_REQUEST['id'])) {
				$fornecedor = $_REQUEST["id"];
			}
			
			$sql = "Select * from fornecedores_company where cod_fornecedor = " . $fornecedor;
			$query = mysql_query($sql);
			$registros = mysql_num_rows($query);
			if ($registros > 0) {
				if ($rs = mysql_fetch_array($query)){
					$empresa = $rs['empresa'];
					$email = $rs['email'];
					$cnpj = $rs['cnpj'];
					$inscricao_municipal = $rs['inscricao_municipal'];
					$inscricao_estadual = $rs['inscricao_estadual'];
					$endereco = $rs['endereco'];
					$cep = $rs['cep'];
					$estado = $rs['estado'];
					$cidade = $rs['cidade'];
					$telefone = $rs['telefone'];
					$obs =  $rs['obs'];
				}
			}
		
		}
		
	}

}
	
?>
	 <script src="cidade_ComboAjax.js"></script>
	<script language='JavaScript'>
	function Atualizar() {
		document.forms['frm'].action = "fornecedor_info.php?atualizar=1";
		document.forms['frm'].submit();
	}
	</script>	 

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="fornecedores.php">Fornecedores</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Fornecedor</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Fornecedor</h2>
		</div>
		<div class="panel-body">
			<form action="fornecedor_info.php" class="form-horizontal row-border" name='frm' method="post">
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Empresa</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $empresa;?>" name="empresa" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>CNPJ</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $cnpj;?>" name="cnpj" maxlength="20">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Inscrição Municipal</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $inscricao_municipal;?>" name="inscricao_municipal" maxlength="20">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Inscrição Estadual</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $inscricao_estadual;?>" name="inscricao_estadual" maxlength="20">
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Endereço</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $endereco;?>" name="endereco" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>CEP</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $cep;?>" name="cep" maxlength="10">
					</div>
				</div>
				<?php 
				if ($cidade != '') {
				?>
				<script language='JavaScript'>EditaCidade('<?php echo $estado; ?>','<?php echo $cidade; ?>');</script>
				<?php
				}
				?>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Estado</b></label>
					<div class="col-sm-8">
					  <select name="codestado" Onchange='atualizaCidade(this.value);' class="form-control">
						<option value="">UF</option>
	                    <?php
	                    $query = mysql_query("select * from estados order by uf asc") or die (mysql_error());
						while($rs = mysql_fetch_array($query)){
						?>
						<option value="<?php echo $rs['cod_estado'];?>"
						<?php if ($estado == $rs['cod_estado']) { echo " Selected"; }?>
						><?php echo htmlentities($rs['uf']);?></option>
	                    <?php
						}
						?>
					  </select>						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Cidade</b></label>
					<div class="col-sm-8">
                    <div id="city">
				  	<select name="codcidade" class="form-control">
						<option value="">Selecione</option>
 					</select>
					</div>						
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>E-mail</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $email;?>" name="email" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Telefone</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $telefone;?>" name="telefone" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Observação</b></label>
					<div class="col-sm-8">
					  <textarea name="obs" style="width:100%; height: auto;"><?php echo $obs;?></textarea>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='fornecedores.php';">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
<?php 
}
	
	include('../include/rodape_interno.php');

?>