<?php
	
include('../include/funcoes.php');
	
header('Content-type: text/html; charset=UTF-8');
	
if (isset($_REQUEST['cod_produto'])) {

	if ($_REQUEST['cod_produto'] != '') { 
		$cod_produto = $_REQUEST['cod_produto']; 
	}

	if($cod_produto != ""){

		$sql = "

		select (
				(select sum(e1.quantidade) from estoque e1 where e1.cod_produto=e.cod_produto and e1.cod_tipo_movimentacao in (1,2,3))
		        -
		        (select sum(e1.quantidade) from estoque e1 where e1.cod_produto=e.cod_produto and e1.cod_tipo_movimentacao in (4,5,6,7))
		        ) as quantidade
		        ,max(custo_medio_compra) as custo_medio
		from 	estoque e
		where 	e.cod_produto = ".$cod_produto."
		";

		//echo $sql;die;

		$query 	= mysql_query($sql);
		$rs 	= mysql_fetch_array($query);

		$total = mysql_num_rows($query);

		if($total != 0)
		{
			$NovaQuantidade = $rs["quantidade"] + $_REQUEST["quantidade"];

			$texto = "Quantidade: ".$NovaQuantidade." Custo Unit. Médio: R$ ".$rs["custo_medio"]." ";
		}

		echo $texto;


	} 

}

mysql_close();
?>