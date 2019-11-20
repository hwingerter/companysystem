<?php include('../../include/topo_interno_relatorio.php'); ?>

<?php 

$dt_inicial         = $_REQUEST["dt_inicial"];
$dt_final           = $_REQUEST["dt_final"];

?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="historico_vendas.php">Serviços mais lucrativos (Detalhes)</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Serviços mais lucrativos (Detalhes)</h1>
                    </div>
                    <div class="container-fluid">						


		<div class="row">
			<div class="col-sm-8">
                <button class="btn-default btn" onclick="location.href='servicos_mais_lucrativos.php?dt_inicial=<?php echo $dt_inicial ?>&dt_final=<?php echo $dt_final; ?>';">Voltar</button>
				<button class="btn-primary btn" onclick="window.print();">Imprimir</button>
			</div>
		</div>

		<br>


        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Serviços mais lucrativos</h2>
          	</div>

          <div class="panel-body">

            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="20">Data da Venda</th>
                            <th width="100">Cliente</th>
                            <th width="100">Profissional</th>
                            <th width="50">Serviço/Produto</th>
                            <th width="20">Qtd</th>
                            <th width="20">Valor Total</th>
                            <th width="20">Custo Produtos</th>
                            <th width="20">Comissões</th>
                            <th width="20">Lucro Bruto</th>
                            <td width="10">&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody>
    <?php

    $dt_inicial         = $_GET["dt_inicial"];
    $dt_final           = $_GET["dt_final"];
    $cod_servico        = $_GET["cod_servico"];

    $sql = "
    select      co.cod_comanda
                ,co.cod_cliente
                ,co.dt_inclusao
                ,c.nome
                ,p.nome as profissional
                ,case when ci.cod_produto is not null then pro.descricao else s.nome end as produto_servico
                ,ci.quantidade
                ,(ci.valor * ci.quantidade) as valor_venda
                ,ifnull(pro.custo,'0') as custo_produto
                ,ci.valor_comissao as comissao
                ,(ci.valor - ci.valor_comissao) as lucro_bruto
    from        comanda co
    inner join  clientes c on c.cod_cliente = co.cod_cliente
    inner join  comanda_item ci on ci.cod_comanda=co.cod_comanda
    left join   profissional p on p.cod_profissional = ci.cod_profissional
    left join   produtos pro on pro.cod_produto = ci.cod_produto
    left join   servico s on s.cod_servico = ci.cod_servico
    where       co.cod_empresa = ".$_SESSION['cod_empresa']."
    and         s.cod_servico = ".$cod_servico."
    
    ";

    if(isset($dt_inicial) && $dt_inicial != "")
    {
        $sql = $sql." and ci.dt_inclusao >= '".DataPhpMysql($dt_inicial)." 00:00:00' ";
    }

    if(isset($dt_final) && $dt_final != "")
    {
        $sql = $sql." and ci.dt_inclusao <= '".DataPhpMysql($dt_final)." 23:59:59' ";
    }

    $sql = $sql . "
    order by    co.dt_inclusao asc;
    ";

    //echo $sql;

    $query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

        $total_vendas = 0;
        $total_quantidade = 0;
        $total_custo_produtos = 0;
        $total_comissao = 0;
        $total_lucro_bruto = 0;
        

        while ($rs = mysql_fetch_array($query))
        {     	
            $cod_comanda = $rs['cod_comanda'];

            $cod_cliente = $rs['cod_cliente'];

            $dt_venda = DataMysqlPhp($rs['dt_inclusao']);

            $produto_servico = $rs['produto_servico'];

            $custo_produto = $rs['custo_produto'];

            $quantidade = $rs['quantidade'];

            $cliente = $rs['nome'];

            $profissional = $rs['profissional'];

            $comissao = $rs['comissao'];
            
            $valor_venda = $rs['valor_venda'];

            $lucro_bruto = $rs['lucro_bruto'];

            //total geral
            $total_valor_venda += $rs['valor_venda'];
            $total_quantidade += $rs['quantidade'];
            $total_custo_produtos += $rs['custo_produtos'];
            $total_comissao += $rs['comissao'];
            $total_lucro_bruto += $rs['lucro_bruto'];

            $voltar = urlencode(host."relatorios/vendas/servicos_mais_lucrativos_detalhes.php?cod_servico=".$cod_servico."&dt_inicial=".$dt_inicial."&dt_final=".$dt_final.";");

		?>
                        <tr>
                            <td align="left"><?php echo $dt_venda;?></td>
                            <td align="left"><?php echo $cliente;?></td>
                            <td align="left"><?php echo $profissional;?></td>
                            <td align="left"><?php echo $produto_servico;?></td>
                            <td align="left"><?php echo $quantidade;?></td>
                            <td align="left"><?php echo $valor_venda; ?></td>   
                            <td align="left"><?php echo $custo_produto; ?></td>   
                            <td align="left"><?php echo $comissao; ?></td> 
                            <td align="left"><?php echo $lucro_bruto; ?></td>
                            <td align="center">
                                <button class="btn-default btn" 
                                    onclick="location.href='../../comanda/comanda_historico_vendas_detalhes.php?cod_comanda=<?php echo $cod_comanda; ?>&cod_cliente=<?php echo $cod_cliente; ?>&voltar=<?php echo $voltar; ?>';"> Detalhes
                                </button>                                
                            </td>
                        </tr>
         <?php
			
        } // while
        
                        $total_valor_venda = number_format($total_valor_venda, 2, ',', '.');
                        $total_custo_produtos = number_format($total_custo_produtos, 2, ',', '.');
                        $total_comissao = number_format($total_comissao, 2, ',', '.');
                        $total_lucro_bruto = number_format($total_lucro_bruto, 2, ',', '.');
        ?>
                        <tr>
                            <td><b><?php echo $registros; ?></b></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>                            
                            <td align="left"><b><?php echo $total_quantidade; ?></td>
                            <td align="left"><b><?php echo $total_valor_venda; ?></td>
                            <td align="left"><b><?php echo $total_custo_produtos; ?></td>
                            <td align="left"><b><?php echo $total_comissao; ?></td>
                            <td align="left"><b><?php echo $total_lucro_bruto; ?></td>
                        </tr>
<?php
	} 
    else 
    { // registro
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