<?php include('../../include/topo_interno_relatorio.php'); ?>

<?php 


if( ($_REQUEST["dt_inicial"] != "") || ($_REQUEST["dt_final"] != ""))
{

	$dia1 = explode("/", $_REQUEST["dt_inicial"]);
	$dia_inicial = $dia1[0];
	$mes_inicial = $dia1[1];

	$data_inicial = $dia_inicial."/".$mes_inicial."/".date('yyyy');

	$dia2 = explode("/", $_REQUEST["dt_final"]);
	$dia_final = $dia2[0];
	$mes_final = $dia2[1];

	$data_final = $dia_final."/".$mes_final."/".date('yyyy');

}
else
{

	$dia_atual = date('d');
	$mes_atual = date('m');

	$data_inicial = $dia_atual."/".$mes_atual."/".date('yyyy');
	$data_final = $dia_atual."/".$mes_atual."/".date('yyyy');

}



?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Aniversariantes</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Aniversariantes</h1>
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
                <h2>Filtro</h2>
          	</div>

          	<div class="panel-body">

				<form action="lista_clientes_aniversariantes.php" class="form-horizontal row-border" name='frm' method="post">

					<input type="hidden" name="acao" value="buscar">

					<div class="form-group">

						<label class="col-sm-1 control-label">Data Inicial</label>
						<div class="col-sm-2">

							<input type="text" class="form-control mask" 
								id="dt_inicial" 
								name="dt_inicial" 
								data-inputmask-alias="dd/mm/yyyy" 
								data-inputmask="'alias': 'date'" 
								data-val="true" 
								data-val-required="Required" 
								placeholder="dd/mm/yyyy"
								value="<?php echo $data_inicial;?>"
								>
						</div>


						<label class="col-sm-1 control-label">Data Final</label>
						<div class="col-sm-2">

							<input type="text" class="form-control mask" 
								id="dt_final" 
								name="dt_final" 
								data-inputmask-alias="dd/mm/yyyy" 
								data-inputmask="'alias': 'date'" 
								data-val="true" 
								data-val-required="Required" 
								placeholder="dd/mm/yyyy"
								value="<?php echo $data_final;?>"
								>
						</div>
					</div>

					
					<div class="row">
						<div class="col-sm-8 col-sm-offset-1">
							<button class="btn-success btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
						</div>
					</div>

				</form>

          	</div>

        </div>



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

	$sql = "

	select 		nome, telefone, email, dia_aniversario, mes_aniversario, endereco
	from 		clientes
	where 		cod_empresa = ".$_SESSION['cod_empresa']."
	";
	

	if($_REQUEST["acao"] == "buscar")
	{

		if( ($_REQUEST["dt_inicial"] != "") || ($_REQUEST["dt_final"] != ""))
		{

			$dia1 = explode("/", $_REQUEST["dt_inicial"]);
			$dia_inicial = $dia1[0];
			$mes_inicial = $dia1[1];

			$dia2 = explode("/", $_REQUEST["dt_final"]);
			$dia_final = $dia2[0];
			$mes_final = $dia2[1];

			$sql = $sql." 

				and (mes_aniversario >= '".$mes_inicial."' and mes_aniversario <= '".$mes_final."')
				or 	(dia_aniversario >= '".$dia_inicial."' and dia_aniversario <= '".$dia_final."') 
			";

		}

	}
	else
	{
		$sql = $sql." and 		(dia_aniversario = '".$dia_atual."' and mes_aniversario = '".$mes_atual."') ";
	}

	$sql = $sql."order by nome asc ";

	//echo $sql;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){ 

			if( ($rs["dt_inicial"] != "0") || ($rs["dt_final"] != "0"))
			{
				$aniversario = $rs["dia_aniversario"]." de ".RetornaMes($rs["mes_aniversario"]);	
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