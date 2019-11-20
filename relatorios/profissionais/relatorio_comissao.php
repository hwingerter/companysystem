<?php include('../../include/topo_interno_relatorio.php'); ?>

<?php

//FILTRO

$dt_inicial         = $_REQUEST["dt_inicial"];
$dt_final           = $_REQUEST["dt_final"];
$cod_profissional   = $_REQUEST["cod_profissional"];
$voltar             = "../relatorios/profissionais/relatorio_comissao.php";

?>


<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="recebimento_clientes_filtro.php">Relatório de Comissão</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Relatório de Comissão</h1>
                    </div>
                    <div class="container-fluid">						


		<div class="row">
			<div class="col-sm-8">
                <button class="btn-default btn" onclick="location.href='relatorio_comissao_filtro.php';">Voltar</button>
                &nbsp;
				<button class="btn-primary btn" onclick="window.print();">Imprimir</button>				
			</div>
		</div>

		<br>

        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Relatório de Comissão</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Data Venda</th>
                            <th width="50">Serviço ou Produto</th>
                            <th width="50">Cliente</th>
                            <th width="50">Total Comissão</th>
                            <th width="50">Valores a processar</th>
                            <th width="50">Valores<br>pagos</th>
                            <th width="50">Valores<br>bloqueados</th>
                            <th width="50">Data Pgtos<br>Realizados</th>
                            <th width="5">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    
	//CARREGA LISTA
    $sql = "
    select		c.cod_comanda, ci.cod_comanda_item, c.cod_cliente,
                ci.percentual_desconto,
                c.dt_inclusao as dt_venda,
                case
                    when ci.cod_servico <> '' then s.nome
                    when ci.cod_produto <> '' then prod.descricao
                end as servico_produto,
                c1.nome,
                ci.cod_tipo_comissao,
                ci.quantidade,
                ci.valor,
                ci.valor_comissao,
                case ci.flg_comissao_paga
                    when 'S' then ci.valor_comissao
                    else '0.00'
                end as valores_pagos
                ,date_format(ci.dt_pagamento_comissao, '%d/%m/%Y') as dt_pagamento_comissao
    from 		comanda c  
    inner join 	comanda_item ci on ci.cod_comanda = c.cod_comanda
    left join	servico s on s.cod_servico = ci.cod_servico
    left join 	produtos prod on prod.cod_produto = ci.cod_produto
    left join 	profissional p on p.cod_profissional = ci.cod_profissional
    inner join 	clientes c1 on c1.cod_cliente = c.cod_cliente
    where 		ci.cod_empresa = ".$_SESSION['cod_empresa']."
    ";
    
    if(isset($cod_profissional) && $cod_profissional != "")
    {
        $sql = $sql." and p.cod_profissional = " . $cod_profissional;
        $voltar .= "?cod_profissional=" . $cod_profissional;
    }

    if(isset($dt_inicial) && $dt_inicial != "")
    {
        $sql = $sql." and c.dt_inclusao >= '".DataPhpMysql($dt_inicial)." 00:00:00' ";

        if ($voltar == "" ? $voltar .= "?dt_inicial=" . $dt_inicial : $voltar .= "&dt_inicial=" . $dt_inicial);
    }

    if(isset($dt_final) && $dt_final != "")
    {
        $sql = $sql." and c.dt_inclusao <= '".DataPhpMysql($dt_final)." 00:00:00' ";

        if ($voltar == "" ? $voltar .= "?dt_final=" . $dt_final : $voltar .= "&dt_final=" . $dt_final);

    }

    $sql = $sql." order by 	dt_venda asc ";

    //echo $voltar;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

        //$total = 0;

		while (($rs = mysql_fetch_array($query))){ 

            $dt_venda           = DataMysqlPhp($rs["dt_venda"]);
            $nome               = $rs["nome"];
            $servico_produto    = $rs["servico_produto"];
            $quantidade         = $rs["quantidade"];
            $valor_venda        = $rs["valor"];
            $cod_tipo_comissao  = $rs["cod_tipo_comissao"];
            $valor_comissao     = $rs["valor_comissao"];
            $percentual_desconto= $rs["percentual_desconto"];

            if ($_SESSION['comissao_flg_1'] == "1")
            {
                if($cod_tipo_comissao == 1) //percentual
                {
                    $desconto_porcentagem = $valor_venda * $percentual_desconto;

                    $comissao_venda = $valor_venda * ($valor_comissao/100);
    
                }
                elseif ($cod_tipo_comissao == 2) //fixa
                {
                    $comissao_venda = $quantidade * $valor_comissao;
                }                
            }
            else
            {
                if($cod_tipo_comissao == 1) //percentual
                {
                    $comissao_venda = $valor_venda * ($valor_comissao/100);
    
                }
                elseif ($cod_tipo_comissao == 2) //fixa
                {
                    $comissao_venda = $quantidade * $valor_comissao;
                }                
            }

            $flg_comissao_paga = $rs["flg_comissao_paga"];

            $valores_pagos = $rs["valores_pagos"];            

            $dt_pagamento_comissao = $rs["dt_pagamento_comissao"];


            $sub_total_comissao     = number_format($comissao_venda, 2, ',', '.');
            $sub_valores_processar  = number_format($comissao_venda, 2, ',', '.');

            $sub_valores_pagos      = number_format($rs["valores_pagos"], 2, ',', '.');
            $sub_valores_bloqueados = number_format($rs["valores_bloqueados"], 2, ',', '.');

            $total_comissao += $comissao_venda;
            $total_valores_processar += $comissao_venda;
            $total_valores_pagos += $rs['valores_pagos'];
            $total_valores_bloqueados += $rs['valores_bloqueados'];

            $detalhes = "../../comanda/comanda_historico_itens_vendidos_detalhes.php?cod_comanda=".$rs['cod_comanda']."&cod_comanda_item=".$rs['cod_comanda_item']."&cod_cliente=".$rs['cod_cliente']."&voltar=".urlencode($voltar);
            
        ?>
            <tr>
                <td align="left"><?php echo $dt_venda;?></td>
                <td align="left"><?php echo $servico_produto;?></td>
                <td align="left"><?php echo $nome;?></td>
                <td align="left"><?php echo $sub_total_comissao;?></td>
                <td align="left"><?php echo $sub_valores_processar;?></td>					
                <td align="left"><?php echo $valores_pagos;?></td>					
                <td align="left"><?php echo $sub_valores_bloqueados;?></td>					
                <td align="left"><?php echo $dt_pagamento_comissao;?></td>		
                <td align="left"><button class="btn-primary btn" onclick="location.href='<?php echo $detalhes; ?>';">Detalhes</button></td>			
            </tr>
    <?php
           // }

        } // while
        
        
        $total_comissao = "R$ ".number_format($total_comissao, 2, ',', '.');
        $total_valores_processar = "R$ ".number_format($total_valores_processar, 2, ',', '.');
        $total_valores_pagos = "R$ ".number_format($total_valores_pagos, 2, ',', '.');
        $total_valores_bloqueados = "R$ ".number_format($total_valores_bloqueados, 2, ',', '.');

	?>
        <tr>
            <td align="left" style="font-weight: bold;"><?php echo $registros; ?> linhas</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="left"><b><?php echo $total_comissao; ?></b></td>
            <td align="left"><b><?php echo $total_comissao; ?></b></td>
            <td align="left"><b><?php echo $total_valores_pagos; ?></b></td>
            <td align="left"><b><?php echo $total_valores_bloqueados; ?></b></td>
            <td align="left"></td>
            <td align="left"></td>
        </tr>
<?php
	} else { // registro
	?>
                        <tr>
                            <td align="center" colspan="7">Nenhuma comissão foi encontrada!</td>
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
