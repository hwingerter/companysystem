<?php
	
require_once("include/email.php");

if ( isset($_REQUEST["gravar"]) ) { 
	$enviar = $_REQUEST["gravar"];
	
	if ($enviar == '1') {
		
		$assunto = $_REQUEST["assunto"];		
		$nome = $_REQUEST["nome"];
		$email = $_REQUEST["email"];		
		$texto = $_REQUEST["texto"];

		$mensagem = "
		<!DOCTYPE html>
		<html lang='en'>
		<head>
			<meta charset='UTF-8'>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<meta http-equiv='X-UA-Compatible' content='ie=edge'>
			<title>Company System</title>
			<style>
			   #titulo{
					font-size: 14px;
					font-weight: bold;
					font-family: Verdana, Geneva, Tahoma, sans-serif;
				}
				#resposta{
					font-size: 14px;
					font-family: Verdana, Geneva, Tahoma, sans-serif;
				}
			</style>
		</head>
		<body>
			<div style='padding:2px;'>
				<div><img src='assets/img/COMPANY_SYSTEM_LOGO.png' style='width:120px;' alt=''></div>
				<div>
					<p id='titulo'>Assunto</p>
					<p id='resposta'>$assunto</p>
					<p id='titulo'>Nome</p>
					<p id='resposta'>$nome</p>
					<p id='titulo'>Mensagem</p>
					<p id='resposta'>$texto</p>
				</div>
			</div>
		</body>
		</html>	
		";
		
	
		$retorno = Email($mensagem);	

		echo $retorno;
		
	}
	
}	
?>
