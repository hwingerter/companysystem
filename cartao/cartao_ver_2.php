<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cartao_ver") {
			$credencial_ver = 1;
			break;
		}
	}

	if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA

		if (isset($_REQUEST['acao'])){
			
			if ($_REQUEST['acao'] == "alterar"){
				
				$acao = $_REQUEST['acao'];
				
				if (isset($_REQUEST['id'])) {
					$id = $_REQUEST["id"];
				}
				
				$sql = "
				select 		c.bandeira, o.descricao as tipo_operacao
							,c.taxa_cartao_debito, c.dias_repasse_cartao_debito_operadora
				            ,c.taxa_cartao_credito_avista, c.taxa_cartao_credito_parcelado, c.numero_maximo_parcelas
				            ,pc.descricao
				            ,case 
								when c.descontar_taxas_comissoes_bloquear_valores = '1' then 'Sim'
								else 'N�o'
							end as descontar_taxas_comissoes_bloquear_valores
				from 		cartao c
				inner join 	tipo_operacao o on o.cod_tipo_operacao = c.cod_tipo_operacao
				left join 	tipo_prazo_cartao pc on pc.cod_tipo_prazo = c.cod_tipo_prazo
				where 		c.cod_empresa = ".$id;
				$query = mysql_query($sql);
				$registros = mysql_num_rows($query);
				if ($registros > 0) {
					if ($rs = mysql_fetch_array($query)){

						$bandeira = $rs["bandeira"];
						$tipo_operacao = $rs["tipo_operacao"];
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
	
?>
	 <script src="cidade_ComboAjax.js"></script>
        <div id="wrapper">
            <div id="layout-static">
                
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="cartao.php">Cart�o</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Cart�o</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Cart�o</h2>
		</div>
		<div class="panel-body">

			<form action="cartao_info.php" class="form-horizontal row-border" name='frm' method="post">
		
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Bandeira</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $bandeira;?>" name="bandeira" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipos de Opera��o</b></label>
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
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Taxa de Cart�o de D�bito</b>(%)</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $taxa_cartao_debito;?>" name="taxa_cartao_debito" maxlength="10">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Repasse Operadora Cart�o de D�bito</b>(dias corridos)</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $dias_repasse_cartao_debito_operadora;?>" name="dias_repasse_cartao_debito_operadora" maxlength="10">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Taxa de Cart�o de Cr�dito � Vista</b>(%)</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $taxa_cartao_credito_avista;?>" name="taxa_cartao_credito_avista" maxlength="10">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Taxa de Cart�o de Cr�dito Parcelado</b>(%)</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $taxa_cartao_credito_parcelado;?>" name="taxa_cartao_credito_parcelado" maxlength="10">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>N�mero M�ximo de Parcelas no Cart�o de Cr�dito</b></label>
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
					<label class="col-sm-2 control-label"><b>Tipo de Prazo de Repasse do Cart�o de Cr�dito</b></label>
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
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descontar Taxas das Comiss�es e Bloquear Valores</b></label>
					<div class="col-sm-1">
						<input type="checkbox" class="form-control" name="descontar_taxas_comissoes_bloquear_valores" value="1"
							<?php if($descontar_taxas_comissoes_bloquear_valores == 1) { echo "checked"; } ?>
						>
					</div>
				</div>
			</form>

			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='profissionais.php';">Cancel</button>
					</div>
				</div>
			</div>

		</div>
	</div>



        </div> <!-- .container-fluid -->
    </div> <!-- #page-content -->
</div>
<?php 
}
	
include('rodape.php')?>