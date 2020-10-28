<?php

include('../config/conexao.php');

include('../include/funcoes.php');
	
//header('Content-type: text/html; charset=iso-8859-1');
	
$valor_unitario = $_REQUEST['valor_unitario']; 
$quantidade     = $_REQUEST['quantidade'];
    
if ($valor_unitario != "")
{

    $subtotal = number_format($valor_unitario * $quantidade, 2);

    echo  $subtotal;

    echo '<input type="hidden" value="'.$subtotal.'" id="ValorUnitario" name="valor">';
    echo '<input type="text" class="form-control" value="'.ValorMysqlPhp($subtotal).'" name="valor" maxlength="10">';

}

?>
