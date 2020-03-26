<?php
	
include('../include/funcoes.php');
	
//header('Content-type: text/html; charset=iso-8859-1');
	
$cod_empresa = $_REQUEST['cod_empresa']; 
$cod_servico = $_REQUEST['cod_servico'];
    
if ($cod_servico != "")
{

    $sql = "select preco_venda as valor from servico where cod_empresa = ".$cod_empresa." and cod_servico = ".$cod_servico."; ";

    $query = mysql_query($sql);

    $rs = mysql_fetch_array($query);
    
    $valor = ValorMysqlPhp($rs["valor"]);
    ?>

    <input type="text" class="form-control" value="<?php echo $valor; ?>" name="valor" id="valor_unitario" maxlength="10"  onKeyPress="return(moeda(this,'.',',',event));">

    <?php
}
else
{
    echo 'Registro não encontrado';    
}

?>
