<?php
	
include('../funcoes.php');
	
header('Content-type: text/html; charset=UTF-8');
	
if ($_REQUEST['id'] != '') { $id = $_REQUEST['id']; }
if (isset($_REQUEST['cidade'])) {
	if ($_REQUEST['cidade'] != '') { $cidade = $_REQUEST['cidade']; }
} else {
	$cidade = '0';
}
	
$sql = "Select * from cidades where cod_estado = ". $id ." order by Nome asc";
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
?>
<select name="codcidade" class="form-control">
<?php	if ($registros > 0) {
		
?>
	<option value="">Selecionar a cidade</option>
<?php 
			while ($rs = mysql_fetch_array($query)){ 
?>
			<option value="<?php echo $rs['cod_cidade']; ?>"
			<?php if ($rs['cod_cidade'] == $cidade) { echo " Selected"; }?>
			><?php echo mb_convert_encoding($rs['nome'], "ISO-8859-1", "UTF-8");?></option>
	<?php		
			}
  		}
?>
</select>