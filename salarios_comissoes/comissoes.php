<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";;

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;


$cod_empresa = $_SESSION['cod_empresa'];

if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }


if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "lancar"){

			$lista = $_REQUEST['cod_profissional'];

			foreach ($lista as $profissional) {
				
				$sql = "select case when count(*) > 0 then 'sim' else 'nao' end as tem_registro from salario_comissao where cod_profissional = ".$profissional;
				$q = mysql_query($sql);
				$rs = mysql_fetch_array($q);

				$salario 			= $_REQUEST['salario_'.$profissional];
				$decimo_terceiro 	= $_REQUEST['decimo_terceiro_'.$profissional];
				$ferias 			= $_REQUEST['ferias_'.$profissional];

				if (!empty($salario)) { $salario =  ValorPhpMysql($salario); }else { $salario = 'NULL'; }
				if (!empty($decimo_terceiro)) { $decimo_terceiro =  ValorPhpMysql($decimo_terceiro); }else { $decimo_terceiro = 'NULL'; }
				if (!empty($ferias)) { $ferias =  ValorPhpMysql($ferias); }else { $ferias = 'NULL'; }


				if ($rs['tem_registro'] == "nao"){
			
					$sqlInsert = "insert into salario_comissao
								(cod_empresa, cod_profissional, salario,  decimo_terceiro, ferias) 
								values (".$cod_empresa.", ".$profissional.", ".$salario.", ".$decimo_terceiro.", ".$ferias."); ";

					mysql_query($sqlInsert);

				}else{

					$sqlUpdate = "
						UPDATE 	salario_comissao
						SET 	salario = ".$salario.",  decimo_terceiro = ".$decimo_terceiro.", ferias = ".$ferias."
						WHERE  	cod_empresa = ".$cod_empresa." AND cod_profissional = ".$profissional.";";

					//echo $sqlUpdate."<br>";

					mysql_query($sqlUpdate);

				}

			}

			//die;

			echo "<script language='javascript'>window.location='profissionais.php?sucesso=1';</script>";die;

		}
	}



?>

	<script language="javascript" src="../js/mascaramoeda.js"></script>

	<div class="static-content-wrapper">
	    <div class="static-content">
	        <div class="page-content">
	            <ol class="breadcrumb">
	                
				<li><a href="#">Principal</a></li>
				<li class="active"><a href="comissoes.php">Personalizar Comissões</a></li>

	            </ol>
	            <div class="page-heading">            
	                <h1>Personalizar Comissões</h1>
	                <div class="options"></div>
	            </div>
	            <div class="container-fluid">
	                
					<?php
					if ($sucesso == '1') {
					?>
					<div class="alert alert-dismissable alert-success">
						<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Comissão personalizada com sucesso!</strong>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					</div>
					<?php
					} else if ($sucesso == '2') {
					?>
					<div class="alert alert-dismissable alert-success">
						<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Comissão restaurada com sucesso!</strong>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					</div>				
					<?php
					}
					?>
				

					<div data-widget-group="group1">

							<div class="panel panel-default" data-widget='{"draggable": "false"}'>
								<div class="panel-heading">
									<h2>Lançamento</h2>
								</div>
									<div class="panel-body">

									<?php 	

									$sql = "
									select		s.cod_servico, s.nome, case when s.cod_tipo_comissao = 1 then concat(comissao_percentual,'%') else concat('R$',s.comissao_fixa) end as valor
									from 		servico s
									where		s.cod_empresa = ".$cod_empresa."
									order by	s.nome asc;
									";									

									$sql2 = "
									select		p.cod_profissional, p.nome
									from 		profissional p
									where		p.cod_empresa = ".$cod_empresa."
									order by	p.nome asc;
									";

									$query2 = mysql_query($sql2);

					 				?>

									<form action="profissionais.php" class="form-horizontal row-border" name='frm' method="post">

						              <input type="hidden" name="acao" value="lancar">

										<div class="form-group">

											<div class="table-responsive">
											    <table class="table" border="1" bordercolor="#EEEEEE" style="width:100%;">
											        <thead>
											            <tr>
															<th style="width:20%;">Funcionários</th>
															<th style="width:25%;">Serviços</th>
															<th style="width:25%;">Comissão (Percentual/Fixa)</th>
															<th style="width:10%;">&nbsp;</th>
											            </tr>
											        </thead>
											        <tbody>
											        	<?php 	

											        		while($rs2 = mysql_fetch_array($query2))
											        		{

											        		/*
											        		$salario = number_format($rs['salario'], 2, ',', '.');
											        		$decimo_terceiro = number_format($rs['decimo_terceiro'], 2, ',', '.');
											        		$ferias = number_format($rs['ferias'], 2, ',', '.');
															*/
											        	?>
								                        <tr>
															<td align="left">
																<?php echo $rs2['nome'];?>
																<input type="hidden" name="cod_profissional[]" value="<?php echo  $rs2['cod_profissional']; ?>">
															</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>

														</tr>
														<?php 
																$query = mysql_query($sql);
																while($rs = mysql_fetch_array($query)){
														 ?>
																<tr>
																	<td>&nbsp;</td>
																	<td><?php echo $rs['nome'];?></td>
																	<td <?php echo BuscaComissaoProfissional($cod_empresa, $rs2['cod_profissional'], $rs['cod_servico'], ""); ?> >
																	<?php 
																		$comissao = BuscaComissao($cod_empresa, $rs2['cod_profissional'], $rs['cod_servico'], "");
																		echo $comissao;
																	?></td>
																	<td style="text-align: center;"><a class="btn btn-success btn-label" href="personalizar_comissao.php?cod_servico=<?php echo $rs['cod_servico']; ?>&cod_profissional=<?php echo $rs2['cod_profissional']; ?>"><i class="fa fa-edit"></i>Personalizar</a>&nbsp;</td>
																</tr>
														<?php 	
																}

															} 
														?>
													</tbody>
												</table>
											</div>


										</div>

									</form>

								</div>
							</div>

	</div> <!-- .container-fluid -->

</div>
					
	
<?php 
}


include('../include/rodape_interno2.php');?>