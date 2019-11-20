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
		if ($credenciais[$x] == "produto_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "produto_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "produto_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "produto_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}

$cod_empresa = $_SESSION['cod_empresa'];

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$acao = '';

	if (isset($_REQUEST["cod_grupo_produto"])) { $cod_grupo_produto = $_REQUEST["cod_grupo_produto"]; } else { $cod_grupo_produto = ""; }
	if (isset($_REQUEST["cod_fornecedor"])) { $cod_fornecedor = $_REQUEST["cod_fornecedor"]; } else { $cod_fornecedor = ""; }
	if (isset($_REQUEST["descricao"])) { $descricao = $_REQUEST["descricao"]; } else { $descricao = ""; }
	if (isset($_REQUEST["custo"])) { $custo = $_REQUEST["custo"]; } else { $custo = ""; }
	if (isset($_REQUEST["preco_venda"])) { $preco_venda = $_REQUEST["preco_venda"]; } else { $preco_venda = ""; }

	if ( (isset($_REQUEST["desconto_maximo"])) && ($_REQUEST["desconto_maximo"] != "")) { $desconto_maximo = ValorPhpMysql($_REQUEST["desconto_maximo"]); } else { $desconto_maximo = "NULL"; }
	if ( (isset($_REQUEST["desconto_promocional"])) && ($_REQUEST["desconto_promocional"] != "")) { $desconto_promocional = ValorPhpMysql($_REQUEST["desconto_promocional"]); } else { $desconto_promocional = "NULL"; }

	if (isset($_REQUEST["cod_tipo_comissao"])) { $cod_tipo_comissao = $_REQUEST["cod_tipo_comissao"]; } else { $cod_tipo_comissao = ""; }
	if (isset($_REQUEST["descontar_custo_produtos"])) { $descontar_custo_produtos = $_REQUEST["descontar_custo_produtos"]; } else { $descontar_custo_produtos = ""; }
	if (isset($_REQUEST["obs"])) { $obs = $_REQUEST["obs"]; } else { $obs = ""; }

	if($cod_tipo_comissao == "1"){

		if ($_REQUEST["comissao_percentual"] != ""){
			$comissao_percentual =  $_REQUEST["comissao_percentual"];
		}else{
			$comissao_percentual =  "NULL";
		}

		$comissao_fixa 			= "NULL";

	}elseif ($cod_tipo_comissao == "2"){

		$comissao_percentual	= "NULL";

		if ($_REQUEST["comissao_fixa"] != ""){
			$comissao_fixa =  ValorPhpMysql($_REQUEST["comissao_fixa"]);
		}else{
			$comissao_fixa =  "NULL";
		}

	}

	
	if (isset($_REQUEST['acao'])) {
		
		if ($_REQUEST['acao'] == "incluir"){
			
			$sql = "

			INSERT INTO `claudio_company`.`produtos`
			(`cod_grupo_produto`,
			`cod_fornecedor`,
			`cod_empresa`,
			`descricao`,
			`custo`,
			`preco_venda`,
			`desconto_maximo`,
			`desconto_promocional`,
			`cod_tipo_comissao`,
			`comissao_percentual`,
			`comissao_fixa`,
			`descontar_custo_produtos`,
			`obs`)
			VALUES
			('".$cod_grupo_produto."',
			'".$cod_fornecedor."',
			'".$cod_empresa."',
			'".$descricao."',
			'".$custo."',
			'".$preco_venda."',
			".$desconto_maximo.",
			".$desconto_promocional.",
			'".$cod_tipo_comissao."',
			".$comissao_percentual.",
			".$comissao_fixa.",
			'".$descontar_custo_produtos."',
			'".$obs."');
			";

			//echo $sql;die;

			mysql_query($sql);


			$sql = "
			Select 		max(p.cod_produto) as cod_produto
			from 		produtos p
			left join 	fornecedores f on f.cod_fornecedor = p.cod_fornecedor
			where 		f.cod_empresa = ".$cod_empresa;
			
			$query 	= mysql_query($sql);
			$rs 	= mysql_fetch_array($query);
			$cod_produto_inserido = $rs['cod_produto'];	

			if((isset($_REQUEST['retorno'])) && ($_REQUEST['retorno'] == "novo_item_comanda")){
				$cod_comanda = $_REQUEST['cod_comanda'];
				$cod_cliente = $_REQUEST['cod_cliente'];

				echo "<script language='javascript'>window.location='comanda_item_info.php?cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."&cod_produto_inserido=".$cod_produto_inserido."';</script>";	

			}else{
				echo "<script language='javascript'>window.location='produtos.php?sucesso=1';</script>";

			}

		}else if ($_REQUEST['acao'] == "atualizar"){
			
			$cod_produto = $_REQUEST['id'];


			$sql = "

			UPDATE `produtos`
			SET
			`cod_grupo_produto` = '".$cod_grupo_produto."',
			`cod_fornecedor` = '".$cod_fornecedor."',
			`cod_empresa` = '".$cod_empresa."',
			`descricao` = '".$descricao."',
			`custo` = '".$custo."',
			`preco_venda` = '".$preco_venda."',
			`desconto_maximo` = ".$desconto_maximo.",
			`desconto_promocional` = ".$desconto_promocional.",
			`cod_tipo_comissao` = '".$cod_tipo_comissao."',
			`comissao_percentual` = ".$comissao_percentual.",
			`comissao_fixa` = ".$comissao_fixa.",
			`descontar_custo_produtos` = '".$descontar_custo_produtos."',
			`obs` = '".$obs."'
			WHERE `cod_produto` = ".$cod_produto;

			//echo $sql;die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='produtos.php?sucesso=2';</script>";
			
		}
		
	}
	
	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "alterar"){
			
			$acao = $_REQUEST['acao'];
			
			if (isset($_REQUEST['id'])) {
				$produto = $_REQUEST["id"];
			}
			
			$sql = "Select * from produtos where cod_produto = " . $produto;
			$query = mysql_query($sql);
			$registros = mysql_num_rows($query);
			if ($registros > 0) {
				if ($rs = mysql_fetch_array($query)){
					$cod_grupo_produto = $rs["cod_grupo_produto"];
					$cod_fornecedor = $rs["cod_fornecedor"];
					$cod_empresa = $rs["cod_empresa"];
					$descricao = $rs["descricao"];
					$custo = ValorMysqlPhp($rs["custo"]);
					$preco_venda = ValorMysqlPhp($rs["preco_venda"]);
					$desconto_maximo = ValorMysqlPhp($rs["desconto_maximo"]);
					$desconto_promocional = ValorMysqlPhp($rs["desconto_promocional"]);
					$cod_tipo_comissao = $rs["cod_tipo_comissao"];
					$comissao_percentual = $rs["comissao_percentual"];

					if($rs["comissao_fixa"] != "")
					{
						$comissao_fixa = number_format($rs["comissao_fixa"], 2, ',', '.');
					}
					else
					{
						$comissao_fixa = "";
					}

					
					$descontar_custo_produtos = $rs["descontar_custo_produtos"];
					$obs = $rs["obs"];
				}
			}
		
		}
		
	}

	$cod_empresa = $_SESSION['cod_empresa'];

	$voltar = urlencode("produto/produto_info.php");
	
?>
	 <script src="../js/mascaramoeda.js"></script>
	 <script src="js/produto.js"></script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="produtos.php">Produtos</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Produto</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Produto</h2>
		</div>
		<div class="panel-body">

			<form action="produto_info.php" class="form-horizontal row-border" name='frm' method="post">

				<input type="hidden" name="retorno" value="<?php echo $_REQUEST['retorno']; ?>">
				<input type="hidden" name="cod_comanda" value="<?php echo $_REQUEST['cod_comanda']; ?>">
				<input type="hidden" name="cod_cliente" value="<?php echo $_REQUEST['cod_cliente']; ?>">

				<?php if ($acao=="alterar"){?>
				<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
				<input type="hidden" name="acao" value="atualizar">
				<?php }else{?>
				<input type="hidden" name="acao" value="incluir">
				<?php } ?>				

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descrição</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $descricao;?>" name="descricao" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Fornecedor</b></label>
					<div class="col-sm-8">
					<?php ComboFornecedor($cod_fornecedor, $cod_empresa); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Grupo de produtos</b></label>
					<div class="col-sm-8">
					<?php ComboGrupoProduto($cod_grupo_produto, $cod_empresa); ?>
					</div>
					<div class="col-sm-2">
						<button class="btn-primary btn" type="button" onclick="javascript:location.href='../grupo_produto_info.php?voltar=<?php echo $voltar; ?>';">Novo</button>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Custo (R$)</b></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" value="<?php echo $custo;?>" name="custo" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Preço de Venda (R$)</b></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" value="<?php echo $preco_venda;?>" name="preco_venda" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Desconto Máximo (%)</b></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" value="<?php if ($desconto_maximo != 'NULL') { echo $desconto_maximo; }?>" name="desconto_maximo" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Desconto Promocional (%)</b></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" value="<?php if ($desconto_promocional != 'NULL') { echo $desconto_promocional; }?>" name="desconto_promocional" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo de Comissao</b></label>
					<div class="col-sm-2">
					<?php ComboTipoComissao($cod_tipo_comissao); ?>
					</div>
				</div>

				<div class="form-group" id="caixa_percentual">
					<label class="col-sm-2 control-label"><b>Comissao Percentual (%)</b></label>
					<div class="col-md-2">
						<input type="text" class="form-control" value="<?php echo $comissao_percentual;?>" name="comissao_percentual" maxlength="10">
					</div>
				</div>

				<div class="form-group" id="caixa_fixo" style="display: none;">
					<label class="col-sm-2 control-label"><b>Comissao Fixa (R$)</b></label>
					<div class="col-md-2">
						<input type="text" class="form-control" value="<?php echo $comissao_fixa;?>" name="comissao_fixa" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));" >
					</div>
				</div>

					<?php if ($_REQUEST['acao'] == "alterar"){ ?>
						<script>MudarTipoComissao('<?php echo $cod_tipo_comissao; ?>');</script>
					<?php } ?>

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descontar custo dos produtos</b></label>
					<div class="col-sm-2">
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
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='produtos.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->

<?php 
}
	
	
	include('../include/rodape_interno2.php');

?>