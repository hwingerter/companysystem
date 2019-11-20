<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cartao_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cartao_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cartao_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cartao_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['id'])) {
		$id = $_REQUEST["id"];
	}
		
	$sql = "
	select 		c.bandeira, o.cod_tipo_operacao, o.descricao as tipo_operacao
				,c.taxa_cartao_debito, c.dias_repasse_cartao_debito_operadora
	            ,c.taxa_cartao_credito_avista, c.taxa_cartao_credito_parcelado, c.numero_maximo_parcelas
	            ,pc.descricao as tipo_prazo_cartao
	            ,case 
					when c.descontar_taxas_comissoes_bloquear_valores = '1' then 'Sim'
					else 'N�o'
				end as descontar_taxas_comissoes_bloquear_valores
	from 		cartao c
	inner join 	tipo_operacao o on o.cod_tipo_operacao = c.cod_tipo_operacao
	left join 	tipo_prazo_cartao pc on pc.cod_tipo_prazo = c.cod_tipo_prazo
	where 		c.cod_cartao = ".$id;

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){

			$bandeira = $rs["bandeira"];
			$cod_tipo_operacao = $rs["cod_tipo_operacao"];
			$tipo_operacao = $rs["tipo_operacao"];
			$taxa_cartao_debito = $rs["taxa_cartao_debito"];
			$dias_repasse_cartao_debito_operadora = $rs["dias_repasse_cartao_debito_operadora"];
			$taxa_cartao_credito_avista = $rs["taxa_cartao_credito_avista"];
			$taxa_cartao_credito_parcelado = $rs["taxa_cartao_credito_parcelado"];
			$numero_maximo_parcelas = $rs["numero_maximo_parcelas"];
			$tipo_prazo_cartao = $rs["tipo_prazo_cartao"];
			$descontar_taxas_comissoes_bloquear_valores = $rs["descontar_taxas_comissoes_bloquear_valores"];
			
		}
	}
	
?>

        <div id="wrapper">
            <div id="layout-static">
                
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="cartao.php">Cartão</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Cartão</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<script language="javascript" type="text/javascript" src="cartao.js"></script>-

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Visualizar Cartão</h2>
		</div>
		<div class="panel-body">
			<form action="cartao.php" class="form-horizontal row-border" name='frm' method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label"><b>Bandeira</b></label>
					<div class="col-sm-4">
						<label class="control-label"><?php echo $bandeira;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><b>Tipos de Operação</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $tipo_operacao; ?></label>
					</div>
				</div>

				<div id="QuadroDebito" style="border:0 solid black; padding:5px;">

					<div class="form-group">
						<label class="col-sm-3 control-label"><b>Taxa de Cartão de D�bito</b>(%)</label>
						<div class="col-sm-8">
							<label class="control-label"><?php echo $taxa_cartao_debito;?></label>
						</div>
					</div>				
					<div class="form-group">
						<label class="col-sm-3 control-label"><b>Repasse Operadora Cartão de D�bito</b>(dias corridos)</label>
						<div class="col-sm-8">
							<label class="control-label"><?php echo $dias_repasse_cartao_debito_operadora;?></label>
						</div>
					</div>

				</div>


				<div id="QuadroCredito" style="border:0 solid red; padding:5px;">

					<div class="form-group">
						<label class="col-sm-3 control-label"><b>Taxa de Cartão de Crédito a Vista</b>(%)</label>
						<div class="col-sm-8">
							<label class="control-label"><?php echo $taxa_cartao_credito_avista;?></label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><b>Taxa de Cartão de Crédito Parcelado</b>(%)</label>
						<div class="col-sm-8">
							<label class="control-label"><?php echo $taxa_cartao_credito_parcelado;?></label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><b>Número Máximo de Parcelas no Cartão de Crédito</b></label>
						<div class="col-sm-8">
							<label class="control-label"><?php echo $numero_maximo_parcelas;?></label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><b>Tipo de Prazo de Repasse do Cartão de Crédito</b></label>
						<div class="col-sm-8">
							<label class="control-label"><?php echo $tipo_prazo_cartao;?></label>
						</div>
					</div>

				</div>

				<div id="QuadroDescontar">

					<div class="form-group">
						<label class="col-sm-3 control-label"><b>Descontar Taxas das Comissões e Bloquear Valores</b></label>
						<div class="col-sm-8">
							<label class="control-label"><?php echo $descontar_taxas_comissoes_bloquear_valores; ?></label>
						</div>
					</div>

				</div>

			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-default btn" onclick="javascript:window.location='cartao.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>

<script language="javascript">
	SelecioneTipoOperacao("<?php echo $cod_tipo_operacao; ?>"); 
</script>



<?php 
} // VER
include('rodape.php')?>