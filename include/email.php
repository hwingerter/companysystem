<?php

function ValidarEmail($email)
{
	if(filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		return true;
	}
	else
	{
		return false;
	}

}

function Email($pAssunto, $pMensagem)
{
	$to      = 'contato@companysystem.net.br';
	$subject = $pAssunto;
	$message = $pMensagem;
	$headers = 'From: contato@companysystem.net.br' . "\r\n" .
		'Reply-To: contato@companysystem.net.br' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
	$headers .= "MIME-Version: 1.0\r\n.";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	$sucesso = mail($to, $subject, $message, $headers);
	
	if (!$sucesso) {
		return error_get_last()['message'];
	}
	else
	{
		return $sucesso;
	}

}

function EmailEsqueciMinhaSenha($pEmailUsuario, $pAssunto, $pMensagem)
{
	$to      = $pEmailUsuario;
	$subject = $pAssunto;
	$message = $pMensagem;
	$headers = 'From: contato@companysystem.net.br' . "\r\n" .
		'Reply-To: contato@companysystem.net.br' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
	$headers .= "MIME-Version: 1.0\r\n.";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	$sucesso = mail($to, $subject, $message, $headers);
	
	if (!$sucesso) {
		return error_get_last()['message'];
	}
	else
	{
		return $sucesso;
	}
}

?>