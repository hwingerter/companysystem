<?php
include('../config/conexao.php');

include('../include/funcoes.php');
	
header('Content-type: text/html; charset=iso-8859-1');
	

$cod_empresa = $_REQUEST['cod_empresa']; 
$cod_produto = $_REQUEST['cod_produto'];
	
$sql = "
select 		p.preco_venda
from 		produtos p
left join 	grupo_produtos gp on p.cod_grupo_produto = gp.cod_grupo_produto
where 		p.cod_empresa = ".$cod_empresa."
and 		p.cod_produto = ".$cod_produto."
";
//echo $sql;die;
$query = mysql_query($sql);
$rs = mysql_fetch_array($query);

$preco_venda = ValorMysqlPhp($rs["preco_venda"]);

echo '<input type="text" class="form-control" value="'.$preco_venda.'" name="valor" maxlength="10">';
?>
