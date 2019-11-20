<?php 
    
include('../../include/topo_interno_relatorio.php'); 

$filtrar_por    = $_REQUEST["filtrar_por"];
$dt_inicial     = $_REQUEST["dt_inicial"];
$dt_final       = $_REQUEST["dt_final"];
$tipo_cartao    = $_REQUEST["tipo_cartao"];
$cod_cartao     = $_REQUEST["cod_cartao"];
$cod_cliente    = $_REQUEST["cod_cliente"];

?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
                        <li class="active"><a href="extrato_cartoes_filtro.php">Extrato de Cartões</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Extrato de Cartões</h1>
                    </div>
                    <div class="container-fluid">						


		<div class="row">
			<div class="col-sm-8">
                <button class="btn-default btn" onclick="location.href='extrato_cartoes_filtro.php';">Voltar</button>
                &nbsp;
				<button class="btn-primary btn" onclick="window.print();">Imprimir</button>
			</div>
		</div>

		<br>

        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Extrato de Cartões</h2>
          	</div>


            <div class="panel-body">

                <div class="table-responsive">

                <?php 
                    //CARREGA LISTA
                    $sql = "
                    select			c.cod_comanda 
                    ,c.dt_inclusao as dt_apresentacao
                    ,c.dt_inclusao as dt_repasse
                    ,'' as parcela
                    ,fp.descricao as forma_pagamento 
                    ,c1.nome
                    ,(select sum(cp.valor * cp.quantidade) from comanda_item cp where cp.cod_comanda = c.cod_comanda) as valor_bruto
                    ,case 
                        when cp.cod_forma_pagamento = 2 then ct.taxa_cartao_debito
                        when cp.cod_forma_pagamento = 3 then ct.taxa_cartao_credito_avista
                        end as taxa_percentual
                    ,(
                        (
                            case 
                            when cp.cod_forma_pagamento = 2 then ct.taxa_cartao_debito
                            when cp.cod_forma_pagamento = 3 then ct.taxa_cartao_credito_avista
                            end 
                        )
                        /100
                    ) as percentual
                    
                    ,(
                        (select sum(cp.valor * cp.quantidade) from comanda_item cp where cp.cod_comanda = c.cod_comanda)
                        *
                        (
                        (	
                        case 
                        when cp.cod_forma_pagamento = 2 then ct.taxa_cartao_debito
                        when cp.cod_forma_pagamento = 3 then ct.taxa_cartao_credito_avista
                        end 
                        )
                        /100.0
                        )
                    )
                      as valor_liquido
    
                    from 			comanda c 
                    inner join 		clientes c1 on c1.cod_cliente = c.cod_cliente 
                    inner join 		comanda_pagamento cp on cp.cod_comanda = c.cod_comanda 
                    inner join 		formas_pagamento fp on fp.cod_forma_pagamento = cp.cod_forma_pagamento 
                    inner join 		cartao ct on ct.cod_cartao = cp.cod_cartao
                    where       c.cod_empresa = ".$_SESSION['cod_empresa']."
                    ";
                    

                    if(isset($cod_cliente) && $cod_cliente != "0")
                    {
                        $sql = $sql." and c1.cod_cliente = " . $cod_cliente;
                    }
                    
                    if(isset($dt_inicial) && $dt_inicial != "")
                    {
                        $sql = $sql." and cp.dt_pagamento >= '".DataPhpMysql($dt_inicial)." 00:00:00' ";
                    }

                    if(isset($dt_final) && $dt_final != "")
                    {
                        $sql = $sql." and cp.dt_pagamento <= '".DataPhpMysql($dt_final)." 00:00:00' ";
                    }
                    
                    if(isset($tipo_conta) && $tipo_conta == "3")
                    {
                        $sql = $sql." and cp.cod_forma_pagamento = 6 ";
                    }
                    else
                    {
                        $sql = $sql." and cp.cod_forma_pagamento <> 6 ";   
                    }
                    
                    echo $sql;

                    $query = mysql_query($sql);

                ?>
                
                    <table class="table" border="1" bordercolor="#EEEEEE">
                        <thead>
                            <tr>
                                <th width="50">Data de Apresentação</th>
                                <th width="50">Data do Repasse</th>
                                <th width="50">Parcela</th>
                                <th width="50">Forma de Pagamento</th>
                                <th width="50">Cliente</th>
                                <th width="50">Valor Bruto</th>
                                <th width="50">Taxa %</th>
                                <th width="50">Taxa $</th>
                                <th width="50">Valor Líquido</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        $registros = mysql_num_rows($query);

                        if ($registros > 0)
                        {

                            $total = 0;

                            while (($rs = mysql_fetch_array($query))){ 

                                $dt_venda = DataMysqlPhp($rs["dt_venda"]);
                                $dt_pagamento = DataMysqlPhp($rs["dt_pagamento"]);
                                $cliente = $rs["nome"];
                                $forma_pagamento = $rs["forma_pagamento"];


                                $valor = number_format($rs['valor'], 2, ',', '.');
                                
                                $total += $rs['valor'];
                                $total = "R$ ".number_format($total, 2, ',', '.');

                               ?>
                                <tr>
                                    <td align="left"><?php echo $dt_venda;?></td>
                                    <td align="left"><?php echo $cliente;?></td>                
                                    <td align="left"><?php echo $forma_pagamento;?></td>
                                    <td align="left"><?php echo $valor;?></td>  
                                    <td align="left"><?php echo $dt_pagamento;?></td>               
                                </tr>
                        <?php
                                
                            } // while
                        ?>
                            <tr>
                                <td align="left">&nbsp;</td>
                                <td align="left">&nbsp;</td>
                                <td align="right" style="font-weight: bold;">Total:</td>
                                <td align="left"><b><?php echo $total; ?></b></td>
                                <td align="left">&nbsp;</td>
                            </tr>
                        <?php
                        } 
                        else 
                        { // registro
                        ?>
                            <tr><td align="center" colspan="7">Nenhum registro encontrado!</td></tr>
                    
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