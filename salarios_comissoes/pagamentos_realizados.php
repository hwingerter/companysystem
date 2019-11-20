<?php 

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";;
	
	//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_incluir") {
			$credencial_incluir = 1;			break;
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

	$dt_pagamento_comissao = $_REQUEST['dt_pagamento_comissao'];


?>

	<script language="javascript" type="text/javascript" src="js/salarios_comissoes.js"></script>

                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="conta.php">Pagar Profissionais</a></li>
                            </ol>
							
                            <div class="page-heading">            
                                <h1>Pagamentos Realizados</h1><br>
								<h5>(Salários, comissões e outros)</h5>
                            </div>

                            <div class="container-fluid">

								<div class="row">
									<div class="col-sm-8">
										<button class="btn-primary btn" onclick="window.print();">Imprimir</button>
									</div>
								</div>

								<br>


        <div class="panel panel-sky">	
            <div class="panel-heading">
				<p align='left'>Pagamentos Realizados</p>
          </div>

          <div class="panel-body">

          	<form name="form1">

          		<input type="hidden" name="acao" value="buscar">

				<div class="form-group">
					<label class="col-sm-2 control-label">Data Pagamento</label>
					<div class="col-sm-3">

					<?php 

						$sql = "
						select 		date_format(dt_pagamento_comissao, '%Y-%m-%d %H:%i:%s') as dt_pagamento_comissao
						from 		comanda_item
						where		cod_empresa = ".$cod_empresa."
						and 		flg_comissao_paga = 'S'
						and 		dt_pagamento_comissao is not null
						group by	dt_pagamento_comissao
						order by	dt_pagamento_comissao  desc
						";

						if ($_REQUEST['dt_pagamento_comissao'] == "")
						{
							$query = mysql_query($sql);
							$rs = mysql_fetch_array($query);
							$dt_pagamento_comissao = $rs["dt_pagamento_comissao"];							
						}

						
						$query = mysql_query($sql);

					?>

						<select name="dt_pagamento_comissao" id="data_pagamento" class="form-control" onchange="javascript:document.form1.submit();">

							<?php 

							while ($rs = mysql_fetch_array($query)){ 

							?>

							<option value="<?php echo $rs['dt_pagamento_comissao']; ?>" 

								<?php if ($dt_pagamento_comissao == $rs['dt_pagamento_comissao']) { echo " Selected"; } ?>> <?php echo $rs['dt_pagamento_comissao']; ?> </option>

							<?php 

							}

							?>

						</select>

					</div>

				</div>	

			</form>

			<br><br>

            <div class="table-responsive">

                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Profissional</th>
							<th width="50">Valores Pagos</th>						
                        </tr>
                    </thead>
                    <tbody>

    <?php

	//CARREGA LISTA
	$sql = "
	select 		p.nome, sum( (ci.valor_comissao * ci.quantidade)) as valores_pagos
	from 		comanda c
	inner join 	comanda_item ci on ci.cod_comanda = c.cod_comanda
	inner join	profissional p on p.cod_profissional = ci.cod_profissional
	where 		ci.cod_empresa = ".$cod_empresa." 
	";
	
	if (isset($_REQUEST['acao'])){

		if ($_REQUEST['acao'] == "buscar"){

			if(isset($_REQUEST['dt_pagamento_comissao']) && ($_REQUEST['dt_pagamento_comissao'] != "")){
				$dt_pagamento_comissao = $_REQUEST['dt_pagamento_comissao'];
				$sql = $sql . " and ci.dt_pagamento_comissao = '".$dt_pagamento_comissao."' ";
			}

		}
	}
	else
	{
		$sql = $sql . " and ci.dt_pagamento_comissao = '".$dt_pagamento_comissao."' ";
	}

	$sql .= "
	order by p.nome asc;
	";

	//echo $sql;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		$total = 0;

		while (($rs = mysql_fetch_array($query))){ 

			$valores_pagos = ValorMysqlPhp($rs['valores_pagos']);

			$total += $rs['valores_pagos'];

		?>
		<tr>
			<td align="left"><?php echo $rs['nome'];?></td>
			<td align="left"><?php echo $valores_pagos; ?></td>
		</tr>
    <?php
		} // while
	?>
		<tr>
			<td align="right" colspan="8"><b>Total : <?php echo ValorMysqlPhp($total); ?></b></td>
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
			<div class="row">
				<div class="col-sm-2">
					<button class="btn-danger btn" onclick="javascript:DesfazerUltimoPagamento();">Desfazer último pagamento</button>
				</div>
			</div>
          </div>
        </div>
    </div>
</div>

</form>

<?php
 } // VER 
	
	include('../include/rodape_interno2.php');

?>

<script type="text/javascript">
	$(document).ready(function() {
	  $(":input[data-inputmask-mask]").inputmask();
	  $(":input[data-inputmask-alias]").inputmask();
	  $(":input[data-inputmask-regex]").inputmask("Regex");
	});
</script>