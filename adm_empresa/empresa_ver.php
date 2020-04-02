<?php

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

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
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['id'])) {
		$cod_empresa = $_REQUEST["id"];
	}
		
	$sql = "Select * from empresas where cod_empresa = " . $cod_empresa;

$sql = "Select e.* from empresas e
		where e.cod_empresa = " . $cod_empresa;

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
				$empresa = $rs['empresa'];
				$cnpj = $rs['cnpj'];
				$endereco = $rs['endereco'];
				$cep = $rs['cep'];
				$estado = $rs['estado'];
				$cidade = $rs['cidade'];
				$telefone = $rs['telefone'];
				$inscricao_municipal = $rs['inscricao_municipal'];
				$inscricao_estadual = $rs['inscricao_estadual'];

				$situacao = "";
				if($rs['situacao'] == "A"){
					$situacao = '<label class="label label-success">Ativa</label>';
				}elseif($rs['situacao'] == "I"){
					$situacao = '<label class="label label-danger">Bloqueada</label>';
				}

		}
	}
	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="empresas.php">Empresas</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Empresas</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Visualizar Empresa</h2>
		</div>
		<div class="panel-body">
			<form action="empresas.php" class="form-horizontal row-border" name='frm' method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Empresa</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $empresa;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>CNPJ</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $cnpj;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Inscrição Municipal</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $inscricao_municipal;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Inscrição Estadual</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $inscricao_estadual;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>CEP</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $cep;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Endereço</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $endereco;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Estado</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo ExibeEstado($estado);?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Cidade</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo ExibeCidade($cidade);?></label>
					</div>
				</div>								
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Telefone</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $telefone;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Situação</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $situacao;?></label>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-default btn" onclick="javascript:window.location='empresas.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->

<?php 
} // VER

include('../include/rodape_interno2.php');

?>