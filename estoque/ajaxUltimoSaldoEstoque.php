<?php

include('../config/conexao.php');

include('../include/funcoes.php');
	
header('Content-type: text/html; charset=UTF-8');
	
if (isset($_REQUEST['cod_produto'])) {
	if ($_REQUEST['cod_produto'] != '') { 
		$cod_produto = $_REQUEST['cod_produto']; 
	}

if($cod_produto != ""){

	$sql = "
	select	 	concat('Quantidade: ',e.quantidade, '   Custo Unit. Médio: R$ ',e.custo_medio_compra) as estoque_atual, e.custo_medio_compra as devolucao_venda
	from 		estoque e
	where 		e.cod_produto = ".$cod_produto."
	order by 	e.dt_movimentacao desc
	limit 		1;";

	$query 	= mysql_query($sql);
	$rs 	= mysql_fetch_array($query);

	$total = mysql_num_rows($query);

	if($total != 0)
	{
		$texto = $rs['estoque_atual']."|||".ValorMysqlPhp(number_format($rs['devolucao_venda'],2));
	}


	echo $texto;

}


?>


<?php } 

mysql_close();
?>