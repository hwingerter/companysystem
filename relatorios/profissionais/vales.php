<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="vale.php">Vale</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Vale</h1>
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
                <h2>Vale</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Data</th>
                            <th width="50">Profissional</th>
                            <th width="50">Valor Dinheiro</th>
                            <th width="50">Valor Cheque</th>
                            <th width="50">Observação</th>
                            <th width="50">Data do Caixa</th>
                            <th width="50">Responsável</th>
                            <th width="50">Pago</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    
	//CARREGA LISTA
    $sql = "
    select 		cg.dt_transacao, p.nome, cg.valor as valor_dinheiro, 0.0 as valor_cheque, cg.descricao, u.nome, cg.dt_transacao
    from 		caixa c
    inner join  caixa_gaveta cg on cg.cod_caixa=c.cod_caixa
    inner join	profissional p on p.cod_profissional = cg.cod_usuario
    inner join	usuarios u on u.cod_usuario = c.cod_usuario
    where		cg.cod_empresa = ".$_SESSION['cod_empresa']."
    and			cg.tipo_transacao = 'VALE'
    order by	cg.dt_transacao asc
	";
	
	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){ 
            
            $valor_dinheiro = number_format($rs['valor_dinheiro'], 2, ',', '.');
            $valor_cheque = number_format($rs['valor_cheque'], 2, ',', '.');


		?>
                        <tr>
                            <td align="left"><?php echo $rs['dt_transacao'];?></td>
                            <td align="left"><?php echo $rs['nome'];?></td>
                            <td align="left"><?php echo $valor_dinheiro;?></td>
                            <td align="left"><?php echo $valor_cheque;?></td>
                            <td align="left"><?php echo $rs['descricao'];?></td>
                            <td align="left"><?php echo $rs['nome'];?></td>
                            <td align="left"><?php echo $rs['dt_transacao'];?></td>
                            <td align="left">&nbsp;</td>
			
                        </tr>
    <?php
			
		} // while
	?>
                        <tr>
                            <td align="right" colspan="8"><b>Quantidade: <?php echo $registros; ?></b></td>
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

    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->

<?php include('../../include/rodape_interno_relatorio.php'); ?>