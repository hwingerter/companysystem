<?php
	
include('../include/funcoes.php');
	
header('Content-type: text/html; charset=iso-8859-1');
	
if (isset($_REQUEST['cod_empresa'])) {
	if ($_REQUEST['cod_empresa'] != '') { 
		$cod_empresa = $_REQUEST['cod_empresa']; 
	}
}

$sql = "select cod_caixa, date_format(dt_abertura, '%d/%m/%Y') as data_abertura from caixa where cod_empresa = ".$cod_empresa." order by dt_abertura desc limit 10;";
//echo $sql;die;
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
?>
<select name="cod_caixa_antigo" id="cod_caixa_antigo" class="form-control">
<?php	
if ($registros > 0)
{

	while ($rs = mysql_fetch_array($query))
	{ 
?>
	<option value="<?php echo $rs['cod_caixa']; ?>"><?php echo $rs['data_abertura'];?></option>

<?php		
	}
}

?>
</select>