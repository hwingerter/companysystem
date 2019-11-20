<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USUáRIOS *************
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
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usuário tem a credencial de incluir ou editar	
	
	$acao = '';
	
	$id 		 = $_REQUEST['id'];
	$cod_empresa = $_SESSION['cod_empresa'];

	if (isset($_REQUEST["bandeira"])) { $bandeira = $_REQUEST["bandeira"]; } else { $bandeira = ""; }
	if (isset($_REQUEST["cod_tipo_operacao"])) { $cod_tipo_operacao = $_REQUEST["cod_tipo_operacao"]; } else { $cod_tipo_operacao = ""; }
	if (isset($_REQUEST["taxa_cartao_debito"])) { $taxa_cartao_debito = $_REQUEST["taxa_cartao_debito"]; } else { $taxa_cartao_debito = ""; }
	if (isset($_REQUEST["dias_repasse_cartao_debito_operadora"])) { $dias_repasse_cartao_debito_operadora = $_REQUEST["dias_repasse_cartao_debito_operadora"]; } else { $dias_repasse_cartao_debito_operadora = ""; }
	if (isset($_REQUEST["taxa_cartao_credito_avista"])) { $taxa_cartao_credito_avista = $_REQUEST["taxa_cartao_credito_avista"]; } else { $taxa_cartao_credito_avista = ""; }
	if (isset($_REQUEST["taxa_cartao_credito_parcelado"])) { $taxa_cartao_credito_parcelado = $_REQUEST["taxa_cartao_credito_parcelado"]; } else { $taxa_cartao_credito_parcelado = ""; }
	if (isset($_REQUEST["numero_maximo_parcelas"])) { $numero_maximo_parcelas = $_REQUEST["numero_maximo_parcelas"]; } else { $numero_maximo_parcelas = ""; }
	if (isset($_REQUEST["cod_tipo_prazo"])) { $cod_tipo_prazo = $_REQUEST["cod_tipo_prazo"]; } else { $cod_tipo_prazo = ""; }
	if (isset($_REQUEST["descontar_taxas_comissoes_bloquear_valores"])) { $descontar_taxas_comissoes_bloquear_valores = $_REQUEST["descontar_taxas_comissoes_bloquear_valores"]; } else { $descontar_taxas_comissoes_bloquear_valores = ""; }
	
	if (isset($_REQUEST['acao'])) {
		
		if ($_REQUEST['acao'] == "incluir"){
			
			//$sql = "insert into produtos (descricao, cod_fornecedor, cod_grupo_produto, quantidade, unidade, valor";
			//$sql .= ") values ('". limpa($descricao) ."',". limpa_int($cod_fornecedor) .",". limpa_int($cod_grupo_produto) .",'". ValorPhpMysql($quantidade) ."','". limpa($unidade) ."','". ValorPhpMysql($valor) ."')";
			
			$sql = "
			INSERT INTO cartao
			(`cod_empresa`,
			`bandeira`,
			`cod_tipo_operacao`,
			`taxa_cartao_debito`,
			`dias_repasse_cartao_debito_operadora`,
			`taxa_cartao_credito_avista`,
			`taxa_cartao_credito_parcelado`,
			`numero_maximo_parcelas`,
			`cod_tipo_prazo`,
			`descontar_taxas_comissoes_bloquear_valores`)
			VALUES
			('".$cod_empresa."',
			'".$bandeira."',
			'".$cod_tipo_operacao."',
			'".$taxa_cartao_debito."',
			'".$dias_repasse_cartao_debito_operadora."',
			'".$taxa_cartao_credito_avista."',
			'".$taxa_cartao_credito_parcelado."',
			'".$numero_maximo_parcelas."',
			'".$cod_tipo_prazo."',
			'".$descontar_taxas_comissoes_bloquear_valores."');
			";

			//echo $sql; die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='cartao.php?sucesso=1';</script>";
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			
			$sql = "
			UPDATE `cartao`
			SET
			`bandeira` = '".$bandeira."' ,
			`cod_tipo_operacao` = '".$cod_tipo_operacao."' ,
			`taxa_cartao_debito` = '".$taxa_cartao_debito."' ,
			`dias_repasse_cartao_debito_operadora` = '".$dias_repasse_cartao_debito_operadora."' ,
			`taxa_cartao_credito_avista` = '".$taxa_cartao_credito_avista."' ,
			`taxa_cartao_credito_parcelado` = '".$taxa_cartao_credito_parcelado."' ,
			`numero_maximo_parcelas` = '".$numero_maximo_parcelas."' ,
			`cod_tipo_prazo` = '".$cod_tipo_prazo."' ,
			`descontar_taxas_comissoes_bloquear_valores` = '".$descontar_taxas_comissoes_bloquear_valores."' 
			WHERE `cod_cartao` = ".$id.";
			";


			//echo $sql; die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='cartao.php?sucesso=2';</script>";
			
		}
		
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USUáRIO POSSUI ACESSO A ESSA áREA
		
	if (isset($_REQUEST['acao'])) 
	{
		if ($_REQUEST['acao'] == "alterar"){
			
			$acao = $_REQUEST['acao'];
			
			if (isset($_REQUEST['id'])) {
				$id = $_REQUEST["id"];
			}
			
			$sql = "
			select 		c.cod_cartao, c.bandeira, c.cod_tipo_operacao, c.taxa_cartao_credito_avista, c.taxa_cartao_credito_parcelado, c.taxa_cartao_debito
						,pc.descricao, c.dias_repasse_cartao_debito_operadora, c.descontar_taxas_comissoes_bloquear_valores, c.cod_tipo_prazo, c.numero_maximo_parcelas
			from 		cartao c
			left join 	tipo_prazo_cartao pc on pc.cod_tipo_prazo = c.cod_tipo_prazo
			where 		c.cod_cartao = ".$id." ";

			$query = mysql_query($sql);
			$registros = mysql_num_rows($query);
			if ($registros > 0) {
				if ($rs = mysql_fetch_array($query)){

					$bandeira = $rs["bandeira"];
					$cod_tipo_operacao = $rs["cod_tipo_operacao"];
					$taxa_cartao_debito = $rs["taxa_cartao_debito"];
					$dias_repasse_cartao_debito_operadora = $rs["dias_repasse_cartao_debito_operadora"];
					$taxa_cartao_credito_avista = $rs["taxa_cartao_credito_avista"];
					$taxa_cartao_credito_parcelado = $rs["taxa_cartao_credito_parcelado"];
					$numero_maximo_parcelas = $rs["numero_maximo_parcelas"];
					$cod_tipo_prazo = $rs["cod_tipo_prazo"];		
					$descontar_taxas_comissoes_bloquear_valores = $rs["descontar_taxas_comissoes_bloquear_valores"];
				}
			}
		
		}
		
	}
}
	
?>
	 <script language="javascript" type="text/javascript" src="cidade_ComboAjax.js"></script>
	<script language="javascript" type="text/javascript" src="cartao.js"></script>

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
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Cartão</h2>
		</div>
		<div class="panel-body">

			<form action="cartao_info.php" class="form-horizontal row-border" name='frm' method="post">
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Bandeira</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $bandeira;?>" name="bandeira" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipos de Operação</b></label>
					<div class="col-sm-8">
					<?php 
					if ($acao!="alterar"){
						ComboTiposOperacao("1"); 

					}else{
						ComboTiposOperacao($cod_tipo_operacao); 
					}
					?>
					</div>
				</div>

				<div id="QuadroDebito" style="border:0 solid black; padding:5px;">
					
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Taxa de Cartão de Débito</b>(%)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $taxa_cartao_debito;?>" name="taxa_cartao_debito" maxlength="10">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Repasse Operadora Cartão de Débito</b>(dias corridos)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $dias_repasse_cartao_debito_operadora;?>" name="dias_repasse_cartao_debito_operadora" maxlength="10">
						</div>
					</div>

				</div>


				<div id="QuadroCredito" style="border:0 solid red; padding:5px;">

					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Taxa de Cartão de Crédito a Vista</b>(%)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $taxa_cartao_credito_avista;?>" name="taxa_cartao_credito_avista" maxlength="10">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Taxa de Cartão de Crédito Parcelado</b>(%)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $taxa_cartao_credito_parcelado;?>" name="taxa_cartao_credito_parcelado" maxlength="10">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Número Máximo de Parcelas no Cartão de Crédito</b></label>
						<div class="col-sm-8">
						<?php
						if ($acao!="alterar"){
							ComboNumeroMaximoParcelasCartaoCredito("12"); 

						}else{
							ComboNumeroMaximoParcelasCartaoCredito($numero_maximo_parcelas); 
						}
						?>
						</div>
					</div>	

					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Tipo de Prazo de Repasse do Cartão de Crédito</b></label>
						<div class="col-sm-8">
						<?php
						if ($acao!="alterar"){
							ComboTipoRepasseCartaoCredito("1"); 

						}else{
							ComboTipoRepasseCartaoCredito($cod_tipo_prazo); 
						}
						?>
						</div>
					</div>

				</div>

				<div id="QuadroDescontar">
					
					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Descontar Taxas das Comissões e Bloquear Valores</b></label>
						<div class="col-sm-1">
							<input type="checkbox" class="form-control" name="descontar_taxas_comissoes_bloquear_valores" value="1"
								<?php if($descontar_taxas_comissoes_bloquear_valores == 1) { echo "checked"; } ?>
							>
						</div>
					</div>

				</div>

			</form>

			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
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
	<?php
 	
 	if ($acao != "alterar"){
 	?>
		//SelecioneTipoOperacao("0");

	<?php

	}else{
	?>
		SelecioneTipoOperacao("<?php echo $cod_tipo_operacao; ?>"); 

	<?php
	}
	?>
</script>

<?php 
}
	
include('../include/rodape_interno2.php');

?>