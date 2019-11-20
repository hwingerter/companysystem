<?php
include("funcoes.php");
include("conexao.php");
	
if (isset($_REQUEST["nova_senha"])) 
{ 

	$email = $_REQUEST["email"];

	$sql = "SELECT cod_usuario, nome FROM usuarios where email = '".$email."'";
	$query = mysql_query($sql);

	$rs = mysql_fetch_array($query);

	$cod_usuario	= $rs["cod_usuario"];
	$nome  			= $rs['nome'];

	$senha = $_REQUEST["nova_senha"];
	$senha .= "&D31R#i017$";
	$senha = md5($senha);	

	$sql = "update usuarios set senha='".$senha."' where cod_usuario = ".$cod_usuario;
	mysql_query($sql);
		
	   $sucesso = '3';
	   echo "<script>location.href='login.php?sucesso=".$sucesso."';</script>";
	
}	

?>
