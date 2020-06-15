<?php 
require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cliente_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cliente_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cliente_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cliente_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['id'])) {
		$cliente = $_REQUEST["id"];
	}
		
	$sql = "Select * from clientes where cod_cliente = " . $cliente;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){

				$apelido = $rs["apelido"];
				$nome = $rs["nome"];
				$telefone = $rs["telefone"];
				$celular = $rs["celular"];
				$email = $rs["email"];
				$dia_aniversario = $rs["dia_aniversario"];
				$mes_aniversario = $rs["mes_aniversario"];
				$cep = $rs["cep"];
				$endereco = $rs["endereco"];
				$numero = $rs["numero"];
				$complemento = $rs["complemento"];
				$bairro = $rs["bairro"];
				$cidade = $rs["cidade"];
				$estado = $rs["estado"];
				$obs = $rs["obs"];



		}
	}
	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="clientes.php">Clientes</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Clientes</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Visualizar Cliente</h2>
		</div>
		<div class="panel-body">
			<form action="clientes.php" class="form-horizontal row-border" name='frm' method="post">		
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Apelido</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $apelido;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Nome Completo</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $nome;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Telefone</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $telefone;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Celular</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $celular;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>E-mail</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $email;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data de Nascimento</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $dia_aniversario." de ".RetornaMes($mes_aniversario);?></label>
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
					<label class="col-sm-2 control-label"><b>Número</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $numero;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Comlemento</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $complemento;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Bairro</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $bairro;?></label>
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
					<label class="col-sm-2 control-label"><b>Observação</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $obs;?></label>
					</div>
				</div>		
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-default btn" onclick="javascript:window.location='clientes.php';">Voltar</button>
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