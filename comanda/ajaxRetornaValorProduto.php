<?php
	
include('../include/funcoes.php');
	
header('Content-type: text/html; charset=iso-8859-1');
	

$cod_empresa = $_REQUEST['cod_empresa']; 
$cod_produto = $_REQUEST['cod_produto'];
	
$sql = "
select 		p.preco_venda
from 		grupo_produtos gp
inner join 	produtos p on p.cod_grupo_produto = gp.cod_grupo_produto
where 		gp.cod_empresa = ".$cod_empresa."
and 		p.cod_produto = ".$cod_produto."
";

$query = mysql_query($sql);
$rs = mysql_fetch_array($query);

$valor = ValorMysqlPhp($rs["preco_venda"]);

echo '<input type="text" class="form-control" value="'.$valor.'" name="valor" maxlength="10">';
?>
