<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

require_once "../preferencias/preferencias_inc.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
$cod_usuario = $_SESSION['cod_usuario'];
$cod_grupo	 = $_SESSION['cod_grupo'];

if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$acao = '';
		
	if (isset($_REQUEST['atualizar'])) { $atualizar = $_REQUEST['atualizar']; } else { $atualizar = ''; }
	
if ($atualizar != '1') {
	
	if (isset($_REQUEST['acao'])) {

		if (isset($_REQUEST['empresa'])) { $empresa = $_REQUEST['empresa']; } else { $empresa = ''; }
		if (isset($_REQUEST['email'])) { $email = $_REQUEST['email']; } else { $email = '';	}
		if (isset($_REQUEST['tipo_pessoa'])) { $tipo_pessoa = $_REQUEST['tipo_pessoa']; } else { $tipo_pessoa = '';	}
		if (isset($_REQUEST['cnpj'])) { $cnpj = $_REQUEST['cnpj']; } else { $cnpj = '';	}
		if (isset($_REQUEST['endereco'])) { $endereco = $_REQUEST['endereco']; } else { $endereco = ''; }
		if (isset($_REQUEST['bairro'])) { $bairro = $_REQUEST['bairro']; } else { $bairro = ''; }
		if (isset($_REQUEST['cep'])) { $cep = $_REQUEST['cep']; } else { $cep = ''; }
		if (isset($_REQUEST['codestado'])) { $estado = $_REQUEST['codestado']; } else { $estado = ''; }
		if (isset($_REQUEST['codcidade'])) { $cidade = $_REQUEST['codcidade']; } else { $cidade = ''; }
		if (isset($_REQUEST['telefone'])) { $telefone = $_REQUEST['telefone']; } else { $telefone = ''; }
		if (isset($_REQUEST['inscricao_estadual'])) { $inscricao_estadual = $_REQUEST['inscricao_estadual']; } else { $inscricao_estadual = ''; }
		if (isset($_REQUEST['inscricao_municipal'])) { $inscricao_municipal = $_REQUEST['inscricao_municipal']; } else { $inscricao_municipal = ''; }

		$dataCadastro = DataPhpMysql(date('d-m-Y'))." ".date('H:m');
		
		if ($_REQUEST['acao'] == "incluir"){
			
			$sql = "insert into empresas (empresa, email, cnpj, endereco, bairro, cep, telefone, inscricao_estadual, inscricao_municipal";
			if ($estado != '') { $sql .= ", estado"; }
			if ($cidade != '') { $sql .= ", cidade"; }
			$sql .= ", dt_cadastro, cod_usuario_cadastro) values ('". limpa($empresa) ."','". limpa($email) ."', '". limpa($cnpj) ."','". limpa($endereco) ."','". limpa($bairro) ."','". limpa($cep) ."','". limpa($telefone) ."','". limpa($inscricao_estadual) ."','". limpa($inscricao_municipal) ."'";
			if ($estado != '') { $sql .= ",". limpa_int($estado); }
			if ($cidade != '') { $sql .= ",". limpa_int($cidade); }
			$sql .= ", '".$dataCadastro."',". limpa($cod_usuario) .")";
			//echo $sql;die;
			mysql_query($sql);

			$sql = "select cod_empresa from empresas where empresa = '".limpa($empresa)."' and cod_usuario_cadastro = ".limpa($cod_usuario)." ";
			$query = mysql_query($sql);
			$rs1 = mysql_fetch_array($query);
			$cod_filial = $rs1['cod_empresa'];

			//VINCULAR A EMPRESA AO GRUPO
			$sql = "insert into grupo_empresas (cod_empresa, cod_filial) values ('".limpa($cod_empresa)."', '".limpa($cod_filial)."');";
			//echo $sql;die;
			mysql_query($sql);

			//VINCULAR A EMPRESA AO GRUPO
			$sql = "insert into usuarios_empresas (cod_usuario, cod_empresa) 
					values ('".$cod_usuario."', '".limpa($cod_filial)."');";
			mysql_query($sql);

			$descricao_tipoConta = "Administrador";		
			$sql = "insert into tipo_conta (descricao, cod_empresa) values ('".limpa($descricao_tipoConta)."', ".$cod_filial.")";
			mysql_query($sql);

			CriarPreferencias($cod_filial, $empresa, $telefone, $nome, $email);
			
			echo "<script language='javascript'>window.location='empresas.php?sucesso=1';</script>";
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			
			$sql = "update empresas set empresa='". limpa($empresa) ."', email = '". limpa($email) ."', cnpj = '". limpa($cnpj) ."',".
			" endereco = '". limpa($endereco) ."', bairro = '". limpa($bairro) ."', cep = '". limpa($cep) ."', telefone = '". limpa($telefone) ."', inscricao_estadual = '". limpa($inscricao_estadual) ."', inscricao_municipal = '". limpa($inscricao_municipal) ."'";
			if ($estado != '') { $sql .= ", estado = ". limpa_int($estado); }
			if ($cidade != '') { $sql .= ", cidade = ". limpa_int($cidade); }
			$sql .= " where cod_empresa = ".$_REQUEST['id'];
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='empresas.php?sucesso=2';</script>";
			
		}
		
	}
	
	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "alterar"){
			
			$acao = $_REQUEST['acao'];
			
			if (isset($_REQUEST['id'])) {
				$cod_empresa = $_REQUEST["id"];
			}
			
			$sql = "Select * from empresas where cod_empresa = " . $cod_empresa;
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
					$bairro = $rs['bairro'];
					$estado = $rs['estado'];
					$cidade = $rs['cidade'];
					$telefone = $rs['telefone'];
					
				}
			}
		
		}
		
	}

}
	
?>
<script src="../js/cidade_ComboAjax.js"></script>
<script src="../assets/js/jquery.validate.js"></script>
<script src="../assets/js/jquery.mask.min.js"></script>
<script src="empresa.js"></script>

</script>	 

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="empresas.php">Empresas</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Empresa</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados da Empresa</h2>
		</div>
		<div class="panel-body">

			<form action="empresa_info.php" class="form-horizontal row-border" name='frm' id="formCadastro" method="post">
              
			  <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>		



				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Empresa</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $empresa;?>" name="empresa" id="empresa" maxlength="200">
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
					<label class="col-sm-2 control-label"><b>CEP</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $cep;?>" name="cep" id="cep" maxlength="10">
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Endereço</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $endereco;?>" name="endereco" id="rua" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Bairro</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $bairro;?>" name="bairro" id="bairro" maxlength="200">
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
					  <select name="codestado" id="uf" Onchange='atualizaCidade(this.value);' class="form-control">
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
				  	<select name="codcidade" id="cidade" class="form-control">
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
						<input type="text" class="form-control" value="<?php echo $telefone;?>" name="telefone" id="telefone" maxlength="100">
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<input type="submit" class="btn btn-primary" name="signup1" value="Gravar">
							<button class="btn-default btn" onclick="javascript:window.location='empresas.php';">Voltar</button>
						</div>
					</div>
				</div>

			</form>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
							</div>
<?php 
}
	
include('../include/rodape_interno2.php');

?>