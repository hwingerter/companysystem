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


if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "lancar"){

			$lista = $_REQUEST['cod_profissional'];

			foreach ($lista as $profissional) {
				
				$sql = "select case when count(*) > 0 then 'sim' else 'nao' end as tem_registro from profissional_rendimentos where cod_profissional = ".$profissional;
				//echo "<br>".$sql;die;
				$q = mysql_query($sql);
				$rs = mysql_fetch_array($q);

				if (!empty($salario)) { $salario = $salario; }else { $salario = 'NULL'; }
				if (!empty($decimo_terceiro)) { $decimo_terceiro =  $decimo_terceiro; }else { $decimo_terceiro = 'NULL'; }
				if (!empty($ferias)) { $ferias =  $ferias; }else { $ferias = 'NULL'; }

				$salario 			= number_format($_REQUEST['salario_'.$profissional], 1);
				$decimo_terceiro 	= number_format($_REQUEST['decimo_terceiro_'.$profissional], 1);
				$ferias 			= number_format($_REQUEST['ferias_'.$profissional], 1);

				if ($rs['tem_registro'] == "nao"){
			
					$sqlInsert = "insert into profissional_rendimentos
								(cod_empresa, cod_profissional, salario,  decimo_terceiro, ferias) 
								values (".$cod_empresa.", ".$profissional.", ".$salario.", ".$decimo_terceiro.", ".$ferias."); ";

					//echo "<br>".$sqlInsert;die;

					mysql_query($sqlInsert) or die (mysql_error());

				}else{

					$sqlUpdate = "
						UPDATE 	profissional_rendimentos
						SET 	salario = ".$salario.",  decimo_terceiro = ".$decimo_terceiro.", ferias = ".$ferias."
						WHERE  	cod_empresa = ".$cod_empresa." AND cod_profissional = ".$profissional.";";

					//echo "<br>".$sqlUpdate."<br>";die;

					mysql_query($sqlUpdate)or die (mysql_error());

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
				<li class="active"><a href="comanda.php">Comandas</a></li>

	            </ol>
	            <div class="page-heading">            
	                <h1>Salário, Décimo Terceiro e Férias</h1>
	                <div class="options"></div>
	            </div>
	            <div class="container-fluid">
	                
					<div data-widget-group="group1">

							<div class="panel panel-default" data-widget='{"draggable": "false"}'>
								<div class="panel-heading">
									<h2>Lançamento</h2>
								</div>
									<div class="panel-body">

									<?php 	

									$sql = "
									select		p.cod_profissional, p.nome
												,sc.salario, sc.ferias, sc.decimo_terceiro
									from		profissional p
									left join 	profissional_rendimentos sc on sc.cod_empresa=p.cod_empresa and sc.cod_profissional=p.cod_profissional
									where		p.cod_empresa = ".$cod_empresa."
									order by	p.nome asc;
									";

									//echo $sql;die;

									$query = mysql_query($sql);

					 				?>

									<form action="profissionais.php" class="form-horizontal row-border" name='frm' method="post">

						              <input type="hidden" name="acao" value="lancar">

										<div class="form-group">

											<div class="table-responsive">
											    <table class="table" border="1" bordercolor="#EEEEEE" style="width:100%;">
											        <thead>
											            <tr>
															<th width="100">Funcionários</th>
															<th width="20">Salário</th>
															<th width="20">Décimo Terceiro</th>
															<th width="20">Férias</th>
											            </tr>
											        </thead>
											        <tbody>
											        	<?php 	

											        		while($rs = mysql_fetch_array($query))
											        		{

											        		$salario = number_format($rs['salario'], 2, ',', '.');
											        		$decimo_terceiro = number_format($rs['decimo_terceiro'], 2, ',', '.');
											        		$ferias = number_format($rs['ferias'], 2, ',', '.');
											        

											        	?>
								                        <tr>
															<td style="width:25%;" align="left"><?php echo $rs['nome'];?>
																<input type="hidden" name="cod_profissional[]" value="<?php echo  $rs['cod_profissional']; ?>">
															</td>
															<td style="width:25%;"><input type="text" class="form-control" name="salario_<?php echo  $rs['cod_profissional']; ?>" id="salario" maxlength="10"
																	value="<?php echo $salario;?>"
																	onKeyPress="return(moeda(this,'.',',',event));" >
																</td>
															<td style="width:25%;"><input type="text" class="form-control" name="decimo_terceiro_<?php echo  $rs['cod_profissional']; ?>" id="decimo_terceiro" maxlength="10"
																	value="<?php echo $decimo_terceiro;?>"
																	onKeyPress="return(moeda(this,'.',',',event));" ></td>
															<td style="width:25%;"><input type="text" class="form-control" name="ferias_<?php echo  $rs['cod_profissional']; ?>" id="ferias" maxlength="10"
																	value="<?php echo $ferias;?>"
																	onKeyPress="return(moeda(this,'.',',',event));" ></td>
														</tr>
														<?php 	} ?>
													</tbody>
												</table>
											</div>


										</div>

									</form>

									<div class="panel-footer">
										<div class="row">
											<div class="col-sm-8">
												<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar lançamentos</button>
											</div>
										</div>
									</div>

								</div>
							</div>

	            </div> <!-- .container-fluid -->
					
	
<?php 
}


include('../include/rodape_interno2.php');?>