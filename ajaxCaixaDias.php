<?php
	
include('funcoes.php');
	
header('Content-type: text/html; charset=iso-8859-1');
	
if (isset($_REQUEST['cod_empresa'])) {
	if ($_REQUEST['cod_empresa'] != '') { 
		$cod_empresa = $_REQUEST['cod_empresa']; 
	}
}

$parcela = $_REQUEST['parcela'];
$cod_caixa = $_REQUEST['cod_caixa'];
	
$sql = "select cod_caixa, date_format(dt_abertura, '%d/%m/%Y') as data_abertura from caixa where cod_empresa = ".$cod_empresa." order by dt_abertura desc;";
//echo $sql;die;
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
?>
<select name="cod_caixa_<?php echo $parcela; ?>" id="cod_caixa_<?php echo $parcela; ?>" class="form-control">
<?php	
if ($registros > 0)
{

	while ($rs = mysql_fetch_array($query))
	{ 
?>
	<option value="<?php echo $rs['cod_caixa']; ?>"

		<?php if ($cod_caixa == $rs['cod_caixa']) { echo " selected "; } ?>>

		<?php echo mb_convert_encoding($rs['data_abertura'], "ISO-8859-1", "UTF-8");?></option>

<?php		
	}
}

?>
</select>