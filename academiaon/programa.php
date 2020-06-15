<?php

	include('../include/topo_interno2.php');
	
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

                            <div class="page-heading">            
                                <h1>Aula - 25/09/2019</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

	<div data-widget-group="group1">

		<div class="panel panel-default" data-widget='{"draggable": "false"}'>
			<div class="panel-heading">
				<h2>Treino para perder a barriga - Tirar Flacidez</h2>
			</div>
			<div class="panel-body">
				<form action="fornecedor_info.php" class="form-horizontal row-border" name='frm' method="post">		
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Vídeo</b></label>
						<div class="col-sm-8">
							<iframe src="https://www.youtube.com/embed/8cYBuKJk6Yo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8" style="text-align:justify;">
						O nosso objetivo é deixar sua barriga tanquinho e te fazer suar a camisa, que tal? A prof. Dani vai trabalhar os seus abdominais nesse treino gostoso de fazer. A aula é curta , mas intensa e ideal para você que quer perder a barriga e eliminar a flacidez ! 
O desafio da copa so comecou e esse é o primeiro treino de uma serie de treinos incriveis que os treinadores do Exercicio em Casa prepararam pra voce. E ai, vai topar o desafio todo ou vai ficar acompanhando a copa do sofa?
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Professor (a)</b></label>
						<div class="col-sm-8">Daniella Dias</div>
					</div>
				</form>
			</div>
		</div>



															</div> <!-- .container-fluid -->
													</div> <!-- #page-content -->
	<?php 
}


	include('../include/rodape_interno.php');

?>