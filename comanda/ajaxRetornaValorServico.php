<?php

include('../config/conexao.php');

include('../include/funcoes.php');
	
//header('Content-type: text/html; charset=iso-8859-1');
	
$cod_empresa = $_REQUEST['cod_empresa']; 
$cod_servico = $_REQUEST['cod_servico'];
    
if ($cod_servico != "")
{

    $sql = "select preco_venda as preco_unitario, desconto_promocional from servico where cod_empresa = ".$cod_empresa." and cod_servico = ".$cod_servico."; ";

    $query = mysql_query($sql);

    $rs = mysql_fetch_array($query);
    
    $preco_unitario = $rs["preco_unitario"];

    if (!(is_null($rs["desconto_promocional"]))) {
        $preco_unitario = $preco_unitario - ($preco_unitario * ($rs["desconto_promocional"]/100));
    }

    $preco_unitario = number_format($preco_unitario, 2);
    $preco_unitario = ValorMysqlPhp($preco_unitario);

    
    //echo '<input type="hidden" value="'.$rs["valor"].'" id="ValorUnitario" name="valor">';
    echo '<input type="text" class="form-control" value="'.$preco_unitario.'" name="txtValorUnitario" id="txtValorUnitario" maxlength="10">';

}

?>
