<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Lista de Cartões</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Lista de Cartões</h1>
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
                <h2>Cartões</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="100">Bandeira</th>
                            <th width="50">Taxa Operadora Crédito</th>
							<th width="20">Taxa Operadora Crédito Parcelado</th>
							<th width="20">Taxa Operadora Débito/th>
							<th width="20">Repasse Operadora Crédito</th>
							<th width="20">Repasse Operadora Débito</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    
	//CARREGA LISTA
    $sql = "
    select		c.bandeira, c.taxa_cartao_credito_avista, c.taxa_cartao_credito_parcelado, c.taxa_cartao_debito, c.dias_repasse_cartao_debito_operadora
    from		cartao c
    where		c.cod_empresa = ".$_SESSION['cod_empresa']."
    order by 	c.bandeira;
	";
	
	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){ 
	    	
		?>
                        <tr>
                            <td align="left"><?php echo $rs['bandeira'];?></td>
                            <td align="left"><?php echo $rs['taxa_cartao_credito_avista'];?></td>
							<td align="left"><?php echo $rs['taxa_cartao_credito_parcelado']; ?></td>
							<td align="left"><?php echo $rs['taxa_cartao_debito']; ?></td>
							<td align="left"><?php echo $rs['dias_repasse_cartao_debito_operadora']; ?></td>				
                        </tr>
    <?php
			
		} // while
	?>
                        <tr>
                            <td align="right" colspan="6"><b>Quantidade: <?php echo $registros; ?></b></td>
                        </tr>
<?php
	} else { // registro
	?>
                        <tr>
                            <td align="center" colspan="5">Nenhum registro encontrado!</td>
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