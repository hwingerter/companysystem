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
		
		require 'PHPMailerAutoload.php';
		require 'class.phpmailer.php';
		
		$mailer = new PHPMailer;
		
		//$mailer->SMTPDebug = 2;                               
		
		$mailer->isSMTP();                                      // funcao mailer para usar SMTP
		
		$mailer->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);
		
		
		$mailer->Host = 'plesk12l0016.hospedagemdesites.ws'; // Servidor smtp
		//Para cPanel: 'mail.dominio.com.br' ou 'localhost';
		//Para Plesk 7 / 8 : 'smtp.dominio.com.br';
		//Para Plesk 11 / 12.5: 'smtp.dominio.com.br' ou host do servidor exemplo : 'pleskXXXX.hospedagemdesites.ws';
		
		$mailer->SMTPAuth = true;                                   // Habilita a autentica├з├гo do form
		$mailer->IsSMTP();
		$mailer->isHTML(true);                                      // Formato de email HTML
		$mailer->Port = 587;									    // Porta de conex├гo
		
		$mailer->Username = 'contato@companysystem.net.br';                  // Conta de e-mail que realizar├б o envio
		$mailer->Password = 'F!jht999';                                   // Senha da conta de e-mail - Ja est� configurado com a senha e o e-mail correto.
		
		// email do destinatario
		$address = ""; // Quando for esqueci minha senha manda para o e-mail do dono da conta. Quando for a pagina de contato manda para contato@companysystem.net.br
		
		$mailer->AddAddress($address);        // email do destinatario
		$mailer->addCC(""); // copia
		$mailer->From = 'contato@companysystem.net.br';             //Obrigat├│rio ser a mesma caixa postal indicada em "username"
		$mailer->Sender = 'contato@companysystem.net.br';
		$mailer->FromName = "Contato - ". $nome;          // seu nome
		$mailer->Subject = $assunto;             // assunto da mensagem
		$mailer->MsgHTML($corpo);             // corpo da mensagem
		//$mailer->AddAttachment($arquivo['tmp_name'], $arquivo['name']  );      // anexar arquivo   -   "caso n├гo queira essa op├з├гo basta comentar"
		
		if(!$mailer->Send()) {
		   echo "Erro: " . $mailer->ErrorInfo; 
		} else {
		   $enviou = '1';
		   //echo "Mensagem enviada com sucesso!";
		}
		
		
	}
	
}	
?>
