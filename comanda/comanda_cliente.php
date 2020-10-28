<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$acao = '';
	$cod_empresa 			= $_SESSION['cod_empresa'];
	$cod_usuario_inclusao 	= $_SESSION['cod_usuario'];	
	$cod_caixa 				= $_SESSION['cod_caixa'];	

if (isset($_REQUEST['acao'])){
	
	if (isset($_REQUEST['cod_cliente'])) { $cod_cliente = $_REQUEST['cod_cliente']; } else { $cod_cliente = ''; }

	if ($_REQUEST['acao'] == "incluir"){
		
		$sql = "insert into comanda (cod_empresa, cod_cliente, cod_caixa, dt_inclusao, cod_usuario) values ('".limpa($cod_empresa)."', '".limpa($cod_cliente)."', ".$cod_caixa.", now(), ".$cod_usuario_inclusao.")";
		mysql_query($sql);

		//retorna a comanda criada
		$sql = "select max(cod_comanda) as nova_comanda from comanda where cod_empresa = ".$cod_empresa." and cod_cliente = ".$cod_cliente." and cod_usuario = ".$cod_usuario_inclusao."";
		
		$query = mysql_query($sql);
		$rs = mysql_fetch_array($query);
		$nova_comanda = $rs['nova_comanda'];

		echo "<script language='javascript'>window.location='comanda_lista.php?acao=listar_itens&cod_comanda=".$nova_comanda."&cod_cliente=".$cod_cliente."';</script>"; die;
		
	}
	
}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['id'])) {
			$tipo = $_REQUEST["id"];
		}
		
		$sql = "Select descricao from grupo_produtos where cod_grupo_produto = " . $tipo;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){
				$nome = $rs['descricao'];
			}
		}
	
	}
}
	
if((isset($_REQUEST['cod_cliente'])) && ($_REQUEST['cod_cliente'] != "")){
	$cod_cliente = $_REQUEST['cod_cliente'];
}

?>

		<script language="javascript" src="js/comanda.js"></script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="grupo_produtos.php">Grupo de Produtos</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Nova Comanda</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Cliente</h2>
		</div>
		<div class="panel-body">
			<form action="comanda_cliente.php" class="form-horizontal row-border" name='frm' method="post">
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Selecione o cliente</b></label>
					<div class="col-sm-4">
						<?php ComboCliente($cod_cliente, $cod_empresa); ?>
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn-success btn" onclick="NovoCliente();">Novo Cliente</button>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Criar Comanda</button>
						<button class="btn-default btn" onclick="javascript:window.location='comanda.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



<?php 
} // INCLUIR OU EDITAR
include('../include/rodape_interno2.php');?>