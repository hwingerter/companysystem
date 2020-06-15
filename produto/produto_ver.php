<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
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
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['id'])) {
		$produto = $_REQUEST["id"];
	}
		
	$sql = "
	Select 		p.descricao, f.nome_fantasia, g.descricao
				,p.custo, p.preco_venda, p.desconto_maximo, p.desconto_promocional
				,case when p.cod_tipo_comissao = 1 then 'Percentual' else 'Fixa' end as TipoComissao
	            ,p.cod_tipo_comissao, p.comissao_fixa, p.comissao_percentual
	            ,p.descontar_custo_produtos, p.obs
	from 		produtos p
	left join	fornecedores f on f.cod_fornecedor = p.cod_fornecedor
	left join	grupo_produtos g on g.cod_grupo_produto = p.cod_grupo_produto
	where 		p.cod_produto = ".$produto;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$descricao = $rs['descricao'];
			$fornecedor = $rs['nome_fantasia'];
			$grupo_produtos = $rs['descricao'];
			$custo = ValorMysqlPhp($rs['custo']);
			$preco_venda = ValorMysqlPhp($rs['preco_venda']);
			$desconto_maximo = ValorMysqlPhp($rs['desconto_maximo']);
			$desconto_promocional = ValorMysqlPhp($rs['desconto_promocional']);
			$TipoComissao = $rs['TipoComissao'];
			$cod_tipo_comissao = $rs['cod_tipo_comissao'];

			if ($cod_tipo_comissao == "1") {
				$comissao = $rs['comissao_percentual'];
			}elseif ($cod_tipo_comissao == "2"){
				$comissao = $rs['comissao_fixa'];
			}
			
		}
	}
	
?>

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
			<h2>Visualizar Produto</h2>
		</div>
		<div class="panel-body">
			<form action="produtos.php" class="form-horizontal row-border" name='frm' method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descrição</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $descricao;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Fornecedor</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $fornecedor;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Grupo do Produtos</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $grupo_produtos;?></label>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Custo</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $custo;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Preço de Venda</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $preco_venda; ?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Desconto Máximo</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $desconto_maximo; ?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Desconto Promocional</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $desconto_promocional; ?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b><?php echo $TipoComissao; ?></b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $comissao;?></label>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-default btn" onclick="javascript:window.location='produtos.php';">Voltar</button>
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