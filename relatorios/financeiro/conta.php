<?php 

	include('../../include/topo_interno_relatorio.php'); 

	$cod_empresa = $_SESSION["cod_empresa"];

	
?>
<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Contas e Despesas</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Contas e Despesas</h1>
                    </div>
                    <div class="container-fluid">						


		<div class="row">
			<div class="col-sm-8">
				<button class="btn-primary btn" onclick="window.print();">Imprimir</button>
			</div>
		</div>

		<br>


<form action="conta.php" class="form-horizontal" name='frm' method="post">

	<input type='hidden' name='acao' value='buscar'>

        <div class="panel panel-sky">
            <div class="panel-heading">
                <h2></h2>

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
	order by c.dt_inclusao asc, c.cod_contaPai desc;
	";

	//echo $sql;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {
		while ($rs = mysql_fetch_array($query)){ 

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
		</tr>
		<?php
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
</form>

<?php include('../../include/rodape_interno_relatorio.php'); ?>
