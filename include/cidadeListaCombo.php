<?php

include('../config/conexao.php');

include('funcoes.php');
	
header('Content-type: text/html; charset=iso-8859-1');
	
//echo $_REQUEST['id'];die;

if ($_REQUEST['id'] != '') { $id = $_REQUEST['id']; }
if (isset($_REQUEST['cidade'])) {
	if ($_REQUEST['cidade'] != '') { $cidade = $_REQUEST['cidade']; }
} else {
	$cidade = '0';
}
	
$sql = "select cod_cidade, nome from cidades where cod_estado = ". $id ." order by nome asc";
//echo $sql;die;
$query = mysql_query($sql);
?>
<select name="codcidade" class="form-control">
	<option value="">Selecionar a cidade</option>
	<?php 
	while ($rs = mysql_fetch_array($query)){ 
	?>
		<option value="<?php echo $rs['cod_cidade']; ?>"
		<?php if ($rs['cod_cidade'] == $cidade) { echo " Selected"; }?>
		><?php echo mb_convert_encoding($rs['nome'], "ISO-8859-1", "UTF-8");?></option>
	<?php		
	}
?>

</select>