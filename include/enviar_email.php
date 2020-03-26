<?php
	
if ( isset($_REQUEST["gravar"]) ) { 
	$enviar = $_REQUEST["gravar"];
	
	if ($enviar == '1') {
		
		$nome = $_REQUEST["nome"];
		$email = $_REQUEST["email"];
		$assunto = $_REQUEST["assunto"];
		$texto = $_REQUEST["texto"];
		
		
		$corpo = "<b>Formulário enviado</b><br><br>";
		$corpo = "<b>Nome:</b> " . $nome . "<br><br>"; 
		$corpo .= "<b>Email:</b> " . $email . "<br><br>"; 
		$corpo .= "<b>Assunto:</b> " . $assunto . "<br><br>";
		$corpo .= "<b>Texto:</b> <br>" . $texto . "<br>";
		
		$to      = 'contato@companysystem.net.br';
		$subject = 'teste';
		$message = $corpo;
		$headers = 'From: contato@companysystem.net.br' . "\r\n" .
		    'Reply-To: contato@companysystem.net.br' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		$headers .= "MIME-Version: 1.0\r\n.";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$sucesso = mail($to, $subject, $message, $headers);
		
		if (!@$sucesso) {
			$errorMessage = error_get_last()['message'];
			echo $errorMessage;
		}
		
		
	}
	
}	
?>
