<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="historico_itens_vendidos.php">Histórico de Itens Vendidos</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Histórico de Itens Vendidos</h1>
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
                <h2>Histórico de Itens Vendidos</h2>
          	</div>

          <div class="panel-body">

            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Data da Venda</th>
                            <th width="50">Cliente</th>
                            <th width="50">Profissional</th>
                            <th width="50">Serviço/Produto</th>
                            <th width="50">Qtd</th>
                            <th width="50">Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php

    $sql = "
    select 		co.dt_inclusao
    ,c.nome
    ,p.nome as profissional
    ,case when ci.cod_produto is not null then pro.descricao else s.nome end as produto_servico
    ,ci.quantidade
    ,(select sum(ci.valor) from comanda_item ci where ci.cod_empresa = co.cod_empresa and ci.cod_cliente=c.cod_cliente and ci.cod_comanda=co.cod_comanda) as valor_total
    from 		comanda co
    inner join 	clientes c on c.cod_cliente = co.cod_cliente
    inner join	comanda_item ci on ci.cod_comanda=co.cod_comanda
    left join	profissional p on p.cod_profissional = ci.cod_profissional
    left join	produtos pro on pro.cod_produto = ci.cod_produto
    left join	servico s on s.cod_servico = ci.cod_servico
    where 		co.cod_empresa = ".$_SESSION['cod_empresa']."
    order by	co.dt_inclusao asc;
    ";

    $query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

        $total_geral = 0;

        while (($rs = mysql_fetch_array($query)))
        {     	
            $dt_venda = DataMysqlPhp($rs['dt_inclusao']);

            $produto_servico = $rs['produto_servico'];

            $quantidade = $rs['quantidade'];

            $profissional = $rs['profissional'];
            
            $valor_total = number_format($rs['valor_total'], 2, ',', '.');
            
            $total_geral += $rs['valor_total'];

		?>
                        <tr>
                            <td align="left"><?php echo $dt_venda;?></td>
                            <td align="left"><?php echo $rs['nome'];?></td>
                            <td align="left"><?php echo $profissional;?></td>
                            <td align="left"><?php echo $produto_servico;?></td>
                            <td align="left"><?php echo $quantidade;?></td>
							<td align="left"><?php echo $valor_total; ?></td>						
                        </tr>
    <?php
			
        } // while
        
        $total_geral = number_format($total_geral, 2, ',', '.');
	?>
                        <tr>
                            <td align="left"><b>Quantidade: <?php echo $registros; ?></b></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
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