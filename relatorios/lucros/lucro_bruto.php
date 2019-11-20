<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="historico_vendas.php">Lucro Bruto</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Lucro Bruto</h1>
                    </div>
                    <div class="container-fluid">						


		<div class="row">
			<div class="col-sm-8">
                <button class="btn-default btn" onclick="location.href='lucro_bruto_filtro.php';">Voltar</button>
				<button class="btn-primary btn" onclick="window.print();">Imprimir</button>
			</div>
		</div>

		<br>


        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Lucro Bruto</h2>
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
                            <th width="50">Valor Vendas</th>
                            <th width="50">Custo Produtos</th>
                            <th width="50">Comissão</th>
                            <th width="50">Lucro Bruto</th>
                            <!--th width="50">&nbsp;</th-->
                        </tr>
                    </thead>
                    <tbody>
    <?php

    $dt_inicial         = $_REQUEST["dt_inicial"];
    $dt_final           = $_REQUEST["dt_final"];
    $cod_cliente        = $_REQUEST["cod_cliente"];
    $cod_profissional   = $_REQUEST["cod_profissional"];
    $cod_servico        = $_REQUEST["cod_servico"];
    $cod_produto        = $_REQUEST["cod_produto"];

    $sql = "
    select
        co.cod_comanda
        ,co.cod_cliente
        ,co.dt_inclusao as dt_venda
        ,cli.nome as cliente
        ,pro.nome as profissional
        ,case 
            when ci2.cod_servico is not null then serv.nome
            when ci2.cod_produto is not null then prod.descricao
        end as serv_prod
        ,(select sum((ci.valor * ci.quantidade)) from comanda_item ci where ci.cod_servico = serv.cod_servico and ci.cod_empresa = serv.cod_empresa ) as valor_vendas 
        ,'0,00' custo_produtos 
        ,( select sum((ci.valor_comissao * ci.quantidade)) from comanda_item ci where ci.cod_servico = serv.cod_servico and ci.cod_empresa = serv.cod_empresa ) as comissao 
        ,( ( select sum((ci.valor * ci.quantidade)) from comanda_item ci where ci.cod_servico = serv.cod_servico and ci.cod_empresa = serv.cod_empresa ) 
         - 
         ( select sum((ci.valor_comissao * ci.quantidade)) from comanda_item ci where ci.cod_servico = serv.cod_servico and ci.cod_empresa = serv.cod_empresa ) 
        ) as lucro_bruto 
    from servico serv 
    inner join  comanda_item ci2 on ci2.cod_servico = serv.cod_servico 
    inner join  comanda co on co.cod_comanda = ci2.cod_comanda
    inner join  clientes cli on cli.cod_cliente = co.cod_cliente
    left join   profissional pro on pro.cod_profissional = ci2.cod_profissional
    left join   produtos prod on prod.cod_produto = ci2.cod_produto
    where       serv.cod_empresa = ".$_SESSION['cod_empresa']."    
    ";

    if(isset($dt_inicial) && $dt_inicial != "")
    {
        $sql = $sql." and ci2.dt_inclusao >= '".DataPhpMysql($dt_inicial)." 00:00:00' ";
    }

    if(isset($dt_final) && $dt_final != "")
    {
        $sql = $sql." and ci2.dt_inclusao <= '".DataPhpMysql($dt_final)." 00:00:00' ";
    }

    if(isset($cod_cliente) && $cod_cliente != "")
    {
        $sql = $sql." and ci2.cod_cliente = ".$cod_cliente." ";
    }

    if(isset($cod_profissional) && $cod_profissional != "")
    {
        $sql = $sql." and ci2.cod_profissional = ".$cod_profissional." ";
    }
    

    if(isset($cod_servico) && $cod_servico != "")
    {
        $sql = $sql." and ci2.cod_servico = ".$cod_servico." ";
    }

    if(isset($cod_produto) && $cod_produto != "")
    {
        $sql = $sql." and ci2.cod_produto = ".$cod_produto." ";
    }


    $sql = $sql . "
    group by    serv.cod_servico ,serv.nome 
    having      valor_vendas is not null 
    order by    valor_vendas desc;
    ";

    //echo $sql;

    $query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

        $total_vendas = 0;
        $total_custo_produtos = 0;
        $total_comissao = 0;
        $total_lucro_bruto = 0;
        $total_horas_trabalhadas = 0;
        $total_quantidade_servicos_vendidos = 0;


        while ($rs = mysql_fetch_array($query))
        {     	
            $cod_servico = $rs['cod_servico'];

            $dt_venda = $rs['dt_venda'];

            $cliente = $rs['cliente'];

            $profissional = $rs['profissional'];

            $serv_prod = $rs['serv_prod'];
            
            $valor_venda = number_format($rs['valor_vendas'], 2, ',', '.');

            $custo_produtos = number_format($rs['custo_produtos'], 2, ',', '.');

            $comissao = number_format($rs['comissao'], 2, ',', '.');

            $lucro_bruto = number_format($rs['lucro_bruto'], 2, ',', '.');
            

            //total geral
            $total_vendas += $rs['valor_vendas'];
            $total_custo_produtos += $rs['custo_produtos'];
            $total_comissao += $rs['comissao'];
            $total_lucro_bruto += $rs['lucro_bruto'];

            $voltar = urlencode(host."relatorios/lucros/lucro_bruto.php?cod_servico=".$cod_servico."&dt_inicial=".$dt_inicial."&dt_final=".$dt_final.";");


		?>
                        <tr>
                            <td align="left"><?php echo DataMysqlPhp($dt_venda); ?></td>
                            <td align="left"><?php echo $cliente; ?></td>
                            <td align="left"><?php echo $profissional; ?></td>
                            <td align="left"><?php echo $serv_prod; ?></td>
                            <td align="left"><?php echo $valor_venda; ?></td>
                            <td align="left"><?php echo $custo_produtos; ?></td>
                            <td align="left"><?php echo $comissao; ?></td>
                            <td align="left"><?php echo $lucro_bruto; ?></td>
                            <!--td align="left">
                                <button class="btn-default btn" onclick="location.href='servicos_mais_lucrativos_detalhes.php?cod_servico=<?php echo $cod_servico; ?>&dt_inicial=<?php echo $dt_inicial ?>&dt_final=<?php echo $dt_final; ?>';">Detalhes</button>                                
                            </td-->
                        </tr>
         <?php
			
        } // while
        
        $total_vendas = number_format($total_vendas, 2, ',', '.');
        $total_custo_produtos = number_format($total_custo_produtos, 2, ',', '.');
        $total_comissao = number_format($total_comissao, 2, ',', '.');
        $total_lucro_bruto = number_format($total_lucro_bruto, 2, ',', '.');
        $total_horas_trabalhadas = number_format($total_horas_trabalhadas, 2, ',', '.');
        ?>
                        <tr>
                            <td style="font-weight: bold;"><?php  echo $registros; ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left"><b><?php echo $total_vendas; ?></td>
                            <td align="left"><b><?php echo $total_custo_produtos; ?></td>
                            <td align="left"><?php echo $total_comissao; ?></td>
                            <td align="left"><b><?php echo $total_lucro_bruto; ?></td>
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