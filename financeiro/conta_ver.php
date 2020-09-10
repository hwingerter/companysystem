<?php 

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";;
	
	//*********** VERIFICA CREDENCIAIS DE USUáRIOS *************
	
	
	
	
	

	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_ver") {
			$credencial_ver = 1;
			break;
		}

	}

	$acao = '';
	
	
	$cod_usuario 	= $_SESSION["usuario_id"];
	$cod_grupo	 	= $_SESSION['cod_grupo_empresa'];
	$cod_empresa 	= $_SESSION['cod_empresa'];
	
	$cod_conta	 	= $_REQUEST['id'];
	$cod_fornecedor = $_REQUEST["cod_fornecedor"];
	$flg_paga 		= "N";
	$flg_quitada 	= "N";
	$flg_usoudagaveta = "N";

	
	if ($credencial_ver == '1') { //VERIFICA SE USUáRIO POSSUI ACESSO A ESSA áREA
				
		if (isset($_REQUEST['id'])) {
			$id = $_REQUEST["id"];
		}
		
		$sql = "
		select 		c.descricao, c.obs, f.empresa as fornecedor, c.parcela as numero_parcela
					,c.nota_fiscal, c.dt_nota_fiscal
		            ,c.obs
		from 		conta c
		inner join 	fornecedores f on f.cod_fornecedor = c.cod_fornecedor
		where 		c.cod_conta = ".$id.";";

		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){

				$descricao = $rs["descricao"];						
				$fornecedor = $rs["fornecedor"];				

				$nota_fiscal = $rs["nota_fiscal"];
				$obs = $rs["obs"];
				$parcelas = $rs["numero_parcela"];

				if ($rs["dt_nota_fiscal"] != ""){
					$data_nota_fiscal = DataMysqlPhp($rs["dt_nota_fiscal"]);
				}

			}
		}
			
	}

?>

		<script language="javascript" src="conta.js"></script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="conta.php">Contas e Despesas</a></li>

                            </ol>

        <div class="page-heading">            
            <h1>Adicionar Conta a Pagar ou Despesa</h1>
            <div class="options"></div>
        </div>
        <div class="container-fluid">
            

		<div data-widget-group="group1">

			<div class="panel panel-default" data-widget='{"draggable": "false"}'>

				<div class="panel-heading">
					<h2>Adicionar Conta a Pagar ou Despesa</h2>
				</div>

				<div class="panel-body">

					<form  class="form-horizontal" name='frm' >		

						<div class="form-group">
							<label class="col-sm-2 control-label"><b>Descrição</b></label>
							<div class="col-sm-8">
								<?php echo $descricao;?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><b>Fornecedor</b></label>
							<div class="col-sm-8">
							<?php 
								echo $fornecedor;
							?>
							</div>
						</div>

						<div class="form-group">
							<p class="mb20" style="border-bottom:1px solid black;">Parcelas</p>

							<div class="col-sm-4 col-sm-offset-1">
								<label class="col-sm-2 control-label"><b>Parcelas</b></label>
								<div class="col-sm-8"><?php echo $parcelas; ?>
								</div>
							</div>
						</div>


						<?php

							$sql = "
							select 		c.parcela, c.valor
										,case when c.flg_paga = 'S' then 'Sim' else 'Não' end as JafoiPaga
							            ,case when c.flg_usoudagaveta = 'S' then 'Sim' else 'Não' end as UsouGaveta
							            ,case when c.flg_quitar_automatico = 'S' then 'Sim' else 'Não' end as QuitadoAutomatico
							            ,date_format(c.dt_vencimento, '%d/%m/%Y') as dt_vencimento
							            ,date_format(c.dt_quitacao, '%d/%m/%Y') as dt_quitacao
							            ,date_format(c1.dt_abertura, '%d/%m/%Y') as caixa
							from 		conta c 
							left join	caixa c1 on c1.cod_caixa = c.cod_caixa
							where 		c.cod_contaPai = ".$id." or c.cod_conta = ".$id."  
							and 		c.cod_empresa = ".$cod_empresa."
							order by 	c.parcela asc;
							";

							$query = mysql_query($sql);
							$registros = mysql_num_rows($query);
							if ($registros > 0) {

							while ($rs = mysql_fetch_array($query)){

								$i = $rs["parcela"];

								if($rs['dt_quitacao'] != ""){
									$dt_quitacao = $rs['dt_quitacao'];
								}
								else{
									$dt_quitacao = "";		
								}
									
							?>

							<div id="Parcela_<?php echo $i;?>">

								<div class="form-group">
									<label class="col-md-2 control-label"><b><?php echo $i; ?>a Parcela</b></label>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label"><b>Valor(R$)</b></label>
									<div class="col-sm-8">
										<?php echo ValorMysqlPhp($rs['valor']); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"><b>Vencimento</b></label>
									<div class="col-sm-8">
										<?php echo $rs['dt_vencimento']; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"><b>Parcela já paga</b></label>
									<div class="col-sm-8">
										<?php echo $rs['JafoiPaga']; ?>
									</div>
								</div>
								<div class="form-group" id="UsouDaGaveta_<?php echo $i; ?>">
									<label class="col-sm-2 control-label"><b>Usou $ da Gaveta?</b></label>
									<div class="col-sm-8">
										<?php echo $rs['UsouGaveta']; ?>
									</div>
								</div>
								<div class="form-group" id="CaixaDia_<?php echo $i; ?>">
									<label class="col-sm-2 control-label"><b>Do caixa:</b></label>
									<div class="col-sm-8" id="IdCaixaDia_<?php echo $i; ?>">
										<?php echo $rs['caixa']; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"><b>Quitar automaticamente</b></label>
									<div class="col-sm-8">
										<?php echo $rs['QuitadoAutomatico']; ?>
									</div>
								</div>
								<div class="form-group" id="quitacao_<?php echo $i; ?>">
									<label class="col-sm-2 control-label"><b>Quitação</b></label>
									<div class="col-sm-8">
										<?php echo $dt_quitacao; ?>
									</div>
								</div>

							</div>

						<?php } ?>

						<p class="mb20" style="border-bottom:1px solid black;">Nota Fiscal</p>

						<div class="form-group">
							<label class="col-sm-2 control-label"><b>Nota Fiscal</label>
							<div class="col-sm-8">
								<?php echo $nota_fiscal;?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><b>Data NF</label>
							<div class="col-sm-8">
								<?php echo $data_nota_fiscal;?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><b>Observação</b></label>
							<div class="col-sm-8">
								<?php echo $obs; ?>
							</div>
						</div>

					</form>

				</div>

				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button class="btn-default btn" onclick="javascript:window.location='conta.php';">Voltar</button>
						</div>
					</div>
				</div>



<?php

	$sql = "
	select 		c.parcela, c.valor, c.dt_vencimento, c.flg_paga, c.flg_usoudagaveta, flg_quitar_automatico, dt_quitacao, cod_caixa
	from 		conta c
	where 		c.cod_contaPai = ".$id." or c.cod_conta = ".$id."  
	and 		c.cod_empresa = ".$cod_empresa."
	";
	
	//echo $sql;

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		while ($rs = mysql_fetch_array($query)){

			$parcela = $rs["parcela"];

			if($rs['dt_quitacao'] != ""){
				$dt_quitacao = DataMysqlPhp($rs['dt_quitacao']);	
			}
			else{
				$dt_quitacao = "";		
			}
			


			?>
			<script>

				document.getElementById("valor_<?php echo $parcela; ?>").value = "<?php echo ValorMysqlPhp($rs['valor']); ?>";
				document.getElementById("dt_vencimento_<?php echo $parcela; ?>").value = "<?php echo DataMysqlPhp($rs['dt_vencimento']); ?>";
				document.getElementById("Parcela_<?php echo $parcela; ?>").style.display = "block";

				document.getElementById("flg_paga_<?php echo $parcela; ?>").value = "<?php echo $rs['flg_paga']; ?>";
				document.getElementById("flg_usoudagaveta_<?php echo $parcela; ?>").value = "<?php echo $rs['flg_usoudagaveta']; ?>";

				ContaPaga('<?php echo $parcela; ?>', '<?php echo $rs["flg_paga"]; ?>');

				CarregaDataCaixa('CaixaDia_', '<?php echo $parcela; ?>', '<?php echo $cod_empresa; ?>', '<?php echo $rs['flg_usoudagaveta']; ?>', '<?php echo $rs['cod_caixa']; ?>');

				document.getElementById("dt_quitacao_<?php echo $parcela; ?>").value = "<?php echo $dt_quitacao; ?>";

				document.getElementById("flg_quitar_automatico_<?php echo $parcela; ?>").value = "<?php echo $rs['flg_quitar_automatico']; ?>";



			</script>


			<?php


		}
	}


}

	include('../include/rodape_interno2.php');

?>