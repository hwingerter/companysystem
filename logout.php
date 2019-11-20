<?php
session_start();

$_SESSION['usuario_id'] = NULL;  
unset($_SESSION['usuario_id']);

$_SESSION['usuario_nome'] = NULL;  
unset($_SESSION['usuario_nome']);

session_destroy();

header("location:login.php"); 
?>