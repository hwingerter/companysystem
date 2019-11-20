<?php 
	
	include('../include/topo_interno.php');

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
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
				$endereco = $rs['endereco'];
				$cep = $rs['cep'];
				$estado = $rs['estado'];
				$cidade = $rs['cidade'];
				$telefone = $rs['telefone'];
				$inscricao_municipal = $rs['inscricao_municipal'];
				$inscricao_estadual = $rs['inscricao_estadual'];
				$obs =  $rs['obs'];
		}
	}
	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="fornecedores.php">Fornecedores</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Fornecedores</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Visualizar Fornecedor</h2>
		</div>
		<div class="panel-body">
			<form action="fornecedores.php" class="form-horizontal row-border" name='frm' method="post">
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
					<label class="col-sm-2 control-label"><b>Endereço</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $endereco;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>CEP</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $cep;?></label>
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
					<label class="col-sm-2 control-label"><b>E-mail</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $email;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Telefone</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $telefone;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Observação</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $obs;?></label>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-default btn" onclick="javascript:window.location='fornecedores.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->

<?php 
} // VER

	include('../include/rodape_interno.php');

?>