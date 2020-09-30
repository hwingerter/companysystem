<?php
session_start();

$_SESSION['cod_usuario'] = NULL;  
unset($_SESSION['cod_usuario']);

$_SESSION['usuario_nome'] = NULL;  
unset($_SESSION['usuario_nome']);

session_destroy();

header("location:login.php"); 
?>