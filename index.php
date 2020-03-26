<?php
session_start();

if ($_SESSION['cod_usuario'] == '') {
	header("location:login.php"); 
} else {
	header("location:inicio.php"); 
}

?>