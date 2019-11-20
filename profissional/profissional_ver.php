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
		$id = $_REQUEST["id"];
	}
		
	$sql = "
	select		*
	from		profissional
	where		cod_profissional = ".$id;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
		if ($registros > 0) {

			if ($rs = mysql_fetch_array($query)){
					$apelido = $rs['apelido'];
					$nome = $rs['nome'];
					$empresa = $rs['empresa'];
					$email = $rs['email'];
					$aniversario = $rs['dia_aniversario']."/".RetornaMes($rs['mes_aniversario']);
					$cpf = $rs['cpf'];
					$endereco = $rs['endereco'];
					$cep = $rs['cep'];
					$estado = $rs['estado'];
					$cidade = $rs['cidade'];
					$telefone = $rs['telefone'];
					$celular = $rs['celular'];
					$bairro = $rs['bairro'];
					$obs = $rs['obs'];

					if ($rs['mostrar_agenda'] == 1){
						$mostrar_agenda =  "Sim";	
					}else{
						$mostrar_agenda =  "N�o";	
					}

					if ($rs['agendamento_online'] == 1){
						$agendamento_online =  "Sim";	
					}else{
						$agendamento_online =  "Não";	
					}
		}
	}
	
?>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="profissionais.php">Profissionais</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Profissional</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Visualizar Profissional</h2>
		</div>
		<div class="panel-body">
			<form action="profissionais.php" class="form-horizontal row-border" name='frm' method="post">
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
					<label class="col-sm-2 control-label"><b>Aniversário</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $aniversario; ?></label>
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
					<label class="col-sm-2 control-label"><b>Observações</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $obs;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Mostrar na Agenda</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $mostrar_agenda;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Utiliza Agendamento Online</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $agendamento_online;?></label>
					</div>
				</div>				
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-default btn" onclick="javascript:window.location='profissionais.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



	</div> <!-- .container-fluid -->
<?php 
} // VER
	
	include('../include/rodape_interno2.php');

?>