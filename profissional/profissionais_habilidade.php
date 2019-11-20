<?php 

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$acao = '';
	

if (isset($_REQUEST['acao'])){
	
	$cod_profissional 	= $_REQUEST['cod_profissional'];
	$habilidade 		= $_REQUEST['selecionados'];	


	if ($_REQUEST['acao'] == "incluir"){
		
		$sql = "Delete from profissional_servico where cod_profissional = ". $cod_profissional;
		mysql_query($sql);

		$vet = split(",", $habilidade);

		$i=0;
		while ($i < count($vet)){

			$sql = "Insert into profissional_servico (cod_profissional, cod_servico) values (". $cod_profissional .",".$vet[$i].")";
			mysql_query($sql);

			$i++;
		}

		echo "<script language='javascript'>window.location='profissionais.php?sucesso=1';</script>";
		

	}
	
}

	$nome 		 		= $_REQUEST["nome"];
	$cod_profissional 	= $_REQUEST['id'];
	$cod_empresa 		= $_SESSION['cod_empresa'];

	$sql = "select cod_servico from profissional_servico where cod_profissional = ".$cod_profissional." order by cod_servico;";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		$i = 0;
		while ($rs = mysql_fetch_array($query)) { 
			$habilidade[$i] = $rs["cod_servico"];
			$i++;
		}
	}

?>

<script language="Javascript" type="text/javascript">
	
	
	function Habilidades(){

		var selecionados = "";

		for(i=0; i<document.frm.length; i++){
		
			if(document.frm[i].name == "habilidade"){

				if(document.frm[i].checked == true){

					if(selecionados ==""){
						selecionados = document.frm[i].value;
					}else{
						selecionados = selecionados + "," +  document.frm[i].value;
					}

				}
			}

		}

		document.getElementById("habilidades_selecionados").value = selecionados;

	}
	

	function ValidaForm(){

		Habilidades();

		document.frm.submit();

	}

</script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="grupos.php">Habilidades</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Habilidades</h1>
                                <div class="options"></div>
                            </div>
                            <div class="container-fluid">
                                

								<div data-widget-group="group1">

										<div class="panel panel-default" data-widget='{"draggable": "false"}'>
											<div class="panel-heading">
												<h2>Habilidades</h2>
											</div>
											<div class="panel-body">

												<form action="profissionais_habilidade.php" class="form-horizontal row-border" 
												name='frm' method="post">

									              <input type="hidden" name="acao" value="incluir">
									              <input type="hidden" name="cod_profissional" value="<?php echo $cod_profissional; ?>">
									              <input type="hidden" name="selecionados" id="habilidades_selecionados">

													<div class="form-group">
														<label class="col-md-1 control-label"><b>Nome</b></label>
														<div class="col-sm-8">
															<label class="control-label"><?php echo $nome;?></label>
														</div>
													</div>

													<div class="form-group">

														<div class="col-sm-12">


															<?php 
															$sql = "
															select 		cod_categoria, nome as categoria
															from 		categoria
															order by 	nome asc;
															";

															$query = mysql_query($sql);

															while ($rsCategoria = mysql_fetch_array($query))
															{ 
															 ?>

																<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
											                    <thead>
											                        <tr>
											                        	<th style="width:5%;">&nbsp;</th>
											                        	<th style="width:95%;"><?php echo $rsCategoria['categoria']; ?></th>
											                    </thead>
											                    <tbody>

																<?php 
																$sql2 = "
																select 		cod_servico, nome as servico
																from 		servico
																where		cod_empresa = ".$cod_empresa."
																and 		cod_categoria = ".$rsCategoria['cod_categoria']."
																order by 	nome asc;
																";

																$query2 = mysql_query($sql2);

																while ($rsServico = mysql_fetch_array($query2))
																{ 
																 ?>

											                        <tr>
											                        	<td align="center">
																			<label class="checkbox-inline icheck">
																				<input type="checkbox" name="habilidade" 
																				value="<?php echo $rsServico['cod_servico'];?>"

																				  <?php 
																				  for($i=0;$i<count($habilidade);$i++) {
																				  	if ($habilidade[$i] == $rsServico['cod_servico']) 
																				  	{ 
																				  		echo " checked "; 
																				  	}
																				  }
																				  ?>
																				>
																			</label>
											                        	</td>
																		<td><?php echo $rsServico['servico'];?></td>
											                        </tr>

																<?php 
																}
																?>

												                </tbody>
																</table>

															<br>

															<?php 
															}
															?>

														</div>

													</div>

												</form>


												<div class="panel-footer">
													<div class="row">
														<div class="col-sm-8 col-sm-offset-2">
															<button class="btn-primary btn" onclick="javascript:ValidaForm();">Gravar</button>
															<button class="btn-default btn" onclick="javascript:window.location='profissionais.php';">Voltar</button>
														</div>
													</div>
												</div>

											</div>
										</div>



                            </div> <!-- .container-fluid -->

<?php 
}
	
	include('../include/rodape_interno2.php');

?>