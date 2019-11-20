<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Clientes ausentes do salão a mais de X dias</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Clientes ausentes do salão a mais de X dias</h1>
                    </div>
                    <div class="container-fluid">						


		<div class="row">
			<div class="col-sm-8">
				<button class="btn-default btn" onclick="location.href='clientes_ausentes_salao_dias_filtro.php';">Voltar</button>
				<button class="btn-primary btn" onclick="window.print();">Imprimir</button>
			</div>
		</div>

		<br>

        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Clientes</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Cliente</th>
                            <th width="50">Dias Ausentes</th>
                            <th width="50">Telefone</th>
                            <th width="50">Celular</th>
							<th width="100">E-mail</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php

	$dias_ausentes = $_REQUEST['dias_ausentes'];
	$ultimos_dias = $_REQUEST['ultimos'];

	$hoje = date("d/m/Y", strtotime('-'.$dias_ausentes.' day'));
	$dt_inicial = date("d/m/Y", strtotime('-'.$ultimos_dias.' day'));
   
    //echo $dt_inicial." - ".$hoje."<br>";

	//CARREGA LISTA
	$sql = "
    select      cli.cod_cliente,nome
                ,DATEDIFF(  CURDATE()
                            ,(select max(dt_inclusao) from comanda where cod_empresa = co.cod_empresa and  cod_cliente = co.cod_cliente)
                ) as dias_ausente
                ,telefone, celular, email
	from 		clientes cli
	inner join 	comanda co on co.cod_cliente = cli.cod_cliente
	where 		cli.cod_empresa = ".$_SESSION['cod_empresa']."
	
	";

    if(isset($dt_inicial) && $dt_inicial != "")
    {
        $sql = $sql." and			co.dt_inclusao between '".DataPhpMysql($dt_inicial)." 00:00:00' and '".DataPhpMysql($hoje)." 23:59:59' ";
    }

	$sql = $sql." order by	cli.nome asc ";

	//echo "<br>".$sql;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){ 

		?>
            <tr>
                <td align="left"><?php echo $rs['nome'];?></td>
                <td align="left"><?php echo $rs['dias_ausente'];?></td>
                <td align="left"><?php echo $rs['telefone'];?></td>
				<td align="left"><?php echo $rs['celular']; ?></td>
				<td align="left"><?php echo $rs['email']; ?></td>
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