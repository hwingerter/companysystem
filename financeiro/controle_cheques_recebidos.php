<?php

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";; 


$cod_empresa    = $_SESSION["cod_empresa"];
$cod_caixa      = $_SESSION["cod_caixa"];
$sucesso        = $_REQUEST["sucesso"];

//FILTRO

$tipo_cheque    = $_REQUEST["tipo_cheque"];
$ultimos_meses  = $_REQUEST["ultimos_meses"];

$voltar = "";

if((isset($tipo_cheque)) && ($tipo_cheque != ""))
{
    $voltar = "?tipo_cheque=".$tipo_cheque;
}

if((isset($ultimos_meses)) && ($ultimos_meses != ""))
{
    if ($voltar == "") 
    {
        $voltar = "?ultimos_meses=".$ultimos_meses;
    }
    else
    {
        $voltar = $voltar."&ultimos_meses=".$ultimos_meses;   
    }    
}

?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="controle_cheques_recebidos_filtro.php">Controle de Cheques Recebidos</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Controle de Cheques Recebidos</h1>
                    </div>
                    <div class="container-fluid">						

                    <?php
                    if ($sucesso == '1') {
                    ?>
                    <div class="alert alert-dismissable alert-success">
                        <i class="fa fa-fw fa-check"></i>&nbsp; <strong>Cheque alterado com sucesso!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                    <?php
                    }
                    ?>                       

                    <?php
                    if (!isset($_SESSION['cod_caixa'])) {
                    ?>
                        <div class="alert alert-dismissable alert-danger">
                            <strong>O caixa que está aberto é antigo!
                            </strong>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        </div>				
                    <?php
                    }
                    ?>

		<div class="row">
			<div class="col-sm-8">
                <button class="btn-default btn" onclick="location.href='controle_cheques_recebidos_filtro.php';">Voltar</button>
                &nbsp;
				<button class="btn-primary btn" onclick="window.print();">Imprimir</button>
			</div>
		</div>

		<br>

        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Cheques Recebidos</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">Emitente</th>
                            <th width="50">Valor</th>
                            <th width="50">Lançamento</th>
                            <th width="50">Vencimento</th>
                            <th width="50">Banco</th>
                            <th width="50">Nro Cheque</th>
                            <th width="25">&nbsp;</th>
                            <th width="25">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    
	//CARREGA LISTA
    $sql = "
    select		    c.cod_comanda, c.cod_cliente, cp.cod_comanda_pagamento, cp.dt_pagamento, cp.valor, cp.emitente, cp.dt_vencimento_cheque, cp.num_cheque, cp.num_parcelas, b.descricao as banco
    from 			comanda c
    inner join		comanda_pagamento cp on cp.cod_comanda = c.cod_comanda
    inner join		banco b on b.cod_banco = cp.cod_banco
    where			c.cod_empresa = ".$cod_empresa."
    ";
    

    if(isset($tipo_cheque))
    {
        if ($tipo_cheque == "1") {
            $sql = $sql." and cp.cod_forma_pagamento = 5 ";
        }
        elseif ($tipo_cheque == "2") {
            $sql = $sql." and cp.cod_forma_pagamento = 4 ";
        }
        elseif ($tipo_cheque == "3") {
            $sql = $sql." and cp.flg_cheque_devolvido = 'S' ";
        }
        else
        {
         $sql = $sql." and cp.cod_forma_pagamento in (4,5) ";   
        }
    }

    if (isset($ultimos_meses)) 
    {
        if ($ultimos_meses == "1") 
        {
            $mes = date("m");      
            $ano = date("Y"); 
            $ultimo_dia_mes = date("t", mktime(0,0,0,$mes,'01',$ano));

            $dt_inicio = date("Y-".$mes."-01 00:00:00"); 
            $dt_fim = date("Y-".$mes."-".$ultimo_dia_mes." 23:59:59"); 

            //echo $dt_inicio." - ".$dt_fim."<br>";

            $sql = $sql." and cp.dt_pagamento between '".$dt_inicio."' and '".$dt_fim."' ";
        }
        else
        {
            $mes = date("m");  
            $ano = date("Y"); 
            $ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); //ultimo dia

            $data_atual = date("Y-m-d");  

            $dt_inicio = date('Y-m-d 00:00:00', strtotime('-'.$ultimos_meses.' months', strtotime($data_atual))); //quantidade

            $dt_fim = date("Y-".$mes."-".$ultimo_dia." 23:59:59"); 

            //echo $dt_inicio." - ".$dt_fim."<br>";

            $sql = $sql." and cp.dt_pagamento between '".$dt_inicio."' and '".$dt_fim."' ";
        }
    }

    $sql = $sql." order by cp.dt_pagamento asc ";
    
    //echo $sql;

	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

        $total = 0;
        $voltar2 = "";

		while (($rs = mysql_fetch_array($query))){ 

            $cod_comanda            = $rs["cod_comanda"];
            $cod_cliente            = $rs["cod_cliente"];
            $cod_comanda_pagamento  = $rs["cod_comanda_pagamento"];
            $emitente               = $rs["emitente"];
            $valor                  = number_format($rs['valor'], 2, ',', '.');
            $dt_pagamento           = DataMysqlPhp($rs["dt_pagamento"]);


            if ($rs["dt_vencimento_cheque"] != "")
            {
                $dt_vencimento  = DataMysqlPhp($rs["dt_vencimento_cheque"]);
            }
            else{
                $dt_vencimento  = "à vista";
            }

            
            $banco          = $rs["banco"];
            $nro_cheque     = $rs["num_cheque"];
           
            
            $total +=  $rs['valor'];

            $voltar2 = host."financeiro/controle_cheques_recebidos.php".$voltar;
		?>      

            <tr>
                <td align="left"><?php echo $emitente;?></td>
                <td align="left"><?php echo $valor;?></td>                
                <td align="left"><?php echo $dt_pagamento;?></td>
                <td align="left"><?php echo $dt_vencimento;?></td>	
                <td align="left"><?php echo $banco;?></td>
                <td align="left"><?php echo $nro_cheque;?></td>
                <td align="center">
                    <button class="btn-success btn" onclick="location.href='alterar_cheque.php?acao=CarregarPagamento&cod_comanda_pagamento=<?php echo $cod_comanda_pagamento; ?>&voltar=<?php echo urlencode($voltar); ?>';">Alterar Cheque</button>                    
                </td>
                <td align="center">
                    <a class="btn btn-info btn-label" href="../comanda/comanda_historico_vendas_detalhes.php?cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente; ?>&voltar=<?php echo $voltar2; ?>"><i class="fa fa-eye"></i>Detalhes</a>                  
                </td>                    
            </tr>
    <?php
			
        } // while
        
        $total = "R$ ".number_format($total, 2, ',', '.');

	?>
                        <tr>
                            <td align="left">&nbsp;</td>
                            <td align="left"><b>Total: <?php echo $total; ?></b></td>
                            <td align="left">&nbsp;</td>
                            <td align="left">&nbsp;</td>
                            <td align="left">&nbsp;</td>
                            <td align="left">&nbsp;</td>
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