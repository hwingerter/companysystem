<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";; ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Crédito dos Clientes</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Crédito dos Clientes</h1>
                    </div>
                    <div class="container-fluid">		

        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Crédito dos Clientes</h2>
          	</div>

          <div class="panel-body">

            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Cliente</th>
                            <th width="50">Telefone</th>
							<th width="200">E-mail</th>
							<th width="200">Créditos</th>
							<th width="100">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php

	$sql = "
    select      c.cod_cliente, c.nome, c.telefone, c.emaiL, ifnull(sum(valor), 0.00) as total_creditos
    from        clientes c
    inner join  clientes_credito cc on c.cod_empresa = c.cod_empresa and cc.cod_cliente = c.cod_cliente
    where       c.cod_empresa = ".$_SESSION['cod_empresa']."
    group by    c.cod_cliente, c.nome, c.telefone, c.emaiL
    order by    c.nome asc;
	";

	//echo $sql;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){     	

			$valor = number_format($rs['total_creditos'], 2, ',', '.');

		?>
                        <tr>
                            <td align="left"><?php echo $rs['nome'];?></td>
                            <td align="left"><?php echo $rs['telefone'];?></td>
							<td align="left"><?php echo $rs['email']; ?></td>
							<td align="left"><?php echo $valor; ?></td>
							<td align="center">
                                <a class="btn btn-success btn-label" href="ver_credito_cliente.php?cod_cliente=<?php echo $rs['cod_cliente'];?>">
                                    <i class="fa fa-edit"></i> Detalhes
                                </a>
                            </td>
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

<?php include('../include/rodape_interno2.php'); ?>