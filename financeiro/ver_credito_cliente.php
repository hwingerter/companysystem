<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";; ?>

<?php

$cod_cliente = $_REQUEST['cod_cliente'];
$cod_credito = $_REQUEST['cod_credito'];
if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
if (isset($_REQUEST['pergunta_data'])) { $pergunta_data = $_REQUEST['pergunta_data']; } else { $pergunta_data = ''; }
if (isset($_REQUEST['pergunta_valor'])) { $pergunta_valor = $_REQUEST['pergunta_valor']; } else { $pergunta_valor = ''; }
?>

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
                        <div class="options">
                            <?php 
                            //if ($credencial_incluir == '1') {
                            ?>
                            <a class="btn btn-midnightblue btn-label" href="editar_credito_cliente.php?acao=novo_credito&cod_cliente=<?php echo $cod_cliente; ?>"><i class="fa fa-plus-circle"></i>Novo Crédito</a>
                            <?php
                            //}
                            ?>	
                        </div>
                    </div>
                    <div class="container-fluid">	

                        <?php
                        if ($sucesso == '1') {
                        ?>
                        <div class="alert alert-dismissable alert-success">
                            <i class="fa fa-fw fa-check"></i>&nbsp; <strong>Créditos gravados com sucesso!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        </div>
                        <?php
                        } else if ($sucesso == '2') {
                        ?>
                        <div class="alert alert-dismissable alert-success">
                            <i class="fa fa-fw fa-check"></i>&nbsp; <strong>Créditos atualizados com sucesso!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        </div>				
                        <?php
                        } else if ($sucesso == '3') {
                        ?>
                        <div class="alert alert-dismissable alert-success">
                            <i class="fa fa-fw fa-check"></i>&nbsp; <strong>Créditos excluídos com sucesso!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        </div>		
                        <?php
                        }
                        ?>

                        <?php
                        if ($pergunta_data != '') {
                        ?>
                        <div class="alert alert-dismissable alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Deseja realmente excluir o crédito no valor de R$ <?php echo ValorMysqlPhp($pergunta_valor); ?> na creditado em <?php echo $pergunta_data; ?> ?</strong><br>
                            <br><a class="btn btn-success" href="editar_credito_cliente.php?acao=excluir_credito&cod_cliente=<?php echo $cod_cliente; ?>&cod_credito=<?php echo $cod_credito;?>">Sim</a>&nbsp;&nbsp;&nbsp; 
                            <a class="btn btn-danger" href="ver_credito_cliente.php?cod_cliente=<?php echo $cod_cliente; ?>">Não</a>
                        </div>				
                        <?php
                        }
                        ?>


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
                            <th width="50">Data</th>
							<th width="200">Crédito/Débito</th>
							<th width="200">Valor R$</th>
                            <th width="5">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php

	$sql = "
    select		cc.cod_credito, c.cod_cliente, cc.cod_comanda, c.nome, date_format(cc.data, '%d/%m/%Y %H:%i hs') as data, cc.movimentacao, cc.valor
                ,ifnull(cc.cod_comanda, '') as comanda
    from		clientes_credito cc
    inner join	clientes c on c.cod_cliente = cc.cod_cliente
    where 		cc.cod_empresa = ".$_SESSION['cod_empresa']."
    order by 	cc.data asc;
    ";

	//echo $sql;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

        $soma_creditos = 0.0;

		while (($rs = mysql_fetch_array($query))){     	

            $valor = number_format($rs['valor'], 2, ',', '.');
            
            $soma_creditos += $rs['valor'];

            $pergunta_data = $rs['data'];
            $pergunta_valor = $rs['valor'];


		?>
                        <tr>

                            <td align="left"><?php echo $rs['nome'];?></td>
                            <td align="left"><?php echo $rs['data'];?></td>
							<td align="left"><?php echo $rs['movimentacao']; ?></td>
							<td align="left"><?php echo $valor; ?></td>		
							<td align="center">

                                <?php if ($rs['cod_comanda'] == '') { ?>

                                <a class="btn btn-success btn-label" href="editar_credito_cliente.php?acao=editar_credito&cod_cliente=<?php echo $rs['cod_cliente']; ?>&cod_credito=<?php echo $rs['cod_credito']; ?>"><i class="fa fa-edit"></i> Editar </a>

                                <a class="btn btn-danger btn-label" href="ver_credito_cliente.php?pergunta_data=<?php echo $pergunta_data;?>&pergunta_valor=<?php echo $pergunta_valor;?>&cod_cliente=<?php echo $rs['cod_cliente'];?>&cod_credito=<?php echo $rs['cod_credito']; ?>">
                                    <i class="fa fa-edit"></i> Excluir
                                </a>

                                <?php } ?>
                                &nbsp;
                            </td>				
                        </tr>
    <?php
			
        } // while
        
        $soma_creditos = number_format($soma_creditos, 2, ',', '.');

	?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><b>Total de Créditos:</b></td>
                            <td align="left" colspan="4" style="font-weight:bold;"><?php echo $soma_creditos; ?></b></td>
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
        <div class="row">
        <div class="col-sm-12">
            <button class="btn-default btn" onclick="javascript:window.location='credito_clientes.php';">Voltar</button>
        </div>
    </div>
    </div>
</div>

    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->

<?php include('../include/rodape_interno2.php'); ?>