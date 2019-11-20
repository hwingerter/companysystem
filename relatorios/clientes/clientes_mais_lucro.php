<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Crédito dos Clientes</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Clientes que dão mais lucro</h1>
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
                <h2>Clientes que dão mais lucro</h2>
          	</div>

          <div class="panel-body">

            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Cliente</th>
                            <th width="50">Valor Vendas</th>
							<th width="10">Custo Produtos</th>
							<th width="10">Comissão</th>
							<th width="10">Lucro Bruto</th>
							<th width="1">Qtd Serv. Vendidos</th>
							<th width="1">Qtd Prod. Vendidos</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php

    $sql = "

    select		cli.nome
    ,( select sum(ci.valor) from comanda_item ci where ci.cod_empresa=c.cod_empresa and ci.cod_cliente=c.cod_cliente) as valor_vendas
    ,0.00 as custo_produtos
    ,0.00 as comissao
    ,( select sum(ci.valor) from comanda_item ci where ci.cod_empresa=c.cod_empresa and ci.cod_cliente=c.cod_cliente) as lucro_bruto
    ,(select sum(ci.quantidade) from comanda_item ci where ci.cod_empresa=c.cod_empresa and ci.cod_cliente=c.cod_cliente and ci.cod_produto is null) as qtd_serv_vendidos
    ,(select sum(ci.quantidade) from comanda_item ci where ci.cod_empresa=c.cod_empresa and ci.cod_cliente=c.cod_cliente and ci.cod_servico	 is null) as qtd_prod_vendidos
    from 		comanda c
    inner join	clientes cli on cli.cod_cliente = c.cod_cliente
    where		c.cod_empresa = ".$_SESSION['cod_empresa']."
    group by 	cli.nome
    order by 	lucro_bruto desc
    ";

    $query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

        while (($rs = mysql_fetch_array($query)))
        {     	
            $valor_venda = number_format($rs['valor_vendas'], 2, ',', '.');
            $custo_produtos = number_format($rs['custo_produtos'], 2, ',', '.');
            $comissao_fixa = number_format($rs['comissao_fixa'], 2, ',', '.');
            $lucro_bruto = number_format($rs['lucro_bruto'], 2, ',', '.');
            $qtd_serv_vendidos = $rs["qtd_serv_vendidos"];
            $qtd_prod_vendidos = $rs["qtd_prod_vendidos"];

		?>
                        <tr>
                            <td align="left"><?php echo $rs['nome'];?></td>
							<td align="left"><?php echo $valor_venda; ?></td>						
							<td align="left"><?php echo $custo_produtos; ?></td>
                            <td align="left"><?php echo $comissao_fixa; ?></td>
							<td align="left"><?php echo $lucro_bruto; ?></td>
							<td align="left"><?php echo $qtd_serv_vendidos; ?></td>
							<td align="left"><?php echo $qtd_prod_vendidos; ?></td>
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