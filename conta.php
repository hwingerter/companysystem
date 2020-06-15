<?php include('topo.php');
	
	//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USUÁRIO POSSUI ACESSO A ESSA ÁREA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if ($excluir != '') {
		$sql = "delete from conta where cod_contaPai = ".$excluir." or cod_conta = ".$excluir."";
		mysql_query($sql);
		
		$excluir = '1';
	}
	
	//FUNÇÃ£O QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	$sql = "Select COUNT(cod_conta) as total from conta  ";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " where descricao like '%".$_REQUEST['nome']."%' ";
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
	$resto = $totalregistro % $registrosPagina; // Pega o resto da divisÃ£o
	$paginas = intval($paginas); // Converte o resultado para inteiro
	if ($resto > 0) { $paginas = $paginas + 1; } // Se o resto maior do que 0, soma a var paginas para a paginaçÃ£o ficar correta
	
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

	$cod_empresa = $_SESSION['cod_empresa'];


	if(isset($_REQUEST['acao']) && ($_REQUEST['acao'] == "buscar")){

		if($_REQUEST['cod_fornecedor'] != ""){
			$cod_fornecedor = $_REQUEST['cod_fornecedor'];
		}else{
			$cod_fornecedor = "";
		}

	}

	
?>
        <div id="wrapper">
            <div id="layout-static">
				<?php include('menu.php');?>
                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="conta.php">Contas e Despesas</a></li>
                            </ol>
							
                            <div class="page-heading">            
                                <h1>Contas e Despesas</h1>
                                <div class="options">
						  	  <?php 
							  if ($credencial_incluir == '1') {
							  ?>
								<a class="btn btn-midnightblue btn-label" href="conta_info.php"><i class="fa fa-plus-circle"></i> Novo</a>
							  <?php
							  }
							  ?>	
								</div>
                            </div>
                            <div class="container-fluid">
							<script language="JavaScript">
								function paginacao () {
							  		document.forms[0].action = "cartao.php";
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
					<strong>Deseja realmente excluir a conta número <?php echo $pergunta; ?> ?</strong><br>
					<br><a class="btn btn-success" href="conta.php?excluir=<?php echo $pergunta;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="conta.php">Não</a>
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

</form>

<form action="conta.php" class="form-horizontal" name='frm' method="post">

	<input type='hidden' name='acao' value='buscar'>

<div class="row">
    <div class="col-sm-12">

		<div class="panel panel-sky">
			<div class="panel-heading">
				<h2>Filtros</h2>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">Fornecedor</label>
					<div class="col-sm-6">
						<?php ComboFornecedor($cod_fornecedor, $cod_empresa); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Tipo</label>
					<div class="col-sm-8">
						<label class="radio-inline icheck">
							<input type="radio" name="status" value="N" <?php if($_REQUEST['status'] == "N") {echo " checked "; } ?> >&nbsp;A Pagar
						</label>
						<label class="radio-inline icheck">
							<input type="radio" name="status" value="S" <?php if($_REQUEST['status'] == "S") {echo " checked "; } ?> >&nbsp;Já Quitadas
						</label>
						<label class="radio-inline icheck">
							<input type="radio" name="status" value="" <?php if($_REQUEST['status'] == "") {echo " checked "; } ?> >&nbsp;Todas
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Data Inicial</label>
					<div class="col-sm-2">

						<input type="text" class="form-control mask" 
							id="dt_inicial" 
							name="dt_inicial" 
							data-inputmask-alias="dd/mm/yyyy" 
							data-inputmask="'alias': 'date'" 
							data-val="true" 
							data-val-required="Required" 
							placeholder="dd/mm/yyyy"
							value="<?php if (isset($_REQUEST['dt_inicial'])){ if ($_REQUEST['dt_inicial'] != ""){ echo $_REQUEST['dt_inicial']; } }?>"
							>

					</div>
					<label class="col-sm-2 control-label">Data Final</label>
					<div class="col-sm-2">

						<input type="text" class="form-control mask" 
							id="dt_final" 
							name="dt_final" 
							data-inputmask-alias="dd/mm/yyyy" 
							data-inputmask="'alias': 'date'" 
							data-val="true" 
							data-val-required="Required" 
							placeholder="dd/mm/yyyy"
							value="<?php if (isset($_REQUEST['dt_final'])){ if ($_REQUEST['dt_final'] != ""){ echo $_REQUEST['dt_final']; } }?>"
							>

					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-1">
							<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>



        <div class="panel panel-sky">
            <div class="panel-heading">
                <h2>Listagem de Contas</h2>
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
                            <th width="50">Codigo</th>
                            <th width="50">Inclusão</th>
							<th width="200">Descrição</th>
							<th width="200">Fornecedor</th>
							<th width="50">Parcela</th>
							<th width="100">Valor</th>
							<th width="100">Vencimento</th>
							<th width="50">Quitação</th>
							<th width="300">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
		//CARREGA LISTA
	$sql = "
	select 		case when c.cod_contaPai is null then c.cod_conta else c.cod_contaPai end cod_conta
				,c.descricao, f.empresa, c.valor
				,DATE_FORMAT(c.dt_inclusao, '%d/%m/%Y') as dt_inclusao
				,DATE_FORMAT(c.dt_vencimento, '%d/%m/%Y') as dt_vencimento
            	,DATE_FORMAT(c.dt_quitacao, '%d/%m/%Y') as dt_quitacao
	            ,c.cod_empresa
	            ,case when
					(select count(*) from conta c1 where c1.cod_contaPai = c.cod_contaPai and c1.cod_empresa = 8) > 1
	                then concat(convert(c.parcela, char(5))
									,'/'
	                                , convert((select count(*) from conta c1 where c1.cod_contaPai = c.cod_contaPai and c1.cod_empresa = 8), char(5))) 
	                end as parcela
	from 		conta c
	inner join 	fornecedores f on f.cod_fornecedor = c.cod_fornecedor
	where		c.cod_empresa = ".$cod_empresa."
	";
	
	if (isset($_REQUEST['acao'])){

		if ($_REQUEST['acao'] == "buscar"){
		
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " and c.descricao like '%".$_REQUEST['nome']."%' ";
			}

			if(isset($_REQUEST['dt_inicial']) && ($_REQUEST['dt_inicial'] != "")){
				$dt_inicial = DataPhpMysql($_REQUEST['dt_inicial'])." 00:00:00";
				$sql = $sql . " and c.dt_inclusao >= '".$dt_inicial."' ";
			}

			if(isset($_REQUEST['dt_final']) && ($_REQUEST['dt_final'] != "")){
				$dt_final = DataPhpMysql($_REQUEST['dt_final'])." 23:59:59";
				$sql = $sql . " and c.dt_inclusao <= '".$dt_final."' ";
			}

			if (isset($_REQUEST['status']))
			{
				if($_REQUEST['status'] == "N"){
					$sql = $sql . " and c.flg_paga = 'N' ";

				}elseif($_REQUEST['status'] == "S"){
					$sql = $sql . " and c.flg_paga = 'S' ";
				}
			}

		}
	}
	$sql .= "
	order by 	c.cod_contaPai desc;
	";

	//echo $sql;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {
		while (($rs = mysql_fetch_array($query)) && ($contador<$final)){ 
			$contador = $contador + 1; //Contador
	    	if ($contador>$inicio) { //Condiçao para mostrar somente os registros maiores
		?>
                        <tr>
                            <td align="left"><?php echo $rs['cod_conta'];?></td>
                            <td align="left"><?php echo $rs['dt_inclusao'];?></td>
							<td align="left"><?php echo $rs['descricao']; ?></td>
							<td align="left"><?php echo $rs['empresa']; ?></td>
							<td align="left"><?php echo $rs['parcela']; ?></td>
							<td align="left"><?php echo $rs['valor']; ?></td>
							<td align="left"><?php echo $rs['dt_vencimento']; ?></td>
							<td align="left"><?php echo $rs['dt_quitacao']; ?></td>
                            <td align='center'>
					  	  <?php 
						  if ($credencial_editar == '1') {
						  ?>							
							<a class="btn btn-success btn-label" href="conta_info.php?acao=alterar&id=<?php echo $rs['cod_conta'];?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;
					  	  <?php 
						  }
						  if ($credencial_excluir == '1') {
						  ?>
							<a class="btn btn-danger btn-label" href="conta.php?pergunta=<?php echo $rs['cod_conta'];?>"><i class="fa fa-times-circle"></i> Excluir</a>
						  <?php
						  }
						  ?>	
							<a class="btn btn-info btn-label" href="conta_ver.php?id=<?php echo $rs['cod_conta'];?>"><i class="fa fa-eye"></i> Ver</a>
							</td>
                        </tr>
    <?php
			} // Contador
		} // while
	?>
                        <tr>
                            <td align="right" colspan="8"><b>Total de registro: <?php echo $registros; ?></b></td>
                        </tr>
<?php
	} else { // registro
	?>
                        <tr>
                            <td align="center" colspan="7">Nenhum registro encontrado!</td>
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
	
include('rodape.php')
?>

<script type="text/javascript">
	$(document).ready(function() {
	  $(":input[data-inputmask-mask]").inputmask();
	  $(":input[data-inputmask-alias]").inputmask();
	  $(":input[data-inputmask-regex]").inputmask("Regex");
	});
</script>