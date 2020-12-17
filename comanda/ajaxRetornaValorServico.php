<?php

include('../config/conexao.php');

include('../include/funcoes.php');
	
$cod_empresa = $_REQUEST['cod_empresa']; 
$cod_servico = $_REQUEST['cod_servico'];
    
if ($cod_servico != "")
{

    $sql = "select preco_venda as preco_unitario, desconto_maximo, desconto_promocional from servico where cod_empresa = ".$cod_empresa." and cod_servico = ".$cod_servico."; ";
    //echo $sql;

    $query = mysql_query($sql);

    $rs = mysql_fetch_array($query);
    
    $preco_unitario = $rs["preco_unitario"];

    if (!(is_null($rs["desconto_promocional"]))) {
        $preco_unitario = $preco_unitario - ($preco_unitario * ($rs["desconto_promocional"]/100));
    }

    $desconto_maximo = 0.00;
    if (!(is_null($rs["desconto_maximo"]))) {
        $desconto_maximo = $rs["desconto_maximo"];
    }

    $preco_unitario = number_format($preco_unitario, 2);
    $preco_unitario = ValorMysqlPhp($preco_unitario);

    echo '<input type="hidden" value="'.$desconto_maximo.'" id="desconto_maximo" name="desconto_maximo">'; 

    ?>
        <input type="text" class="form-control" value="<?php echo $preco_unitario; ?>" name="txtValorUnitario" id="txtValorUnitario" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">
    <?php
    if (!(is_null($rs["desconto_promocional"]))) {
        echo '<p style="color:red">Desconto Promocional</p>';
    }

}

?>
