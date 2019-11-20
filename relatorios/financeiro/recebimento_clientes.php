<?php include('../../include/topo_interno_relatorio.php'); ?>

<?php

//FILTRO

$dt_inicial     = $_POST["dt_inicial"];
$dt_final       = $_POST["dt_final"];
$cod_cliente    = $_POST["cod_cliente"];
$forma_pag      = $_POST["cod_forma_pagamento"];

?>


<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="recebimento_clientes_filtro.php">Recebimento de Clientes</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Recebimento de Clientes</h1>
                    </div>
                    <div class="container-fluid">						


		<div class="row">
			<div class="col-sm-8">
                <button class="btn-default btn" onclick="location.href='recebimento_clientes_filtro.php';">Voltar</button>
                &nbsp;
				<button class="btn-primary btn" onclick="window.print();">Imprimir</button>				
			</div>
		</div>

		<br>

        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Recebimento de Clientes</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Data do Pagamento</th>
                            <th width="50">Cliente</th>
                            <th width="50">Forma de Pagamento</th>
                            <th width="50">Valor</th>
                            <th width="50">Vencimento</th>
                            <th width="50">Observação</th>
                            <th width="50">Data da Venda</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    
	//CARREGA LISTA
    $sql = "
    select 	cp.dt_pagamento ,c1.nome ,fg.descricao as forma_pagamento 
            ,(select sum(ci.valor*ci.quantidade) from comanda_item ci where ci.cod_comanda = c.cod_comanda) as valor 
            ,cp.valor as valor_pago
            ,c.dt_inclusao 
    from 		comanda c
    inner join 	clientes c1 on c1.cod_cliente = c.cod_cliente
    inner join	comanda_pagamento cp on cp.cod_comanda = c.cod_comanda and cp.cod_cliente = c.cod_cliente
    inner join	formas_pagamento fg on fg.cod_forma_pagamento = cp.cod_forma_pagamento
    where 		c.cod_empresa = ".$_SESSION['cod_empresa']."
    ";
    
    if(isset($cod_cliente) && $cod_cliente != "")
    {
        $sql = $sql." and c1.cod_cliente = " . $cod_cliente;
    }
    
    if(isset($forma_pag) && $forma_pag != "0")
    {
        $sql = $sql." and cp.cod_forma_pagamento = " . $forma_pag;
    }

    if(isset($dt_inicial) && $dt_inicial != "")
    {
        $sql = $sql." and cp.dt_pagamento >= '".DataPhpMysql($dt_inicial)." 00:00:00' ";
    }

    if(isset($dt_final) && $dt_final != "")
    {
        $sql = $sql." and cp.dt_pagamento <= '".DataPhpMysql($dt_final)." 00:00:00'; ";
    }

    //echo $sql;die;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

        $total = 0;

		while (($rs = mysql_fetch_array($query))){ 

            $dt_pagamento   = DataMysqlPhp($rs["dt_pagamento"]);
            $dt_venda       = DataMysqlPhp($rs["dt_inclusao"]);
            $valor          = $rs["valor"];
            $valor_pago     = $rs["valor_pago"];
            $nome           = $rs["nome"];
            $forma_pagamento= $rs["forma_pagamento"];

            $total += $rs['valor'];
            $total = "R$ ".number_format($total, 2, ',', '.');
            
            if ($valor_pago >  $valor)
            {                     
                $valor = number_format($rs['valor'], 2, ',', '.');

		?>
            <tr>
                <td align="left"><?php echo $dt_pagamento;?></td>
                <td align="left"><?php echo $nome;?></td>
                <td align="left"><?php echo $forma_pagamento;?></td>
                <td align="left"><?php echo $valor;?></td>					
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="left"><?php echo $dt_venda;?></td>					
            </tr>
    <?php
            }

		} // while
	?>
                        <tr>
                            <td align="left">&nbsp;</td>
                            <td align="left">&nbsp;</td>
                            <td align="right"><b>Total:</b></td>
                            <td align="left"><b><?php echo $total; ?></b></td>
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
