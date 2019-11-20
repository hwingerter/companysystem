<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="historico_vendas.php">Produtos mais lucrativos</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Produtos mais lucrativos</h1>
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
                <h2>Produtos mais lucrativos</h2>
          	</div>

          <div class="panel-body">

            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Produto</th>
                            <th width="50">Valor Vendas</th>
                            <th width="50">Custo Produtos</th>
                            <th width="50">Lucro Bruto</th>
                            <th width="50">Qtd Prod. Vendidos</th>
                            <th width="50">Clientes Distintos</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php

    $sql = "
    select 		pro.descricao as produto
                ,(
                select		sum(ci.valor)
                from		comanda_item ci
                where		ci.cod_produto = pro.cod_produto
                and 		ci.cod_empresa = pro.cod_empresa
                ) as valor_vendas
                ,0.00 as comissao
                ,0.00 as lucro_bruto
                ,(
                select		sum(ci.quantidade)
                from		comanda_item ci
                where		ci.cod_produto = pro.cod_produto
                and 		ci.cod_empresa = pro.cod_empresa
                ) as quantidade_vendidos
                ,(
                select		count(ci.cod_cliente)
                from		comanda_item ci
                where		ci.cod_produto = pro.cod_produto
                and 		ci.cod_empresa = pro.cod_empresa
                ) as clientes_distintos
    from		produtos pro
    where 		pro.cod_empresa = ".$_SESSION['cod_empresa']."
    order by 	valor_vendas
    ;
    ";

    $query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

        $total_vendas = 0;

        while (($rs = mysql_fetch_array($query)))
        {     	
            $produto = $rs['produto'];
            
            $valor_venda = number_format($rs['valor_vendas'], 2, ',', '.');

            $custo_produto = number_format($rs['custo_produto'], 2, ',', '.');

            $lucro_bruto = number_format($rs['lucro_bruto'], 2, ',', '.');
            
            $quantidade_vendidos = $rs['quantidade_vendidos'];

            $clientes_distintos = $rs['clientes_distintos'];


            //total geral
            $total_vendas += $rs['valor_vendas'];

		?>
                        <tr>
                            <td align="left"><?php echo $produto; ?></td>
                            <td align="left"><?php echo $valor_venda; ?></td>
                            <td align="left"><?php echo $custo_produto; ?></td>
                            <td align="left"><?php echo $lucro_bruto; ?></td>
                            <td align="left"><?php echo $quantidade_vendidos; ?></td>
                            <td align="left"><?php echo $clientes_distintos; ?></td>
                        </tr>
    <?php
			
        } // while
        
        $total_vendas = number_format($total_vendas, 2, ',', '.');
?>
                        <tr>
                            <td>&nbsp;</td>
                            <td align="left"><b><?php echo $total_vendas; ?></td>
                            <td>&nbsp;</td>
                            <td align="left"><?php echo $total_geral; ?></td>
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