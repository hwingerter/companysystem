<?php 
require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";;

$tipo_relatorio = $_POST["tipo_relatorio"];
$tipo_divida    = $_POST["tipo_divida"];
$dt_inicial     = $_POST["dt_inicial"];
$dt_final       = $_POST["dt_final"];
$cod_cliente    = $_POST["cod_cliente"];
$tipo_conta     = $_POST["tipo_conta"];

if (isset($_REQUEST['pergunta_divida_excluida'])) { $pergunta_divida_excluida = $_REQUEST['pergunta_divida_excluida']; } else { $pergunta_divida_excluida = ""; }
if (isset($_REQUEST['pergunta_restaurar_excluida'])) { $pergunta_restaurar_excluida = $_REQUEST['pergunta_restaurar_excluida']; } else { $pergunta_restaurar_excluida = ""; }

if (isset($_REQUEST['divida_excluida'])) { $divida_excluida = $_REQUEST['divida_excluida']; } else { $divida_excluida = ''; }
if (isset($_REQUEST['divida_restaurada'])) { $divida_restaurada = $_REQUEST['divida_restaurada']; } else { $divida_restaurada = ''; }

if ($divida_excluida != '') {

    $sql = "update comanda set flg_divida_excluida = 'S' where cod_comanda  = ".$divida_excluida."";
    mysql_query($sql);  
    echo "<script language='javascript'>location.href='contas_receber_filtro.php?sucesso=1';</script>";
    die;
}

if ($divida_restaurada != '') {

    $sql = "update comanda set flg_divida_excluida = 'N' where cod_comanda  = ".$divida_restaurada."";
    mysql_query($sql);  
    echo "<script language='javascript'>location.href='contas_receber_filtro.php?sucesso=2';</script>";
    die;
}


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


                    <?php  
                    if ($pergunta_divida_excluida != "") {
                    ?>
                    <div class="alert alert-dismissable alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Deseja realmente excluir esta dívida?</strong><br>
                        <br><a class="btn btn-success" href="contas_receber.php?divida_excluida=<?php echo $pergunta_divida_excluida;?>">Sim</a>&nbsp;&nbsp;&nbsp; 
                        <a class="btn btn-danger" href="#" onclick="javascript:history.back(-1);">Não</a>
                    </div>              
                    <?php
                        die;
                    }                    
                    ?>

                    <?php  
                    if ($pergunta_restaurar_excluida != "") {
                    ?>
                    <div class="alert alert-dismissable alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Deseja realmente restaurar esta dívida?</strong><br>
                        <br><a class="btn btn-success" href="contas_receber.php?divida_restaurada=<?php echo $pergunta_restaurar_excluida;?>">Sim</a>&nbsp;&nbsp;&nbsp; 
                        <a class="btn btn-danger" href="#" onclick="javascript:history.back(-1);">Não</a>
                    </div>              
                    <?php
                        die;
                    }                    
                    ?>

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
                    select      c.cod_comanda
                                ,c.dt_inclusao as dt_venda 
                                ,c.cod_cliente
                                ,c1.nome 
                                ,fp.descricao as forma_pagamento
                                ,(select sum(cp.valor) from comanda_item cp where cp.cod_comanda = c.cod_comanda) as valor
                                ,cp.dt_pagamento
                                ,flg_divida_excluida
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


                if ($tipo_relatorio == "1") 
                {
                
                    ?>

                    <table class="table" border="1" bordercolor="#EEEEEE">
                        <thead>
                            <tr>
                                <th width="50%">Cliente</th>
                                <th width="25%">Valor</th>
                                <th width="25%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        $query = mysql_query($sql);
                    	$registros = mysql_num_rows($query);

                    	if ($registros > 0)
                        {

                            $total = 0;

                    		while (($rs = mysql_fetch_array($query))){ 

                                $cod_comanda = $rs["cod_comanda"];
                                $cod_cliente = $rs["cod_cliente"];
                                $cliente = $rs["nome"];
                                $valor = number_format($rs['valor'], 2, ',', '.');
                                $flg_divida_excluida = $rs["flg_divida_excluida"];
                                
                                $total += $rs['valor'];
                                $total = "R$ ".number_format($total, 2, ',', '.');

                                $voltar = urlencode("../financeiro/contas_receber_filtro.php");

                    		?>
                                <tr>
                                    <td align="left"><?php echo $cliente;?></td>                
                                    <td align="left"><?php echo $valor;?></td>	
                                    <td align="left">
                                        <a class="btn btn-success btn-label" 
                                            href="../comanda/comanda_pagamentos.php?cod_comanda=<?php echo $cod_comanda; ?>&cod_cliente=<?php echo $cod_cliente;?>&voltar=<?php echo $voltar; ?>"><i class="fa fa-edit"></i> Receber 
                                        </a>
                                        &nbsp;
                                        <?php 
                                        if ($flg_divida_excluida == "N") 
                                        { 
                                        ?>
                                        <a class="btn btn-danger btn-label" href="contas_receber.php?pergunta_divida_excluida=<?php echo $rs['cod_comanda'];?>"><i class="fa fa-times-circle"></i> Excluir</a>
                                        <?php 
                                        }else{ 
                                        ?>
                                        <a class="btn btn-default btn-label" href="contas_receber.php?pergunta_restaurar_excluida=<?php echo $rs['cod_comanda'];?>"><i class="fa fa-times-circle"></i> Restaurar</a>
                                        <?php 
                                        }
                                        ?>

                                    </td>  
                                </tr>
                        <?php
                    			
                    		} // while
                    	?>
                            <tr>
                                <td align="right"><b>Total</b></td>
                                <td align="left"><b><?php echo $total; ?></b></td>
                                <td>&nbsp;</td>
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
                elseif ($tipo_relatorio == "2") 
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


                        $query = mysql_query($sql);
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

<?php include('../include/rodape_interno2.php'); ?>