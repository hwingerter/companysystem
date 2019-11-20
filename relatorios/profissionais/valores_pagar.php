<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="valores_pagar.php">Pagar Profissionais</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Pagar Profissionais</h1>
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
                <h2>(Salários, Comissões e Outros)</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Profissional</th>
                            <th width="50">Valores a Pagar</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    
	//CARREGA LISTA
    $sql = "
    select		p.nome
    ,(r.salario + r.decimo_terceiro + r.ferias) as valor_pagar
    from 		profissional p
    left join	profissional_rendimentos r on r.cod_profissional = p.cod_profissional
    where 		p.cod_empresa = ".$_SESSION['cod_empresa']."
    order by 	p.nome asc;
	";
	
	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){ 
            
            $valor_pagar = number_format($rs['valor_pagar'], 2);
            $valor_pagar = ValorMysqlPhp($valor_pagar);
            //$valor_pagar = $rs['valor_pagar'];

		?>
                        <tr>
                            <td align="left"><?php echo $rs['nome'];?></td>
                            <td align="left"><?php echo $valor_pagar;?></td>
			
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