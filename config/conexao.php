<?php
	
	$host		= "127.0.0.1";
	$usuario	= "root";
	$password	= "";
	$dbname		= "companys_system";
	
	/*
	$host		= "localhost";
	$usuario	= "companys_system";
	$password	= "Bzx24r5%";
	$dbname		= "companys_system";
	*/

	$conexao = mysql_connect ($host, $usuario, $password);
	$banco	 = mysql_select_db ($dbname, $conexao) or die (mysql_error());

	mysql_set_charset('utf8');
?>