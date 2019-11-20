<?php

$sql = "Select count(*) as total from tipo_conta_credencial where cod_tipo_conta = ". $_SESSION['usuario_conta'];
//echo $sql;die;
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
if ($registros > 0) {
	if ($rs = mysql_fetch_array($query)) { 
		$totalcredencial = $rs["total"];
	}
}

$sql = "
Select		credenciais.credencial 
from 		tipo_conta_credencial 
inner join 	credenciais on tipo_conta_credencial.cod_credencial = credenciais.cod_credencial  
where 		tipo_conta_credencial.cod_tipo_conta = " . $_SESSION['usuario_conta']."";
//echo $sql;die;
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
if ($registros > 0) {
	$i = 0;
	while ($rs = mysql_fetch_array($query)) { 
		$credenciais[$i] = $rs["credencial"];
		$i = $i + 1;
	}
}

?>