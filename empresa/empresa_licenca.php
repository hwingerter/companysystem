<?php

	require_once "../include/topo_interno2.php";

	require_once "../include/funcoes.php";

	require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if ($excluir != '') {
		$sql = "delete from empresas where cod_empresa = ". $excluir;
		mysql_query($sql);
		
		$excluir = '1';
	}
	
	//FUN��O QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	$sql = "Select COUNT(cod_empresa) as total from empresas  ";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " where empresa like '%".$_REQUEST['nome']."%' ";
			}
		}
	}	
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)) {
			$totalregistro = $rs['total'];
		}
	}
	
	
  	// Calcula a quantidade de paginas
	$registrosPagina = 30; // Define a quantidade de registro por Paginas
	$paginas = $totalregistro / $registrosPagina; // Calcula o total de paginas
	$resto = $totalregistro % $registrosPagina; // Pega o resto da divis�o
	$paginas = intval($paginas); // Converte o resultado para inteiro
	if ($resto > 0) { $paginas = $paginas + 1; } // Se o resto maior do que 0, soma a var paginas para a pagina��o ficar correta
	
	if (isset($_REQUEST['pagina'])) {
		$pagina = $_REQUEST['pagina']; // recupera a pagina
	} else { // Primeira pagina
		$pagina = 1;
	}
	
   $inicio = ( $pagina - 1 ) * $registrosPagina; //Defini o inicio da lista
   $final = $registrosPagina + $inicio; //Define o final da lista
   $contador = 0; //Seta variavel de Contador
   
   // Converte para inteiro
   $pagina = intval($pagina);	
	

	$cod_usuario	= $_SESSION['usuario_id'];
	$cod_grupo		= $_SESSION['cod_grupo'];
	$cod_empresa	= $_REQUEST['cod_empresa'];

	if ((isset($_REQUEST['acao'])) && ($_REQUEST['acao'] == "gerar_boleto"))
	{
		$sql = "select max(b.cod_empresa_licenca) as nova_licenca from empresas_licenca b where b.cod_empresa = " . $cod_empresa;
		$query = mysql_query($sql);
		$rs = mysql_fetch_array($query);
		$nova_licenca = $rs['nova_licenca'];

		$link_boleto = $_REQUEST['link_boleto'];

		//echo strlen($link_boleto);die;
		
		if ($link_boleto!= "")
		{
			$sql = "update empresas_licenca 
			set boleto = '".$link_boleto."'
			where cod_empresa_licenca = ".$nova_licenca."
			";
			//echo $sql;die;
			mysql_query($sql);
		}

		?>
			<script>window.open('<?php echo $link_boleto; ?>');</script>
		
		<?php		
	}


?>

                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">

						<div class="page-heading">            
							<h1>Empresa (Licença)</h1>
							<div class="options">
							
							</div>
						</div>
						<div class="container-fluid">
							
		<form name="form1" method="post">
						<?php
						if ($sucesso == '1') {
						?>
						<div class="alert alert-dismissable alert-success">
							<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados gravados com sucesso!</strong>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						</div>
						<?php
						} else if ($sucesso == '2') {
						?>
						<div class="alert alert-dismissable alert-success">
							<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados alterados com sucesso!</strong>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						</div>				
						<?php
						}
						
						if ($pergunta != '') {
						?>
						<div class="alert alert-dismissable alert-info">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>Deseja realmente excluir o código número <?php echo $pergunta; ?> ?</strong><br>
							<br><a class="btn btn-success" href="empresas.php?excluir=<?php echo $pergunta;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="empresas.php">Não</a>
						</div>				
						<?php
						}
						
						if ($excluir != '') {
						?>
						<div class="alert alert-dismissable alert-danger">
							<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Registro excluido com sucesso!</strong>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						</div>				
						<?php
						}
						?>

	<form action="empresas.php" class="form-horizontal row-border" name='frm' method="post">

		<input type='hidden' name='acao' value='buscar'>



		<div class="row">

		<div class="form-group">
			<a class="btn btn-success btn-label" href=empresa_licenca_info.php?acao=alterar&cod_empresa=<?php echo $cod_empresa;?>>
				<i class="fa fa-edit"></i>Renovar Licença
			</a>&nbsp;
		</div>

        <div class="panel panel-sky">
		
            <div class="panel-heading">
                <h2>Histórico de Licença</h2>
          </div>
          <div class="panel-body">
            <div class="table-vertical">
                <table class="table" class="table table-striped" border="1" bordercolor="#EEEEEE">
                    <thead>
						<tr>
							<td colspan="7" style="text-align:center; font-weight:bold;">Vingência do Contrato</td>
						</tr>
                        <tr>
                            <th width="10">#</th>
							<th width="100">Plano</th>
							<th width="100">Início da Licença</th>
							<th width="100">Fim da licença</th>
							<th width="100">Dias para renovação</th>
							<th width="100">Situação</th>
							<th width="10">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
		//CARREGA LISTA
	$sql = "

	select 		el.cod_empresa_licenca
				,l.descricao as licenca
				,el.dt_inicio
				,el.dt_vencimento
				,el.valor
				,el.boleto
				,case when el.flg_situacao = 'A' then 'Ativo' else 'Inativo' end as situacao
	from 		empresas e
	inner join	empresas_licenca el on el.cod_empresa = e.cod_empresa
	inner join	licencas l on l.cod_licenca = el.cod_licenca
	where 		e.cod_empresa = ".$cod_empresa."
	order by	el.cod_empresa_licenca asc;
	";
	
	//echo $sql;

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);

	$url_retorno = urlencode("../empresa/empresa_licenca.php?cod_empresa=".$cod_empresa);

	if ($registros > 0) {

		$i = 1;

		while (($rs = mysql_fetch_array($query)) && ($contador<$final)){ 

			$cod_empresa_licenca = $rs['cod_empresa_licenca'];

			$dt_inicio = strtotime($rs['dt_inicio']);

			$dia_vencimento = strtotime($rs['dt_vencimento']);

			$DiasRenovacao = intval(($dia_vencimento - $dt_inicio) / 86400)-1;

			$licenca = $rs['licenca'];

			$valor = $rs['valor'];

			$contador = $contador + 1; //Contador

			$boleto = $rs['boleto'];

	    	if ($contador>$inicio) { //Condi�ao para mostrar somente os registros maiores
		?>
                        <tr>
							<td align="left"><?php echo $i;?></td>
                            <td align="left"><?php echo $rs['licenca'];?></td>
							<td align="left"><?php echo DataMysqlPhp($rs['dt_inicio']); ?></td>
							<td align="left"><?php echo DataMysqlPhp($rs['dt_vencimento']);?></td>
							<td align="left">
							<?php 
									if ($DiasRenovacao > 0) {
										echo $DiasRenovacao;
									}
									elseif ($DiasRenovacao == 0) {
										echo "<span style='color:red;'>Renove o seu plano!</span>";
									}
									elseif ($DiasRenovacao < 0) {
										echo "<span style='color:red;'>Plano Vencido! Favor renovar.</span>";
									}
								?>
							</td>
							<td align="left"><?php echo $rs['situacao'];?></td>
                            <td align='center'>
					  	  <?php 
						  if ($boleto != '') {
						  ?>							
							<a class="btn btn-success btn-label" href="<?php echo $boleto; ?>" target="_blank">
								<i class="fa fa-edit"></i>Regerar Boleto
							</a>
					  	  <?php 
						  }
						  ?>	
							</td>
                        </tr>
    <?php
			} // Contador

		$i++;
		} // while
	?>
                        <tr>
                            <td align="right" colspan="7"><b>Total de registro: <?php echo $registros; ?></b></td>
                        </tr>
<?php
	} else { // registro
	?>
                        <tr>
                            <td align="center" colspan="7">Não tem nenhum registro!</td>
                        </tr>
<?php
	}
?>		
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
</div>
</form>

<button class="btn-default btn" onclick="location.href='empresas.php';">Voltar</button>

                            </div> <!-- .container-fluid -->

<?php
 } // VER 
	
 include('../include/rodape_interno2.php');

?>