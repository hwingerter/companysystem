<?php
include('../../include/topo_interno_relatorio.php'); 
?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Lista de Clientes</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Lista de Clientes</h1>
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
                <h2>Clientes</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Cliente</th>
                            <th width="50">Telefone</th>
							<th width="200">E-mail</th>
							<th width="200">Aniversário</th>
							<th width="50">Endereço</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    
	//CARREGA LISTA
	$sql = "
	select 		nome, telefone, email, dia_aniversario, mes_aniversario, endereco
	from 		clientes
	where 		cod_empresa = ".$_SESSION['cod_empresa']."
	order by	nome asc
	";
	
	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){ 

			if( ($rs["dia_aniversario"] != "0") || ($rs["dia_aniversario"] != "0"))
			{
				$aniversario = $rs["dia_aniversario"]." de ".RetornaMes($rs["dia_aniversario"]);	
			}
			else
			{
				$aniversario = 	"";
			}			
	    	
		?>
                        <tr>
                            <td align="left"><?php echo $rs['nome'];?></td>
                            <td align="left"><?php echo $rs['telefone'];?></td>
							<td align="left"><?php echo $rs['email']; ?></td>
							<td align="left"><?php echo $aniversario; ?></td>
							<td align="left"><?php echo $rs['endereco']; ?></td>						
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