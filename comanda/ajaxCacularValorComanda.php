<?php

include('../config/conexao.php');

include('../include/funcoes.php');


if (isset($_REQUEST['acao']) && ($_REQUEST['acao'] == "calcular_subtotal"))
{

    $valor_unitario = $_REQUEST['valor_unitario']; 
    $quantidade     = $_REQUEST['quantidade'];
    
    $valor_unitario = ValorPhpMysql($valor_unitario); 
    
    $subtotal = $valor_unitario * $quantidade;

    $subtotal = number_format($subtotal, 2);

    echo "R$ ".ValorMysqlPhp($subtotal);  
    echo '<input type="hidden" value="'.$subtotal.'" id="subtotal" name="subtotal">'; 
   

}
elseif (isset($_REQUEST['acao']) && ($_REQUEST['acao'] == "calcular_acrescimo"))
{
    $valor_unitario     = $_REQUEST['valor_unitario']; 
    $quantidade         = $_REQUEST['quantidade']; 
    $valor_acrescimo    = $_REQUEST['valor_acrescimo'];
  
    $subtotal = (($valor_unitario * $quantidade) + $valor_acrescimo);
    $subtotal = number_format($subtotal, 2);

    $subtotal = ValorMysqlPhp($subtotal);


    echo  $subtotal;   
    echo '<input type="hidden" value="'.$subtotal.'" id="subtotal" name="subtotal">'; 

}
elseif (isset($_REQUEST['acao']) && ($_REQUEST['acao'] == "remover_acrescimo"))
{
    $valor_subtotal     = $_REQUEST['subtotal']; 
    $valor_acrescimo    = $_REQUEST['valor_acrescimo'];
  
    $subtotal = ($valor_subtotal - $valor_acrescimo);
    $subtotal = number_format($subtotal, 2);

    $subtotal = ValorMysqlPhp($subtotal);


    echo  $subtotal;   
    echo '<input type="hidden" value="'.$subtotal.'" id="subtotal" name="subtotal">'; 

}
elseif (isset($_REQUEST['acao']) && ($_REQUEST['acao'] == "calcular_desconto_percentual"))
{
    $valor_unitario         = $_REQUEST['valor_unitario']; 
    $quantidade             = $_REQUEST['quantidade']; 
    $desconto_percentual    = ValorPhpMysql($_REQUEST['desconto_percentual']);    
    $desconto_maximo        = $_REQUEST['desconto_maximo'];    

    if (($_REQUEST["desconto_percentual"] != "") && ($_REQUEST["desconto_percentual"] != "0,00"))
    {       

        if ($desconto_percentual > $desconto_maximo) {
            echo "Erro|<p style='color:red'>O desconto máximo permitido para esse item é de <b>" . $desconto_maximo. "</b>%.</p>";

        }
        else
        {
            $subtotal = $valor_unitario * $quantidade;

            $subtotal = $subtotal - ($subtotal * ($desconto_percentual/100));

            $subtotal = number_format($subtotal, 2);     

            echo "Sucesso|R$ ".ValorMysqlPhp($subtotal);  
            echo '<input type="hidden" value="'.$subtotal.'" id="subtotal" name="subtotal">'; 
    
        }

    }    

}

?>
