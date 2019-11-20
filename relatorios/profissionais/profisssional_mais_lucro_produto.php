<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="profissional_mais_lucro_servico.php">Profissionais que geram mais lucro (com produtos)</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Profissionais que geram mais lucro (com produtos)</h1>
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
                <h2>Profissionais</h2>
          	</div>

          <div class="panel-body">

            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Profissional</th>
                            <th width="50">Valor Vendas</th>
							<th width="10">Custo Produtos</th>
							<th width="10">Comissão</th>
							<th width="10">Lucro Bruto</th>
							<th width="1">Qtd Prod. Vendidos</th>
							<th width="1">Clientes Distintos</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php

    $sql = "
        select			p.nome as profissional
                        ,sum(ci.valor)  as valor_venda
                        ,'0.00' as custo_produto
                        , sum((s.comissao_fixa * ci.quantidade)) as comissao
                        ,((sum(ci.valor))-(sum((s.comissao_fixa * ci.quantidade)))) as lucro_bruto
                        ,sum(ci.quantidade) as quant_prod_vendidos
                        ,(select count(distinct cod_cliente) from comanda_item ci where cod_empresa = c.cod_empresa and cod_profissional = p.cod_profissional) as clientes_distintos
        from			comanda c
        inner join		comanda_item ci on ci.cod_comanda = c.cod_comanda
        inner join		produtos s on s.cod_produto = ci.cod_produto
        inner join 		profissional p on p.cod_profissional = ci.cod_profissional
        where			c.cod_empresa = ".$_SESSION['cod_empresa']."
        order by		lucro_bruto desc
    ";

    $query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

        while (($rs = mysql_fetch_array($query)))
        {     	
            $profissional = $rs['profissional'];
            $valor_venda = number_format($rs['valor_venda'], 2, ',', '.');
            $custo_produtos = number_format($rs['custo_produtos'], 2, ',', '.');
            $comissao_fixa = number_format($rs['comissao_fixa'], 2, ',', '.');
            $lucro_bruto = number_format($rs['lucro_bruto'], 2, ',', '.');
            $qtd_serv_vendidos = $rs["qtd_serv_vendidos"];
            $clientes_distintos = $rs["clientes_distintos"];
		?>
                        <tr>
                            <td align="left"><?php echo $profissional;?></td>
							<td align="left"><?php echo $valor_venda; ?></td>						
							<td align="left"><?php echo $custo_produtos; ?></td>
                            <td align="left"><?php echo $comissao_fixa; ?></td>
							<td align="left"><?php echo $lucro_bruto; ?></td>
							<td align="left"><?php echo $qtd_serv_vendidos; ?></td>
							<td align="left"><?php echo $clientes_distintos; ?></td>
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