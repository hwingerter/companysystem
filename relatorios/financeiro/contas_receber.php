<?php include('../../include/topo_interno_relatorio.php'); ?>

<?php

$tipo_relatorio = $_POST["tipo_relatorio"];
$tipo_divida    = $_POST["tipo_divida"];
$dt_inicial     = $_POST["dt_inicial"];
$dt_final       = $_POST["dt_final"];
$cod_cliente    = $_POST["cod_cliente"];
$tipo_conta     = $_POST["tipo_conta"];

?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Contas a Receber</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Contas a Receber (Dívidas de Clientes)</h1>
                    </div>
                    <div class="container-fluid">						


		<div class="row">
			<div class="col-sm-8">
                <button class="btn-default btn" onclick="location.href='contas_receber_filtro.php';">Voltar</button>
                &nbsp;
				<button class="btn-primary btn" onclick="window.print();">Imprimir</button>
			</div>
		</div>

		<br>

        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Contas a Receber</h2>
          	</div>


            <div class="panel-body">

                <div class="table-responsive">

                <?php 
                    //CARREGA LISTA
                    $sql = "
                    select      c.dt_inclusao as dt_venda 
                                ,c1.nome 
                                ,fp.descricao as forma_pagamento
                                ,(select sum(cp.valor) from comanda_item cp where cp.cod_comanda = c.cod_comanda) as valor
                                ,cp.dt_pagamento
                    from        comanda c
                    inner join  clientes c1 on c1.cod_cliente = c.cod_cliente
                    left join   comanda_pagamento cp on cp.cod_comanda = c.cod_comanda
                    left join   formas_pagamento fp on fp.cod_forma_pagamento = cp.cod_forma_pagamento
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
                    
                    //echo $sql;

                    $query = mysql_query($sql);


                if ($tipo_relatorio == 1) 
                {
                
                    ?>

                    <table class="table" border="1" bordercolor="#EEEEEE">
                        <thead>
                            <tr>
                                <th width="50">Cliente</th>
                                <th width="50">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                    	$registros = mysql_num_rows($query);

                    	if ($registros > 0)
                        {

                            $total = 0;

                    		while (($rs = mysql_fetch_array($query))){ 

                                $cliente = $rs["nome"];
                                $valor = number_format($rs['valor'], 2, ',', '.');
                                
                                $total += $rs['valor'];
                                $total = "R$ ".number_format($total, 2, ',', '.');

                    		?>
                                <tr>
                                    <td align="left"><?php echo $cliente;?></td>                
                                    <td align="left"><?php echo $valor;?></td>	
                                </tr>
                        <?php
                    			
                    		} // while
                    	?>
                            <tr>
                                <td align="right"><b>Total</b></td>
                                <td align="left"><b><?php echo $total; ?></b></td>
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

                <?php 

                }
                elseif ($tipo_relatorio == 2) 
                {

                ?>
                
                    <table class="table" border="1" bordercolor="#EEEEEE">
                        <thead>
                            <tr>
                                <th width="50">Data</th>
                                <th width="50">Cliente</th>
                                <th width="50">Tipo Dívida</th>
                                <th width="50">Valor</th>
                                <th width="50">Recebido</th>
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

                <?php
                }
                ?>

            </div>

          </div>

        </div>

    </div>

    </div>

    </div> <!-- .container-fluid -->

</div> <!-- #page-content -->

<?php include('../../include/rodape_interno_relatorio.php'); ?>