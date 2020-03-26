<?php
	session_start();
	
	$_SESSION['pagseguro_email'] 	= 'financeiro@companysystem.net.br';
	$_SESSION['pagseguro_token'] 	= '5133400DA3F841CA8A8CB6612569A21D';
	$url_data = "https://ws.pagseguro.uol.com.br/v2/sessions/";
	
	/*
	SandBox
		$_SESSION['pagseguro_token'] 	= '***********************';
		$_SESSION['compraCompradorEmail'] = 'email@sandbox.pagseguro.com.br';
		$url_data = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions/";
			echo 
			'
				<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
			';
	SandBox
	*/
	
	$_SESSION['pagseguro_url_notificacao'] = 'http://www.companysystem.net.br/notificacao';
	echo '<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>';
		
		
		
		
		
	//Dados da compra 
		$_SESSION['total_compra'] 				= $_REQUEST['valor'];
		$_SESSION['compraProduto'] 				= $_REQUEST['licenca'];
		$_SESSION['retorno'] 					= $_REQUEST['url_retorno']."&acao=gerar_boleto&link_boleto=";
		$_SESSION['compraProdutoReferencia'] 	= 'Company System';
		$_SESSION['compraCompradorCPF'] 		= '02338589548';
		$_SESSION['compraCompradorNOME'] 		= 'Claudio Pinheiro Costa';
		$_SESSION['compraCompradorNascimento'] 	= '10/07/1985';
		$_SESSION['compraCompradorEmail'] 		= 'claudiopinheiro.ba@gmail.com';
	//Dados da compra 
	
	
	
?>

<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
<meta charset="UTF-8">

<!--[if lte IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

    <div id="preloader">
        <div class="sk-spinner sk-spinner-wave">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div>
    <!-- End Preload -->

    <div class="layer"></div>
    <!-- Mobile menu overlay mask -->

    <!-- Header Plain:  add the id plain to header and change logo.png to logo_sticky.png ======================= -->
    <header id="plain">

        
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                      <div id="logo_home">
                    	<h1><a href="#" title="">PagSeguro</a></h1>
                    </div>
                </div>

            </div>

        </div><!-- container -->

    </header><!-- End Header -->




	

<head>
	<style>
		/*CLASSE PARA DIV COM VALORES DAS PARCELAS */
		.payment_lists_number_division{
			padding:30px 5px 0 5px;
			margin-right:10px;
			background:#83e7e3 ;
			border: 1px solid #29a7a1;
			color:#0f837e;
			width: 100px;
			height: 100px;
			text-align:center;
			font-weight:bold;
			font-size:14px;
			border-radius: 10px;
			cursor:pointer;
			display:inline;
			float:left;
		}
		
			.payment_lists_number_division span{
				font-weight:normal;
				font-size:12px;
			}
	</style>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap.css" rel="stylesheet"> 
	<link href="css/style.css" rel="stylesheet">   
	<!--<link href="css/color-aqua.css" rel="stylesheet">   -->
		<link href="css/color-red.css" rel="stylesheet">
		<!--<link href="css/color-green.css" rel="stylesheet">   -->
		
		
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
      
	<title>Checkout transparente Pagseguro</title>
 	<meta name="keywords" content="">
	
 
	
</head>

<body style="background:#fff">
 
    <div id="position">
    	<div class="container">
   
        </div>
    </div><!-- End position -->

<div class="container margin_60" style="background:#fff;padding-top:90px;">
 

        <div class="container">
            <div class="row">
                <div class="col-md-12">
		

					<div class="col-md-16 add_bottom_15">
					<div class="box_style_1" id="box_resume_book">
						<h3 class="inner">- Detalhes -</h3>
						<table class="table table_summary">
							<tbody>
			
								<tr>
									<td>
										Detalhes:
									</td>
									<td class="text-right">
										<?php echo $_SESSION['compraProduto'].'<Br>'.$_SESSION['compraProdutoReferencia'];?>
									</td>
								</tr>
			
								<tr class="total">
									<td>
										Total
									</td>
									<td class="text-right" id="valor_compra_total">
										<?php
											
											
											echo 'R$ '.number_format($_SESSION['total_compra'],2,",",".");
										?>
									</td>
								</tr>
							</tbody>
						</table>
			
					</div>				
				
				<div class="form_title">
					<h3><strong>1</strong>Detalhes Importantes</h3>
					<p>
						A empresa entrará em contato a qualquer momento
					</p>
				</div>
				<div class="step">
					
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Telefone</label>
								<input type="text" id="telephone_booking" name="telephone_booking" maxlength="15" class="form-control" value="<?php echo $usuario_telefone = (isset($dados_cadastro_usuario['usuario_telefone'] ))  ?  ($dados_cadastro_usuario['usuario_telefone'] )  :  ("");?>">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Celular</label>
								<input type="text" id="telephone_booking2" name="telephone_booking2" maxlength="15"  class="form-control" value="<?php echo $usuario_celular = (isset($dados_cadastro_usuario['usuario_celular'] ))  ?  ($dados_cadastro_usuario['usuario_celular'] )  :  ("");?>">
							</div>
						</div>
					</div>
				</div><!--End step -->
			
			

			<div id="step_2">
				<div class="form_title">
					<h3><strong>2</strong>Informações pessoais</h3>
					<p>
						Precisamos de mais alguns dados de preenchimento, é bem rápido
					</p>
				</div>
				<div class="step">

					<div class="row">
						<div class="col-md-3 col-sm-3">
							<div class="form-group">
								<label>CEP</label>
								<input type="text" id="endereco_cep" name="endereco_cep" maxlength="8" class="form-control" placeholder="Sem traços" value="">
							</div>
						</div>
						<div class="col-md-9 col-sm-9">
							<div class="form-group">
								<label>Endereço</label>
								<input type="text" id="endereco_endereco" name="endereco_endereco"  class="form-control" value="">
							</div>
						</div>
					</div>
					
					
					<div class="row">
						<div class="col-md-2 col-sm-2">
							<div class="form-group">
								<label>Nº</label>
								<input type="text" id="endereco_n" name="endereco_n" maxlength="15" class="form-control" value="">
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<label>Bairro</label>
								<input type="text" id="endereco_bairro" name="endereco_bairro" class="form-control" value="">
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<label>Cidade</label>
								<input type="text" id="endereco_cidade" name="endereco_cidade"  class="form-control" value="">
							</div>
						</div>
						
						<div class="col-md-2 col-sm-2">
							<div class="form-group">
								<label>UF</label>
								<input type="text" id="endereco_uf" name="endereco_uf"  class="form-control" value="">
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<label>Complemento</label>
								<input type="text" id="endereco_complemento" name="endereco_complemento"  class="form-control" value="">
							</div>
						</div>
					</div>
				</div><!--End step -->
			</div>	
			
			<div class="step">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<style>
							.cc-selector input{
								margin:0;padding:0;
								-webkit-appearance:none;
								   -moz-appearance:none;
										appearance:none;
							}

							.cc-selector-2 input{
								position:absolute;
								z-index:999;
							}

							.visa{background-image:url(img/pagamento-catao-credito.png);}
							.mastercard{background-image:url(img/pagamento-boleto-bancario.png);}

							.cc-selector-2 input:active +.drinkcard-cc, .cc-selector input:active +.drinkcard-cc{opacity: .9;}
							.cc-selector-2 input:checked +.drinkcard-cc, .cc-selector input:checked +.drinkcard-cc{
								-webkit-filter: none;
								   -moz-filter: none;
										filter: none;
							}
							.drinkcard-cc{
								cursor:pointer;
								background-size:contain;
								background-repeat:no-repeat;
								display:inline-block;
								width:100px;height:70px;
								-webkit-transition: all 100ms ease-in;
								   -moz-transition: all 100ms ease-in;
										transition: all 100ms ease-in;
								-webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
								   -moz-filter: brightness(1.8) grayscale(1) opacity(.7);
										filter: brightness(1.8) grayscale(1) opacity(.7);
							}
							.drinkcard-cc:hover{
								-webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
								   -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
										filter: brightness(1.2) grayscale(.5) opacity(.9);
							}

							/* Extras */
 							.cc-selector-2 input{ margin: 5px 0 0 12px;}
							.cc-selector-2 label{ margin-left: 7px; }
 						</style>
 
													
							<div class="cc-selector text-center">
								<input checked="checked" id="payment_card" type="radio"/>
								<label class="drinkcard-cc visa" for="payment_card"></label>
								 
								<input id="payment_boleto" type="radio"/>
								<label class="drinkcard-cc mastercard" for="payment_boleto"></label>
								 
							</div>
							
							
					</div>
				</div>
			</div>
			
			<!--Campo que jquery buscará com seleção de forma de pagamento-->
			<input type="hidden" id="tipo_pagamento_selecionado" name="tipo_pagamento_selecionado" class="form-control" placeholder="">
		
		
			<!-- Pagamento por Cartão -->
			<div id="step_pagamento_cartao_credito" style="display:none">
				<div class="form_title">
					<h3><strong>3</strong>Informações de Pagamento</h3>
					<p>
						Você está em um ambiente seguro
					</p>
				</div>
				<div class="step">
					<div class="form-group">
						<label>Nome igual ao que está no Cartão</label>
						<input type="text" class="form-control" id="name_card_bookign" name="name_card_bookign">
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Número do Cartão</label>
								<input type="text" id="card_number" name="card_number" class="form-control">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<img src="img/cards.png" width="207" height="43" alt="Cards" class="cards">
							 
						</div>
						
						<div class="col-md-12" style="display:none" id="show_brands_div">
							<div id='show-cards'></div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Data expiração</label>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" id="expire_month" name="expire_month" class="form-control" placeholder="MM">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" id="expire_year" name="expire_year" class="form-control" placeholder="Ano">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cód Segurança</label>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<input type="text" id="ccv" name="ccv" class="form-control" placeholder="CVV">
										</div>
									</div>
									<div class="col-md-8">
										<img src="img/icon_ccv.gif" width="50" height="29" alt="ccv"><small>últimos 3 digitos</small>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-12" id="bt_continue" >
						
							<button type="button" id="checkout_finish" class="btn_1 blue medium">Continuar <i class=" icon-right-circled2"></i></button>
							
							<br>
							<span id="parcelas_div_loading"></span>
						</div>
							<div class="col-md-12"  style="display:none" id="parcelas_div">
								
								<div class="form-group">
									<label>Nº de parcelas</label>
									<div class="row">
										<div class="col-md-12">
											<div id="payment_lists_number_division_div"></div>
											
											<input type="hidden" name="parcelas" class="form-control" id="parcelas">
											<input type="hidden" name="parcelas_valor" class="form-control" id="parcelas_valor">
											
										</div>
									</div>
								</div>
							</div>
							
							<input type="hidden" id="bandeira" name="bandeira" class="form-control" placeholder="">
							<input type="hidden" id="hash_payment" name="hash_payment" class="form-control" placeholder="">
							<input type="hidden" id="token_cartao" name="token_cartao" class="form-control" placeholder="">
							
							

					</div><!--End row -->
					
				</div><!--End step -->
			</div>
			<!-- Pagamento por Cartão -->
			
			

				<!-- Pagamento por boleto -->
					<div id="step_pagamento_boleto" style="display:none">
						<div class="form_title">
							<h3><strong>3</strong>Informações de Pagamento</h3>
							<p>
								Você está em um ambiente seguro
							</p>
						</div>
						<div class="step">
							<div class="row">

							</div><!--End row -->
							
						</div><!--End step -->
					</div>
				<!-- Pagamento por boleto -->	
					

					
					<!-- Botão para Concluir venda -->
						<div id="policy" style="display:none">
							<button type="button" id="checkout_payment" class="btn_1 green medium">Concluir <i class="icon_set_1_icon-76"></i></button>
							<br><br><img src="img/selo04_200x60.gif" >
							<br><br><h5 id="checkout_finish_loading"></h5>
						</div>
					<!-- Botão para Concluir venda -->
		</div>
        
		
		
		
		
		
		
		
				</div>
			</div>
		</div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
					<p>© Checkout Transparente 1.0 2018</p>
				</div>
			</div>
		</div>
	</footer>
     
	
	<!-- Google web fonts -->
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Gochi+Hand' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>

	<!-- CSS -->


	<!-- Common scripts -->
	<script src="js/jquery-1.11.2.min.js"></script>
	<script src="js/functions.js"></script>
	<script src="functions.js"></script>

	<!-- Notify -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">



	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" media="all" rel="stylesheet" type="text/css" />

	 
 



  </body>
</html>




<?php
	
//GERA TOKEN DE TRANSAÇÃO
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url_data);
	curl_setopt ($ch, CURLOPT_POST, 1);
	$parametros = 'email='.$_SESSION['pagseguro_email'].'&token='.$_SESSION['pagseguro_token'];
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $parametros);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);

	$xml_retorno= simplexml_load_string($result);

	$pagSeguroSessionId = $xml_retorno -> id;
//GERA TOKEN DE TRANSAÇÃO
	
?>
<script type="text/javascript">
//MASCARA DOS INPUTS DE TELEFONE
window.onload = function(){
	id('telephone_booking').onkeyup = function(){
		mascara( this, mtel );
	}
	id('telephone_booking2').onkeyup = function(){
		mascara( this, mtel );
	}
}
//MASCARA DOS INPUTS DE TELEFONE




	
	
	
	//CLICA NO BOTÃO DE TRANSAÇÃO (CALCULA DADOS E RETORNA PARCELAS)
	$("#checkout_finish").click(function()
	{
		
		//Dados ficticios
			//$("#card_number").val('4111111111111111');
			//$("#ccv").val('221');
			//$("#expire_month").val('12');
			//$("#expire_year").val('2020');
		//Dados ficticios
		
				
				var car_number		 	= $("#card_number").val();
				var car_ccv 			= $("#ccv").val();
				var car_expire_month 	= $("#expire_month").val();
				var car_expire_year 	= $("#expire_year").val();
				 
				  
 
   				PagSeguroDirectPayment.setSessionId('<?php echo $pagSeguroSessionId; ?>');

				var paymentMethods = PagSeguroDirectPayment.getPaymentMethods({
					amount: <?php echo $_SESSION['total_compra'];?>,
					success: function(response){
							
							var hash_payment = PagSeguroDirectPayment.getSenderHash();
 							$("#hash_payment").val(hash_payment);
							
							
							var cartoes = response.paymentMethods.CREDIT_CARD.options;
							var caminhos = Object.keys(cartoes).map(function(cartao){
								return {
									tipo: cartao,
									path: cartoes[cartao].images.SMALL.path
								};
							});
								
								
								Object.keys(cartoes).forEach(function(cartao){
									var path = cartoes[cartao].images.SMALL.path;
									
									$('<img src="https://stc.pagseguro.uol.com.br/'+path+'" />').appendTo('#show-cards');
								});
								
								
							var cartoes = response.paymentMethods.ONLINE_DEBIT.options;
							var caminhos = Object.keys(cartoes).map(function(cartao){
								return {
									tipo: cartao,
									path: cartoes[cartao].images.SMALL.path
								};
							});
								Object.keys(cartoes).forEach(function(cartao){
									var path = cartoes[cartao].images.SMALL.path;
 
									//$('<img src="https://stc.pagseguro.uol.com.br/'+path+'" />').appendTo('#show-debit');
								});
									
											PagSeguroDirectPayment.getBrand({
												cardBin: car_number,
												success: function(response) {
													$("#bandeira").val(response.brand.name);
													//alert(bandeira);
 												},
												error: function(response) {
													console.log(response);
												},
												complete: function(response) {
													console.log(response);
												}
											});
											
										$("#parcelas_div_loading").html("Um momento, por favor...");				
										setTimeout(function(){
										
										
										//CRIAR TOKEN DA TRANSAÇÃO PARA SER ENVIADO AO PAGSEGURO
											PagSeguroDirectPayment.createCardToken({
													cardNumber: car_number,
													brand: $("#bandeira").val(),
													cvv: car_ccv,
													expirationMonth: car_expire_month,
													expirationYear: car_expire_year,
													success: function(response) {
														//console.log(response);
														$("#token_cartao").val(response.card.token);
													},
													error: function(response) {
														console.log(response);
													},
													complete: function(response) {
														console.log(response);
													}
											});

										
													

											PagSeguroDirectPayment.getInstallments({
											amount: <?php echo $_SESSION['total_compra'];?>,
											brand: $("#bandeira").val(),
											maxInstallmentNoInterest: 2,
											success: function(response)
											{
												//console.log(response);
												
												
												
												///RETORNA DADOS DA PARCELA (GERADO PELO PAGSEGURO)
												bandeira = $("#bandeira").val();
												$("#parcelas_div").show(200);

													var options = "";
													var	retorno_bandeira     = response.installments[bandeira];
														
													for( var i = 0; i < retorno_bandeira.length; i++ )
													{
														 var quantidade = retorno_bandeira[i].quantity;
														 var parcela    = retorno_bandeira[i].installmentAmount;
														 var valorTotal = retorno_bandeira[i].totalAmount;
														  
														  //GERA DIV COM VALOR DAS PARCELAS
														  options += '<div onclick="SelecionaParcelaPagamento('+quantidade+')" class="payment_lists_number_division" id="pagamento_parcela_'+quantidade+'" parcela="'+quantidade+'" parcela_valor="'+parcela+'" total="'+valorTotal+'">' + quantidade + 'x <span>R$</span>  '+parcela+'<br><span> R$ ' + valorTotal + '</span></div>';
													}
													
													$("#payment_lists_number_division_div").html(options);
										 
													$("#parcelas_div_loading").html("");
													
													$("#bt_continue").hide(200);
													$("#policy").show(200);
												///RETORNA DADOS DA PARCELA (GERADO PELO PAGSEGURO)
												
												
											},
											error: function(response) {
												console.log(response);
											},
											complete: function(response) {
												console.log(response);
											}
											});
											
											//CRIAR TOKEN DA TRANSAÇÃO PARA SER ENVIADO AO PAGSEGURO
										}, 2000);
									
					},
					error: function(response){ console.log(response); },
					complete: function(response){ console.log(response); }
				});
				
	});
	//CLICA NO BOTÃO DE TRANSAÇÃO (CALCULA DADOS E RETORNA PARCELAS
	
					
 
	//CLICA NO BOTÃO DE FINALIZAR (CONTATA O PAGSEGURO E FINALIZA A TRANSAÇÃO
	$("#checkout_payment").click(function()
	{
		
		var telephone_booking1		 	= $("#telephone_booking").val();
		var telephone_booking21		 	= $("#telephone_booking2").val();
		
		var endereco_cep1		 		= $("#endereco_cep").val();
		var endereco_endereco1		 	= $("#endereco_endereco").val();
		var endereco_n1		 			= $("#endereco_n").val();
		var endereco_bairro1		 	= $("#endereco_bairro").val();
		var endereco_cidade1		 	= $("#endereco_cidade").val();
		var endereco_complemento1		= $("#endereco_complemento").val();
		var endereco_uf1				= $("#endereco_uf").val();
		
		
		//CAMPOS COM PREENCHIMENTO OBRIGATÓRIO (PARA REMOVER OBRIGATÓRIEDADE BASTA COMENTAR LINHA)
			if (telephone_booking21 == null || telephone_booking21 == ''){  notifica('Falta número celular', 'Por favor, informe um telefone celular', 'error'); $('#modal_pagamento').modal('hide'); $('#telephone_booking2').focus(); return false;}
			
			if (endereco_cep1 == null || endereco_cep1 == ''){ notifica('Falta número do CEP', 'Por favor, informe seu CEP', 'error');$('#modal_pagamento').modal('hide'); $('#endereco_cep').focus(); return false;}
			if (endereco_endereco1 == null || endereco_endereco1 == ''){ notifica('Falta Endereço',  'Por favor, informe seu Endereço', 'error');$('#modal_pagamento').modal('hide'); $('#endereco_endereco').focus(); return false;}
			if (endereco_n1 == null || endereco_n1 == ''){ notifica('Falta número do Endereço',  'Por favor, informe o número no Endereço', 'error');$('#modal_pagamento').modal('hide'); $('#endereco_n').focus(); return false;}
			if (endereco_bairro1 == null || endereco_bairro1 == ''){ notifica('Falta Bairro',  'Por favor, informe um Bairro', 'error');$('#modal_pagamento').modal('hide'); $('#endereco_bairro').focus(); return false;}
			if (endereco_cidade1 == null || endereco_cidade1 == ''){ notifica('Falta Cidade', 'Por favor, informe sua Cidade', 'error'); $('#modal_pagamento').modal('hide');$('#endereco_cidade').focus(); return false;}
			if (endereco_uf1 == null || endereco_uf1 == ''){ notifica('Falta Estado',  'Por favor, informe um Estado', 'error');$('#modal_pagamento').modal('hide'); $('#endereco_uf').focus(); return false;}
		//CAMPOS COM PREENCHIMENTO OBRIGATÓRIO (PARA REMOVER OBRIGATÓRIEDADE BASTA COMENTAR LINHA)
		
		
			var name_card_bookign1	= $("#name_card_bookign").val();
			var card_number1		= $("#card_number").val();
			var expire_month1 		= $("#expire_month").val();
			var expire_year1 		= $("#expire_year").val();
			var ccv1 				= $("#ccv").val();
			var bandeira1 			= $("#bandeira").val();
			
			var parcelas1 			= $("#parcelas").val();
			var parcelas_valor1 	= $("#parcelas_valor").val();
									 
			var token_cartao1 		= $("#token_cartao").val();
			var hash_payment1 		= $("#hash_payment").val();
			
			
			
		var tipo_pagamento_selecionado1 = $("#tipo_pagamento_selecionado").val();
		
		if(tipo_pagamento_selecionado1 == 'cartao') //Cartão de credito
		{
			//Pagamento via Cartão

			if (name_card_bookign1 == null || name_card_bookign1 == ''){ notifica('Falta nome no cartão de crédito',  'Por favor, informe o nome que está no cartão de crédito', 'error');$('#modal_pagamento').modal('hide'); $('#name_card_bookign').focus(); return false;}
			if (card_number1 == null || card_number1 == ''){ notifica('Falta número do cartão',  'Por favor, informe o número do cartão', 'error');$('#modal_pagamento').modal('hide'); $('#card_number').focus(); return false;}
			if (expire_month1 == null || expire_month1 == ''){ notifica('Falta mês que expira o cartão',  'Por favor, informe o mês que expira o cartão', 'error');$('#modal_pagamento').modal('hide'); $('#expire_month').focus(); return false;}
			if (expire_year1 == null || expire_year1 == ''){ notifica('Falta ano em que expira seu cartão', 'Por favor, informe o ano em que expira seu cartão', 'error'); $('#modal_pagamento').modal('hide');$('#expire_year').focus(); return false;}
			if (ccv1 == null || ccv1 == ''){ notifica('Falta número CVV', 'Por favor, informe o Código CVV (Código de segurança) de seu cartão', 'error');$('#modal_pagamento').modal('hide'); $('#ccv').focus(); return false;}
			
			if (parcelas1 == null || parcelas1 == '' || parcelas1 == '-'){ notifica('Falta selecione uma opção para pagamento',  'Por favor, selecione uma opção para pagamento', 'error'); $('#modal_pagamento').modal('hide');$('#parcelas').focus(); return false;}
			//Pagamento via Cartão
		}
		else //Boleto
		{
			
			//Gera o Hash de pagamento para Boleto
				PagSeguroDirectPayment.setSessionId('<?php echo $pagSeguroSessionId; ?>');

				var hash_payment = PagSeguroDirectPayment.getSenderHash();
				var hash_payment1 = hash_payment;
			//Gera o Hash de pagamento para Boleto
		}
					//Prepara modal (Limpa modal e adiciona Loading(Carregando))
					$("#modal_pagamento").modal("show");
					$("#modal_pagamento_resultado").html('');
					$("#modal_pagamento_wait").html("Por favor, aguarde");
					$("#modal_pagamento_loading").attr("src", "img/loading.gif");
					
					
				
				//ENVIA PORT PARA PHP PARA ENVIO DE XML
				setTimeout(function(){
					$.post("_checkout_validate.php",
					{
					  telephone_booking: telephone_booking1,
					  telephone_booking2: telephone_booking21,
					  endereco_cep: endereco_cep1,
					  endereco_endereco: endereco_endereco1,
					  endereco_n: endereco_n1,
					  endereco_bairro: endereco_bairro1,
					  endereco_cidade: endereco_cidade1,
					  endereco_complemento: endereco_complemento1,
					  endereco_uf: endereco_uf1,
					  
					  name_card_bookign: name_card_bookign1,
					  card_number: card_number1,
					  expire_month: expire_month1,
					  expire_year: expire_year1,
					  ccv: ccv1,
					  bandeira: bandeira1,
					  parcelas: parcelas1,
					  parcelas_valor: parcelas_valor1,
					  
					  token_cartao: token_cartao1,
					  hash_payment: hash_payment1,
					  
					  tipo_pagamento: tipo_pagamento_selecionado1
					  
						

					}, function(data)
					{
						
							
							var res = data.split("_");
								
								//RETORNO DO POST DO XML
								if(res[0]==1) //ERRO
								{
									$("#modal_pagamento_resultado").html("'"+res[1]+"'");
									$("#modal_pagamento_loading").attr("src", "img/erro.png");
									$("#modal_pagamento_wait").html("");
								}
								else //SUCESSO
								{
									$("#modal_pagamento_loading").attr("src", "img/sucesso.png");
									
									$("#modal_pagamento_code").html('Código do Pagseguro: '+res[1]);
									
									if(tipo_pagamento_selecionado1 == 'boleto') //SE PAGAMENTO FOI BOLETO'
									{
										$("#modal_pagamento_wait").html("É preciso que o boleto seja impresso e pago");
										$("#modal_pagamento_boleto_link").html('<a href="<?php echo $_SESSION['retorno']; ?>' + encodeURIComponent(res[2])+'" target="_blank">Imprima seu boleto</a>');
									}
									else //SE PAGAMENTO FOI CARTÃO
									{
										$("#modal_pagamento_wait").html("Pagamento realizado com sucesso");
									}
									
								}
						//alert(data);
						
					});
					
				}, 4000); // Aplica delay de 4 segundos para gerar o hash
	});
	//CLICA NO BOTÃO DE FINALIZAR (CONTATA O PAGSEGURO E FINALIZA A TRANSAÇÃO	
 
 		 
	 
	
	
	$("#payment_card").click(function()
	{
		$("#step_pagamento_cartao_credito").show(500);
		$("#step_pagamento_boleto").hide(500);
			$("#bt_continue").show(200);
		
		$("#tipo_pagamento_selecionado").val("cartao");
		
	});
	
	$("#payment_boleto").click(function()
	{
		$("#step_pagamento_cartao_credito").hide(500);
		$("#step_pagamento_boleto").show(500);
			$("#checkout_payment").show(200);
			$("#policy").show(200);
			
		$("#tipo_pagamento_selecionado").val("boleto");
	});
 
	
	
	
	 

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#endereco_endereco").val("");
                $("#endereco_bairro").val("");
                $("#endereco_cidade").val("");
				$("#endereco_uf").val("");
            }
            
			
			
			
            //BUSCA CEP
            $("#endereco_cep").blur(function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep != "") {
                    var validacep = /^[0-9]{8}$/;

                    if(validacep.test(cep)) {
                        $("#endereco_endereco").val("...");
                        $("#endereco_bairro").val("...");
                        $("#endereco_cidade").val("...");
                        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                $("#endereco_endereco").val(dados.logradouro);
                                $("#endereco_bairro").val(dados.bairro);
                                $("#endereco_cidade").val(dados.localidade);
								$("#endereco_uf").val(dados.uf);
								 $("#endereco_n").focus();
 
                            } //end if.
                            else {
                                limpa_formulário_cep();
                            }
                        });
                    } //end if.
                    else {
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    limpa_formulário_cep();
                }
            });
			//BUSCA CEP
	
	
	
	
	
	
	
	 
	//INATIVA (EXIBE TODAS AS BANDEIRAS QUE O PAGSEGURO ACEITA
	function show_brands()
	{
		$("#show_brands_div").show(150);
	}
	//INATIVA (EXIBE TODAS AS BANDEIRAS QUE O PAGSEGURO ACEITA
	
	




	// APTA A DIV DE PARCELA A SER CLICAVEL (CAPTURA VALOES)
	function SelecionaParcelaPagamento(parcela)
	{
	   // alert('teste');
		//event.preventDefault();
		$('.payment_lists_number_division').css({color:"#0f837e", backgroundColor: "#83e7e3" });
	 
		var Parcela = $('#pagamento_parcela_'+parcela).attr('parcela');
		var Parcela_valor = $('#pagamento_parcela_'+parcela).attr('parcela_valor');
		 
		$('#pagamento_parcela_'+parcela).css({color:"#FFF", backgroundColor: "#2d8d89" });
		
		$("#parcelas").val(Parcela);
		$("#parcelas_valor").val(Parcela_valor);
	}
	// APTA A DIV DE PARCELA A SER CLICAVEL (CAPTURA VALOES)


</script>
 
 
  

<div class="modal fade" id="modal_pagamento" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
      </div>
      <div class="modal-body" style="text-align:center;height:50%">
		<br><br>
        <h3><b>Confirmando pagamento</b></h3>
			<div id="modal_pagamento_resultado"></div>
		<br>
		<img id="modal_pagamento_loading" src="img/loading.gif">
		<br><br>
		<span id="modal_pagamento_wait">Por favor, aguarde...</span>
		<br>
		<span id="modal_pagamento_code"></span><br>
		<span id="modal_pagamento_boleto_link"></span>
		<br>
		<br><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="javascript:location.href='<?php echo $_SESSION['retorno']; ?>';">Ok, Entendi</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

 