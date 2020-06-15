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
	

	$cod_empresa = $_SESSION['cod_empresa'];

	if(isset($_REQUEST['dt_inicial']) && ($_REQUEST['dt_inicial'] != ""))
	{
		$data_hoje = $_REQUEST['dt_inicial'];
	}
	else
	{
		$data_hoje = date('d/m/Y');
	}


	
	
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
	                    <h1>Pagar Profissionais</h1><br>
						<h5>(Salários, comissões e outros)</h5>
	                </div>

	                <div class="container-fluid">

						<div class="row">

							<div class="col-sm-12">

								<form action="listar_pagamento_comissoes.php" class="form-horizontal" name='frm' method="post">

									<div class="panel panel-sky">
										<div class="panel-heading">
											<h2>Filtros</h2>
										</div>
										<div class="panel-body">
											<div class="form-group">
												<label class="col-sm-2 control-label">Incluir comissões até: </label>
												<div class="col-sm-2">

													<input type="text" class="form-control mask" 
														id="dt_inicial" 
														name="dt_inicial" 
														data-inputmask-alias="dd/mm/yyyy" 
														data-inputmask="'alias': 'date'" 
														data-val="true" 
														data-val-required="Required" 
														placeholder="dd/mm/yyyy"
														value="<?php echo $data_hoje; ?>"
														>

												</div>
												<button class="btn-primary btn" onclick="javascript:document.frm.submit();">Buscar</button>
											</div>	
										</div>
									</div>	

								</form>

							</div>

						</div>

				        <div class="panel panel-sky">	

				            <div class="panel-heading">
								<p align='right'></p>
				          	</div>


<form action="realizar_pagamento.php" class="form-horizontal" name='frmListaComissoes' method="post">

	<div class="panel-body">

		  <div class="row">

            <div class="table-responsive">

                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Pagar</th>
                            <th width="200">Profissional</th>
							<th width="50">Valores<br>a Pagar</th>
							<th width="50">Valores<br>Bloqueados</th>
							<th width="100">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

    <?php

    $dt_inicial 	= DataPhpMysql($data_hoje)." 23:59:59";
    $data_busca		= DataPhpMysql($data_hoje);
    $data_pagamento = DataPhpMysql($data_hoje)." ".date("H:m:s");

		//CARREGA LISTA
	$sql = "
	select 		p.cod_profissional ,p.nome,
				(
					select		IFNULL(sum(ci.valor_comissao), 0.0)
					from 		comanda c 
					left join 	comanda_item ci on ci.cod_comanda = c.cod_comanda
					where 		ci.cod_profissional = p.cod_profissional
	                and 		ci.dt_inclusao <= '".$dt_inicial."'
					and 		ci.flg_comissao_paga = 'N'
	            ) as valores_a_pagar
	from 		profissional p
	WHERE		p.cod_empresa = ".$cod_empresa."
	group by 	p.cod_profissional ,p.nome 
	order by 	p.nome asc;
	";

	//echo $sql;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){ 

			$valores_a_pagar = $rs["valores_a_pagar"];

			if($valores_a_pagar > 0)
			{
				$podeSelecionar = "sim";
			}
			else
			{
				$podeSelecionar = "nao";
			}

		?>
		<tr>
			<td align="left">
				<input type="hidden" id="idProfissionalSelecionavel" value="<?php echo $podeSelecionar; ?>">
				<input type="checkbox" name="profissional" id="profissional" value="<?php echo $rs['cod_profissional'];?>" 
					<?php if ($podeSelecionar == "nao"){ echo " disabled "; } ?>
				>
			</td>
			<td align="left"><?php echo $rs['nome'];?></td>
			<td align="left"><?php echo $rs['valores_a_pagar']; ?></td>
			<td align="left"><?php echo $rs['valores_boqueados']; ?></td>
			<td align='center'>
				<a class="btn btn-success btn-label" href="conta_info.php?acao=alterar&id=<?php echo $rs['cod_conta'];?>"><i class="fa fa-edit"></i> Extrato</a>&nbsp;
				<a class="btn btn-default btn-label" href="conta.php?pergunta=<?php echo $rs['cod_conta'];?>"><i class="fa fa-times-circle"></i> Ajustar Saldo</a>
			</td>
		</tr>
    <?php
		} // while
	?>
		<tr>
			<td align="right" colspan="8"><b>Total selecionado: </b></td>
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
					<button type="button" class="btn-primary btn" onclick="javascript:PagarSelecionados();">Pagar selecionados</button>
				</div>
				<div class="col-sm-2">
					<button class="btn-danger btn" onclick="javascript:DefazerUltimoPagamento();';">Desfazer último pagamento</button>
				</div>
			</div>
          </div>
        </div>
    </div>
</div>

<input type="hidden" id="data_busca" name="data_busca" value="<?php echo $data_busca; ?>">
<input type="hidden" id="data_pagamento" name="data_pagamento" value="<?php echo $data_pagamento; ?>">

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