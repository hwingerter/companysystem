<?php
session_start();
  

	//Valida Campos
 	
	$telephone_booking 		= $_POST['telephone_booking'];
	$telephone_booking2 	= $_POST['telephone_booking2'];
	$endereco_cep 			= $_POST['endereco_cep'];
	$endereco_endereco 		= $_POST['endereco_endereco'];
	$endereco_n 			= $_POST['endereco_n'];
	$endereco_bairro 		= $_POST['endereco_bairro'];
	$endereco_cidade 		= $_POST['endereco_cidade'];
	$endereco_complemento 	= $_POST['endereco_complemento'];
	$endereco_uf 			= $_POST['endereco_uf'];
	$total_compra			= $_SESSION['total_compra'];
			
			
				 //Tratamento de valores
				 if(!empty($telephone_booking2))
				 {
					 $telephone_booking_old = explode(' ', $telephone_booking2);
					 $telephone_booking_ddd = str_replace('(', '', $telephone_booking_old[0]);
					 $telephone_booking_ddd = str_replace(')', '', $telephone_booking_ddd);
					 
					 $telephone_booking_numero = str_replace('-', '', $telephone_booking_old[1]);
				 }
 				 //Tratamento de valores



	//$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions?email=".$_SESSION['pagseguro_email']."&token=".$_SESSION['pagseguro_token'];
	$url = "https://ws.pagseguro.uol.com.br/v2/transactions?email=".$_SESSION['pagseguro_email']."&token=".$_SESSION['pagseguro_token'];
	

	$hash_payment 	= $_POST['hash_payment'];
	if($_POST['tipo_pagamento']=='cartao')
	{
	
			
			$name_card_bookign 	= $_POST['name_card_bookign'];
			$expire_month 		= $_POST['expire_month'];
			$expire_year 		= $_POST['expire_year'];
			$ccv 				= $_POST['ccv'];
			$bandeira 			= $_POST['bandeira'];
				$parcelas 			= $_POST['parcelas'];
				$parcelas_valor 	= $_POST['parcelas_valor'];
					
					$parcelas_valor = number_format($parcelas_valor,2);
					
			$token_cartao 	= $_POST['token_cartao'];
			
		 
				   
				 
			
			//echo $url;exit;
			$xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
					<payment>
						<mode>default</mode>
						<method>creditCard</method>
						<sender>
							<name>'.$_SESSION['compraCompradorNOME'].'</name>
							<email>'.$_SESSION['compraCompradorEmail'].'</email>
							<phone>
								<areaCode>'.$telephone_booking_ddd.'</areaCode>
								<number>'.$telephone_booking_numero.'</number>
							</phone>
							<documents>
								<document>
									<type>CPF</type>
									<value>'.$_SESSION['compraCompradorCPF'].'</value>
								</document>
							</documents>
							<hash>'.$hash_payment.'</hash>
						</sender>
						<currency>BRL</currency>
						<notificationURL>'.$_SESSION['pagseguro_url_notificacao'].'</notificationURL>
						<items>
							<item>
								<id>0001</id>
								<description>'.$_SESSION['compraProduto'].'</description>
								<quantity>1</quantity>
								<amount>'.$total_compra.'</amount>
							</item>
						</items>
						<extraAmount>0.00</extraAmount>
						<reference>'.$_SESSION['compraProdutoReferencia'].'</reference>
						<shipping>
							<address>
								<street>'.$endereco_endereco.'</street>
								<number>'.$endereco_n.'</number>
								<complement>'.$endereco_complemento.'</complement>
								<district>'.$endereco_bairro.'</district>
								<city>'.$endereco_cidade.'</city>
								<state>'.$endereco_uf.'</state>
								<country>ATA</country>
								<postalCode>'.$endereco_cep.'</postalCode>
							</address>
							<type>3</type>
							<cost>0.00</cost>
						</shipping>

						<creditCard>
							<token>'.$token_cartao.'</token>
								<installment>
									<quantity>'.$parcelas.'</quantity>
									<value>'.$parcelas_valor.'</value>
									<noInterestInstallmentQuantity>2</noInterestInstallmentQuantity>
								</installment>
								<holder>
									<name>'.$name_card_bookign.'</name>
									<documents>
										<document>
											<type>CPF</type>
											<value>'.$_SESSION['compraCompradorCPF'].'</value>
										</document>
									</documents>
									<birthDate>'.$_SESSION['compraCompradorNascimento'].'</birthDate>
									<phone>
										<areaCode>'.$telephone_booking_ddd.'</areaCode>
										<number>'.$telephone_booking_numero.'</number>
									</phone>
								</holder>
								<billingAddress>
									<street>'.$endereco_endereco.'</street>
									<number>'.$endereco_n.'</number>
									<complement>'.$endereco_complemento.'</complement>
									<district>'.$endereco_bairro.'</district>
									<city>'.$endereco_cidade.'</city>
									<state>'.$endereco_uf.'</state>
									<country>ATA</country>
									<postalCode>'.$endereco_cep.'</postalCode>
								</billingAddress>
						</creditCard>
					</payment>
			';
			$_SESSION['error_log'] = $xml;
			//print_r($xml); 
	}
	else ////Boleto
	{
			//http://download.uol.com.br/pagseguro/docs/pagseguro-checkout-transparente.pdf
			//echo $url;exit;
			$xml = '
					<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
					<payment>
						<mode>default</mode>
						<method>boleto</method>
						<sender>
							<name>'.$_SESSION['compraCompradorNOME'].'</name>
							<email>'.$_SESSION['compraCompradorEmail'].'</email>
							<phone>
								<areaCode>'.$telephone_booking_ddd.'</areaCode>
								<number>'.$telephone_booking_numero.'</number>
							</phone>
							<documents>
								<document>
									<type>CPF</type>
									<value>'.$_SESSION['compraCompradorCPF'].'</value>
								</document>
							</documents>
							<hash>'.$hash_payment.'</hash>
						</sender>
						<currency>BRL</currency>
						<notificationURL>'.$_SESSION['pagseguro_url_notificacao'].'</notificationURL>
						<items>
							<item>
								<id>0001</id>
								<description>'.$_SESSION['compraProduto'].'</description>
								<quantity>1</quantity>
								<amount>'.$total_compra.'</amount>
							</item>
						</items>
						<extraAmount>0.00</extraAmount>
						<reference>'.$_SESSION['compraProdutoReferencia'].'</reference>
						<shipping>
							<address>
								<street>'.$endereco_endereco.'</street>
								<number>'.$endereco_n.'</number>
								<complement>'.$endereco_complemento.'</complement>
								<district>'.$endereco_bairro.'</district>
								<city>'.$endereco_cidade.'</city>
								<state>'.$endereco_uf.'</state>
								<country>ATA</country>
								<postalCode>'.$endereco_cep.'</postalCode>
							</address>
							<type>3</type>
							<cost>0.00</cost>
						</shipping>
					</payment>
			';
		
	}
			$xml = str_replace("\n", '', $xml);
			$xml = str_replace("\r",'',$xml);
			$xml = str_replace("\t",'',$xml);


			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, Array('Content-Type: application/xml; charset=ISO-8859-1'));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
			$xml= curl_exec($curl);
			
			//print_r($xml);exit;
			if($xml == 'Unauthorized')
			{
				echo '1_Não autorizado, verifique suas configurações no PagSeguro';
				exit;
			}

			curl_close($curl);

			$xml_retorno= simplexml_load_string($xml);

				$mensagem = $xml_retorno -> error -> code;
				if(!empty($mensagem))
				{
					if($mensagem == '5003')
					{
						echo '1_Falha com a institução financeira';
						exit;		
					}
					elseif($mensagem == '10001')
					{
						echo '1_Número do cartão é inválido';
						exit;		
					}
					elseif($mensagem == '10002')
					{
						echo '1_Data num formato inválido';
						exit;		
					}
					
					elseif($mensagem == '10003')
					{
						echo '1_Código de segurança inválido';
						exit;		
					}
					elseif($mensagem == '53085')
					{
						echo '1_Metódo de pagamento indisponível';
						exit;		
					}
					elseif($mensagem == '53087')
					{
						echo '1_Informações do cartão de crédito inválida';
						exit;		
					}
					elseif($mensagem == '53044')
					{
						echo '1_Nome no cartão de crédito é inválido';
						exit;		
					}
					else
					{
						echo '1_'.$xml_retorno -> error -> message;
						exit;		
					}
					 
				}
		 

			$xml  	= json_encode($xml_retorno);
			$array  = json_decode($xml,TRUE);
			print_r($array);	
			
			
			if($_POST['tipo_pagamento']=='cartao')
			{
				echo '2_'.$array['code']; 
			}
			else // Boleto
			{
				echo '2_'.$array['code'].'_'.$array['paymentLink']; 
			}
		 
	
	
?>