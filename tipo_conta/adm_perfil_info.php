<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
	/*for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}*/
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	if (isset($_REQUEST['acao'])){
		
		$acao = '';

		if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = ''; }
	
		if ( (isset($_REQUEST['cod_empresa'])) && ($_REQUEST['cod_empresa'] != "")) { $cod_empresa = $_REQUEST['cod_empresa']; 
	
		} else { 
			$cod_empresa = 'NULL'; 
		}

		if ($_REQUEST['acao'] == "incluir"){
			
			$sql = "insert into tipo_conta (cod_empresa, descricao) values (".limpa($cod_empresa).", '".limpa($nome)."')";
			//echo $sql;die;
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='adm_perfil.php?sucesso=1';</script>";
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			
			$sql = "update tipo_conta set descricao='".limpa($nome)."', cod_empresa = ".limpa($cod_empresa)." where cod_tipo_conta = ".$_REQUEST['id'];
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='adm_perfil.php?sucesso=2';</script>";
		
		}
		
	}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['id'])) {
			$cod_perfil = $_REQUEST["id"];
		}
		
		$sql = "Select * from tipo_conta where cod_tipo_conta = " . $cod_perfil;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){
				$nome 		= $rs['descricao'];
				$cod_empresa	= $rs['cod_empresa'];
			}
		}
	
	}
	
}
	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="adm_perfil.php">Tipo de Conta</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Tipo de Conta</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Tipo de Conta</h2>
		</div>
		<div class="panel-body">
			<form action="adm_perfil_info.php" class="form-horizontal row-border" name='frm' method="post">

              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>			

				<div class="row">

					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Nome</b></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $nome ."'";}?> name="nome" maxlength="100">
						</div>
					</div>

				</div>

					<div class="row">

						<div class="form-group">

							<label class="col-sm-2 control-label"><b>Empresa</b></label>

							<div class="col-sm-8">

								<?php 
								$sql = "select cod_empresa, empresa from empresas order by empresa asc; ";

								$query = mysql_query($sql);

								?>

								<select name='cod_empresa' class="col-sm-8 form-control">

									<option value="">Selecione...</option>

									<?php 

									while ($rs = mysql_fetch_array($query)){

									 ?>

									<option value="<?php echo $rs['cod_empresa']; ?>" <?php if ($cod_empresa == $rs['cod_empresa']) { echo ' selected '; } ?> ><?php echo $rs['empresa']; ?></option>

									<?php
									}
									?>
								</select>
							</div>
						</div>
					</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='adm_perfil.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 
} // INCLUIR OU EDITAR

	
include('../include/rodape_interno2.php');
	
?>