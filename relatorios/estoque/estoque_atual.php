<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Estoque Atual</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Estoque Atual</h1>
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
                <h2>Estoque Atual</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="300">Produto</th>
                            <th width="50">Qtd</th>
                            <th width="20">Custo Unitário Médio</th>
                            <th width="20">Custo Total</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    
	//CARREGA LISTA
    $sql = "
    select		p.cod_produto, p.descricao
                
                ,((select sum(e1.quantidade) from estoque e1 where e1.cod_produto=p.cod_produto and e1.cod_tipo_movimentacao in (1,2,3))
                    -
                    (select sum(e1.quantidade) from estoque e1 where e1.cod_produto=p.cod_produto and e1.cod_tipo_movimentacao in (4,5,6,7))
                 ) as quantidade

                ,(select sum(e1.custo_medio_compra) from estoque e1 where e1.cod_produto=p.cod_produto) as CustoUnitarioMedio

    from 		produtos p
    where 		p.cod_empresa = ".$_SESSION['cod_empresa']."
    ";
	
	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){ 


            if(($rs["cod_tipo_movimentacao"] >= 4) && ($rs["cod_tipo_movimentacao"] <= 7))
            {
                $quantidade = "-".$rs['quantidade'];
            }else{
                $quantidade = $rs['quantidade'];	
            }

            $custo_total = number_format(($rs['CustoUnitarioMedio'] * $quantidade), 2);	
	    	
		?>
                        <tr>
                            <td align="left"><?php echo $rs['descricao'];?></td>
                            <td align="left"><?php echo $rs['quantidade'];?></td>
							<td align="left"><?php echo ValorMysqlPhp($rs['CustoUnitarioMedio']); ?></td>
							<td align="left"><?php echo ValorMysqlPhp($custo_total); ?></td>				
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