<?php 

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "servico_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "servico_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "servico_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "servico_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$acao = '';
	
	/*
	if (isset($_REQUEST['descricao'])) { $descricao = $_REQUEST['descricao']; } else { $descricao = ''; }
	if (isset($_REQUEST['cod_grupo'])) { $cod_grupo = $_REQUEST['cod_grupo']; } else { $cod_grupo = '';	}
	if (isset($_REQUEST['cod_fornecedor'])) { $cod_fornecedor = $_REQUEST['cod_fornecedor']; } else { $cod_fornecedor = '0';	}
	if (isset($_REQUEST['cod_grupo_servico'])) { $cod_grupo_servico = $_REQUEST['cod_grupo_servico']; } else { $cod_grupo_servico = '0';	}
	if (isset($_REQUEST['quantidade'])) { $quantidade = $_REQUEST['quantidade']; } else { $quantidade = '';	}
	if (isset($_REQUEST['unidade'])) { $unidade = $_REQUEST['unidade']; } else { $unidade = ''; }
	if (isset($_REQUEST['valor'])) { $valor = $_REQUEST['valor']; } else { $valor = ''; }
	*/

	$cod_empresa = $_SESSION["cod_empresa"];

	if (isset($_REQUEST["id"])) { $id = $_REQUEST["id"]; } else { $id = ""; }

	if (isset($_REQUEST["cod_categoria"])) { $cod_categoria = $_REQUEST["cod_categoria"]; } else { $cod_categoria = ""; }
	if (isset($_REQUEST["cod_tipo_servico"])) { $cod_tipo_servico = $_REQUEST["cod_tipo_servico"]; } else { $cod_tipo_servico = ""; }
	if (isset($_REQUEST["nome"])) { $nome = $_REQUEST["nome"]; } else { $nome = ""; }
	if (isset($_REQUEST["custo_produtos"])) { $custo_produtos = $_REQUEST["custo_produtos"]; } else { $custo_produtos = ""; }
	if (isset($_REQUEST["preco_venda"])) { $preco_venda = $_REQUEST["preco_venda"]; } else { $preco_venda = ""; }
	if (isset($_REQUEST["desconto_maximo"])) { $desconto_maximo = $_REQUEST["desconto_maximo"]; } else { $desconto_maximo = ""; }
	if (isset($_REQUEST["desconto_promocional"])) { $desconto_promocional = $_REQUEST["desconto_promocional"]; } else { $desconto_promocional = ""; }
	if (isset($_REQUEST["duracao_aproximada"])) { $duracao_aproximada = $_REQUEST["duracao_aproximada"]; } else { $duracao_aproximada = ""; }
	if (isset($_REQUEST["cod_tipo_comissao"])) { $cod_tipo_comissao = $_REQUEST["cod_tipo_comissao"]; } else { $cod_tipo_comissao = ""; }
	if (isset($_REQUEST["comissao_percentual"])) { $comissao_percentual = $_REQUEST["comissao_percentual"]; } else { $comissao_percentual = ""; }
	if (isset($_REQUEST["descontar_custo_produtos"])) { $descontar_custo_produtos = $_REQUEST["descontar_custo_produtos"]; } else { $descontar_custo_produtos = ""; }
	if (isset($_REQUEST["obs"])) { $obs = $_REQUEST["obs"]; } else { $obs = ""; }


	if (isset($_REQUEST['acao'])) {
		
		if ($_REQUEST['acao'] == "incluir"){
			
			$sql = "
			INSERT INTO `servico` (
			`cod_empresa`,
			`cod_categoria`,
			`cod_tipo_servico`,
			`nome`,
			`custo_produtos`,
			`preco_venda`,
			`desconto_maximo`,
			`desconto_promocional`,
			`duracao_aproximada`,
			`cod_tipo_comissao`,
			`comissao_percentual`,
			`descontar_custo_produtos`,
			`obs`)
			VALUES
			('".limpa($cod_empresa)."',
			'".limpa($cod_categoria)."',
			'".limpa($cod_tipo_servico)."',
			'".limpa($nome)."',
			'".limpa($custo_produtos)."',
			'".limpa($preco_venda)."',
			'".limpa($desconto_maximo)."',
			'".limpa($desconto_promocional)."',
			'".limpa($duracao_aproximada)."',
			'".limpa($cod_tipo_comissao)."',
			'".limpa($comissao_percentual)."',
			'".limpa($descontar_custo_produtos)."',
			'".limpa($obs)."');
			";

			//echo $sql; die;

			mysql_query($sql);
			

			echo "<script language='javascript'>window.location='servicos.php?sucesso=1';</script>";
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			

			$sql = "
			UPDATE `servico`
			SET
			`cod_categoria` = '".limpa($cod_categoria)."',
			`cod_tipo_servico` = '".limpa($cod_tipo_servico)."',
			`nome` = '".limpa($nome)."',
			`custo_produtos` = '".limpa($custo_produtos)."',
			`preco_venda` = '".limpa($preco_venda)."',
			`desconto_maximo` = '".limpa($desconto_maximo)."',
			`desconto_promocional` = '".limpa($desconto_promocional)."',
			`duracao_aproximada` = '".limpa($duracao_aproximada)."',
			`cod_tipo_comissao` = '".limpa($cod_tipo_comissao)."',
			`comissao_percentual` = '".limpa($comissao_percentual)."',
			`descontar_custo_produtos` = '".limpa($descontar_custo_produtos)."',
			`obs` = '".limpa($obs)."'
			WHERE `cod_servico` = ".$id.";
			";

			//echo $sql; die;


			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='servicos.php?sucesso=2';</script>";
			
		}
		
	}
	
			
	$acao = $_REQUEST['acao'];
	
	if (isset($_REQUEST['id'])) {
		$id = $_REQUEST["id"];
	}
	
	$sql = "Select * from servico where cod_servico = " . $id;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){

			$cod_servico = $rs["cod_servico"];
			$cod_categoria = $rs["cod_categoria"];
			$cod_tipo_servico = $rs["cod_tipo_servico"];
			$nome = $rs["nome"];
			$custo_produtos = $rs["custo_produtos"];
			$preco_venda = $rs["preco_venda"];
			$desconto_maximo = $rs["desconto_maximo"];
			$desconto_promocional = $rs["desconto_promocional"];
			$duracao_aproximada = $rs["duracao_aproximada"];
			$cod_tipo_comissao = $rs["cod_tipo_comissao"];
			$comissao_percentual = $rs["comissao_percentual"];
			$comissao_fixa = number_format($rs['comissao_fixa'], 2, ',', '.');
			$descontar_custo_produtos = $rs["descontar_custo_produtos"];
			$obs = $rs["obs"];
			
		}
	}

$cod_empresa = $_SESSION["cod_empresa"];
$cod_grupo = $_SESSION['cod_grupo_empresa'];
	
?>
	 
	 <script src="js/servicos.js"></script>

	 				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
							<li><a href="#">Principal</a></li>
							<li class="active"><a href="servicos.php">Serviços</a></li>

							</ol>
							<div class="page-heading">            
							<h1>Serviço</h1>
							<div class="options">
							</div>
							</div>
							<div class="container-fluid">
                                

	<div data-widget-group="group1">

		<div class="panel panel-default" data-widget='{"draggable": "false"}'>

			<div class="panel-heading">
				<h2>Dados do serviço</h2>
			</div>

			<div class="panel-body">
				<form action="servico_info.php" class="form-horizontal row-border" name='frm' method="post">
	              <?php if ($acao=="alterar"){?>
	              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
	              <input type="hidden" name="acao" value="atualizar">
	              <?php }else{?>
	              <input type="hidden" name="acao" value="incluir">
	              <?php } ?>				
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Nome</b></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $nome;?>" name="nome" maxlength="200">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Categoria</b></label>
						<div class="col-sm-8">
						<?php ComboCategoriaServico($cod_empresa, $cod_categoria); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Tipo do Serviço</b></label>
						<div class="col-sm-8">
						<?php ComboTipoDeServico($cod_empresa, $cod_tipo_servico); ?>
						</div>
					</div>				
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Custo com Produtos</b> (reais)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $custo_produtos;?>" name="custo_produtos" maxlength="200">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Preço de Venda</b></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $preco_venda;?>" name="preco_venda" maxlength="10">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Desconto Máximo</b></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $desconto_maximo;?>" name="desconto_maximo" maxlength="10">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Desconto Promocional</b></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $desconto_promocional;?>" name="desconto_promocional" maxlength="10">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Duração Aproximada</b></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $duracao_aproximada;?>" name="duracao_aproximada" maxlength="10">
						</div>
					</div>
			
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Tipo de Comissão</b></label>
						<div class="col-sm-8">
						<?php ComboTipoComissao($cod_tipo_comissao); ?>
						</div>
					</div>
			
					<div class="form-group" id="caixa_percentual">
						<label class="col-sm-2 control-label"><b>Comissão Percentual (%)</b></label>
						<div class="col-md-4">
							<input type="text" class="form-control" value="<?php echo $comissao_percentual;?>" name="comissao_percentual" maxlength="10">
						</div>
					</div>

					<div class="form-group" id="caixa_fixo" style="display: none;">
						<label class="col-sm-2 control-label"><b>Comissao Fixa (R$)</b></label>
						<div class="col-md-4">
							<input type="text" class="form-control" value="<?php echo $comissao_fixa;?>" name="comissao_fixa" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));" >
						</div>
					</div>

					<script>MudarTipoComissao('<?php echo $cod_tipo_comissao; ?>');</script>

					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Descontar custo dos produtos</b></label>
						<div class="col-sm-8">
						<?php ComboDescontoCustoProduto($cod_fornecedor); ?>
						</div>
					</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Observações</b></label>
					<div class="col-sm-1">
						<textarea name="obs" class="form-control" style="width:800px; height:200px;"><?php echo $obs; ?></textarea>
					</div>
				</div>

				</form>

					<div class="panel-footer">
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<button id="IdVoltar" class="btn-default btn" onclick="javascript:window.location='servicos.php';">Voltar</button>
							</div>
						</div>
					</div>

			</div>
		</div>




	        </div> <!-- .container-fluid -->
	    </div> <!-- #page-content -->
	

<script>

	for(i=0;i<document.frm.length; i++){
		document.frm[i].disabled = true;
	}

</script>

<?php 
 } // VER 
	
	include('../include/rodape_interno2.php');

?>