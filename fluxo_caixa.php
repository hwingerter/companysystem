<?php include('topo.php');
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	$credencial_boleto = 0;
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_boleto") {
			$credencial_boleto = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if (isset($_REQUEST['data_ini'])) { $data_ini = $_REQUEST['data_ini']; } else { $data_ini = ''; }
	if (isset($_REQUEST['data_fim'])) { $data_fim = $_REQUEST['data_fim']; } else { $data_fim = ''; }
	if (isset($_REQUEST['cod_cliente'])) { $cod_cliente = $_REQUEST['cod_cliente']; } else { $cod_cliente = ''; }
	if (isset($_REQUEST['cod_financeiro'])) { $cod_financeiro = $_REQUEST['cod_financeiro']; } else { $cod_financeiro = ''; }
	
	
	if ($excluir != '') {
		$sql = "delete from fluxo_caixa where cod_fluxo = ". $excluir;
		mysql_query($sql);
		
		$excluir = '1';
	}
	
	//FUN��O QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	$sql = "Select COUNT(cod_fluxo) as total from fluxo_caixa FC, financeiro F where F.cod_financeiro = FC.cod_financeiro";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['data_ini'] != ''){ $sql = $sql . " and FC.vencimento >= '". DataPhpMysql($data_ini) ."' "; $_SESSION['busca_data_ini'] = $data_ini; } else { $_SESSION['busca_data_ini'] = ''; }
			if ($_REQUEST['data_fim'] != ''){ $sql = $sql . " and FC.vencimento <= '". DataPhpMysql($data_fim) ."' "; $_SESSION['busca_data_fim'] = $data_fim; } else { $_SESSION['busca_data_fim'] = ''; }
			if ($_REQUEST['cod_cliente'] != ''){ $sql = $sql . " and FC.cod_cliente = ". $cod_cliente; $_SESSION['busca_cod_cliente'] = $cod_cliente; } else { $_SESSION['busca_cod_cliente'] = ''; }
			if ($_REQUEST['cod_financeiro'] != ''){ $sql = $sql . " and FC.cod_financeiro = ". $cod_financeiro; $_SESSION['busca_cod_financeiro'] = $cod_financeiro; } else { $_SESSION['busca_cod_financeiro'] = ''; }
			
		}
	} else {
		
		if (isset($_SESSION['busca_data_ini'])){
			if ($_SESSION['busca_data_ini'] != '') {
				$sql = $sql . " and FC.vencimento >= '". DataPhpMysql($_SESSION['busca_data_ini']) ."' ";
				$data_ini = $_SESSION['busca_data_ini'];
			}
		}
		
		if (isset($_SESSION['busca_data_fim'])){
			if ($_SESSION['busca_data_fim'] != '') {
				$sql = $sql . " and FC.vencimento <= '". DataPhpMysql($_SESSION['busca_data_fim']) ."' ";
				$data_fim = $_SESSION['busca_data_fim'];
			}
		}
		
		if (isset($_SESSION['busca_cod_financeiro'])){
			if ($_SESSION['busca_cod_financeiro'] != '') {
				$sql = $sql . " and FC.cod_financeiro = ". $_SESSION['busca_cod_financeiro'];
				$cod_financeiro = $_SESSION['busca_cod_financeiro'];
			}
		}
		
		if (isset($_SESSION['busca_cod_cliente'])){
			if ($_SESSION['busca_cod_cliente'] != '') {
				$sql = $sql . " and FC.cod_cliente = ". $_SESSION['busca_cod_cliente'];
				$cod_cliente = $_SESSION['busca_cod_cliente'];
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
	
?>
        <div id="wrapper">
            <div id="layout-static">
				<?php include('menu.php');?>
                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="fluxo_caixa.php">Fluxo de Caixa</a></li>

                            </ol>
							
                            <div class="page-heading">            
                                <h1>Fluxo de Caixa</h1>
                                <div class="options">
						  	  <?php 
							  if ($credencial_incluir == '1') {
							  ?>
								<a class="btn btn-midnightblue btn-label" href="fluxo_caixa_info.php"><i class="fa fa-plus-circle"></i> Novo</a>
							  <?php
							  }
							  ?>	
								</div>
                            </div>
                            <div class="container-fluid">
<script language="JavaScript">
	function paginacao () {
  		document.forms[0].action = "fluxo_caixa.php";
	  	document.forms[0].submit();
	}
</script>
							
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
					<br><a class="btn btn-success" href="fluxo_caixa.php?excluir=<?php echo $pergunta;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="fluxo_caixa.php">Não</a>
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
<form action="fluxo_caixa.php" class="form-horizontal row-border" name='frm' method="post">
	<input type='hidden' name='acao' value='buscar'>
<div class="row">
    <div class="col-sm-12">

	<div class="panel panel-sky">
		<div class="panel-heading">
			<h2>Filtros</h2>
		</div>
		<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data Inicio</b></label>
					<div class="col-sm-6">
						<input type="text" class="form-control mask" data-inputmask="'alias': 'date'" name="data_ini" value="<?php echo $data_ini; ?>"> 
					</div>
					<div class="col-sm-3"><p class="help-block">dd/mm/yyyy</p></div>					
				</div><br>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data Fim</b></label>
					<div class="col-sm-6">
						<input type="text" class="form-control mask" data-inputmask="'alias': 'date'" name="data_fim" value="<?php echo $data_fim; ?>"> 
					</div>
					<div class="col-sm-3"><p class="help-block">dd/mm/yyyy</p></div>
				</div><br>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Cliente</b></label>
					<div class="col-sm-8">
						<?php ComboCliente($cod_cliente);?>
					</div>
				</div><br>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descrição</b></label>
					<div class="col-sm-8">
						<?php ComboFinanceiro($cod_financeiro);?>
					</div>
				</div><br>				
								
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
					</div>
				</div>
			</div>
		</div>
	</div>	

        <div class="panel panel-sky">
            <div class="panel-heading">
                <h2>Listagem do Fluxo de Caixa</h2>
				<p align='right'>
				<select name='pagina' class="form-control" style="width: 60px;" onChange="javascript:paginacao();">
				  	<?php for ($i=1; $i<=$paginas; $i++) {?>
					<option value="<?php echo $i; ?>" <?php if ($pagina == $i) { echo " Selected"; }?>><?php echo $i;?></option>
					<?php
						  }
					?>
				</select>
				</p>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">CÓDIGO</th>
							<th width="180">Descrição</th>
							<th width="180">Cliente</th>
							<th width="100">Número Documento</th>
							<th width="80">Vencimento</th>
							<th width="80">Pagamento</th>
							<th width="50">Parcelas</th>
							<th width="80">Valor</th>
							<th width="200">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
		//CARREGA LISTA
	$sql = "select FC.*, F.descricao, F.tipo from fluxo_caixa FC, financeiro F where F.cod_financeiro = FC.cod_financeiro ";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['data_ini'] != ''){ $sql = $sql . " and FC.vencimento >= '". DataPhpMysql($data_ini) ."' "; }
			if ($_REQUEST['data_fim'] != ''){ $sql = $sql . " and FC.vencimento <= '". DataPhpMysql($data_fim) ."' "; }
			if ($_REQUEST['cod_cliente'] != ''){ $sql = $sql . " and FC.cod_cliente = ". $cod_cliente; }
			if ($_REQUEST['cod_financeiro'] != ''){ $sql = $sql . " and FC.cod_financeiro = ". $cod_financeiro; }
		}
	} else {
		
		if (isset($_SESSION['busca_data_ini'])){
			if ($_SESSION['busca_data_ini'] != '') {
				$sql = $sql . " and FC.vencimento >= '". DataPhpMysql($_SESSION['busca_data_ini']) ."' ";
			}
		}
		
		if (isset($_SESSION['busca_data_fim'])){
			if ($_SESSION['busca_data_fim'] != '') {
				$sql = $sql . " and FC.vencimento <= '". DataPhpMysql($_SESSION['busca_data_fim']) ."' ";
			}
		}
		
		if (isset($_SESSION['busca_cod_financeiro'])){
			if ($_SESSION['busca_cod_financeiro'] != '') {
				$sql = $sql . " and FC.cod_financeiro = ". $_SESSION['busca_cod_financeiro'];
			}
		}
		
		if (isset($_SESSION['busca_cod_cliente'])){
			if ($_SESSION['busca_cod_cliente'] != '') {
				$sql = $sql . " and FC.cod_cliente = ". $_SESSION['busca_cod_cliente'];
			}
		}
		
	}
	$sql .= " order by FC.vencimento asc";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		$valor_total = 0;
		while (($rs = mysql_fetch_array($query)) && ($contador<$final)){ 
			$contador = $contador + 1; //Contador
	    	if ($contador>$inicio) { //Condi�ao para mostrar somente os registros maiores
				
				if ($rs['tipo'] == 'R') { $cor = "green"; } else if ($rs['tipo'] == 'D') { $cor = "red"; }
		?>
                        <tr>
                            <td align="left"><?php echo $rs['cod_fluxo'];?></td>
							<td align="left"><?php echo $rs['descricao'];?></td>
							<td align="left">
							<?php 
							if ($rs['cod_cliente'] != '') { echo ExibeCliente($rs['cod_cliente']); }
							?>
							</td>
							<td align="left">
							<?php 
							echo "<font color='blue'>". RetornaNumeroDocumentoBoleto($rs['cod_fluxo']) . "</font>";
							?>
							</td>							
							<td align="left"><?php echo DataMysqlPhp($rs['vencimento']);?></td>
							<td align="left"><?php 
							if ($rs['pagamento'] != '') { 
								echo "<font color='green'><b>". DataMysqlPhp($rs['pagamento']) . "</b></font>"; 
							} else {
								if (date('Y-m-d') > $rs['vencimento']) {
									echo "<font color='red'><b>Atrasado</b></font>";
								}
							}
							?></td>
							<td align="left"><?php echo $rs['parcela'] . " / ". $rs['total_parcelas'];?></td>							
							<td align="left"><?php echo "<font color='". $cor ."'><b>". number_format($rs['valor'],2,',','.') . "</b></b></font>";?></td>
                            <td align='center'>
					  	  <?php 
						  if ($credencial_editar == '1') {
						  ?>							
							<a class="btn btn-success btn-label" href="fluxo_caixa_info.php?acao=alterar&id=<?php echo $rs['cod_fluxo'];?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;&nbsp;
					  	  <?php 
						  }
						  if ($credencial_excluir == '1') {
						  ?>
							<a class="btn btn-danger btn-label" href="fluxo_caixa.php?pergunta=<?php echo $rs['cod_fluxo'];?>"><i class="fa fa-times-circle"></i> Excluir</a>&nbsp;&nbsp;
						  <?php
						  }
						  ?>	
							<a class="btn btn-info btn-label" href="fluxo_caixa_ver.php?id=<?php echo $rs['cod_fluxo'];?>"><i class="fa fa-eye"></i> Ver</a>&nbsp;&nbsp;
					  	  <?php 
						  if (($credencial_boleto == '1') && ($rs['tipo'] == 'R')) {
						  ?>
						  <a class="btn btn-success btn-label" href="dados_boleto.php?id=<?php echo $rs['cod_fluxo'];?>"><i class="fa fa-barcode"></i> Gerar Boleto</a>
						  <?php
						  }
						  ?>						  							
							</td>
                        </tr>
    <?php
			} // Contador
			
			if ($rs['tipo'] == 'R') { 
				$valor_total += $rs['valor'];
			} else if ($rs['tipo'] == 'D') { 
				$valor_total -= $rs['valor'];
			}
			
		} // while
	?>
                        <tr>
							<td align="right" colspan="8"><b>Valor Total: <?php echo number_format($valor_total,2,',','.'); ?></b></td>
                            <td align="right"><b>Total de registro: <?php echo $totalregistro; ?></b></td>
                        </tr>
<?php
	} else { // registro
	?>
                        <tr>
                            <td align="center" colspan="9">Não tem nenhum registro!</td>
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
                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
                    </div>
<?php
 } // VER 
	
include('rodape.php')?>