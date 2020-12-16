<?php

include('../config/conexao.php');

include('../include/funcoes.php');
	
//header('Content-type: text/html; charset=iso-8859-1');

if (isset($_REQUEST['acao']) && ($_REQUEST['acao'] == "calcular_subtotal"))
{

    $valor_unitario = $_REQUEST['valor_unitario']; 
    $quantidade     = $_REQUEST['quantidade'];
    
    
    if ($valor_unitario != "")
    {
    
        $subtotal = number_format($valor_unitario * $quantidade, 2);
    
        echo  $subtotal;   
   
    }

}
elseif (isset($_REQUEST['acao']) && ($_REQUEST['acao'] == "calcular_acrescimo"))
{
    $valor_subtotal       = $_REQUEST['valor_subtotal']; 
    $valor_acrescimo     = $_REQUEST['valor_acrescimo'];
    
    $subtotal = number_format($valor_subtotal + $valor_acrescimo, 2);

    echo  $subtotal;   

}


?>
