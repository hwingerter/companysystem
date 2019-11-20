<?php
include('funcoes.php');

if (isset($_REQUEST['fluxo'])) { $fluxo = $_REQUEST['fluxo']; } else { $fluxo = ''; }

$sql = "Select * from boletos where cod_fluxo = " . limpa_int($fluxo);
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
if ($registros > 0) {
	if ($rs = mysql_fetch_array($query)){
		$emissao = $rs['emissao'];
		$nosso_numero = $rs['nosso_numero'];
		$numero_documento = $rs['numero_documento'];
		$valor = $rs['valor'];
		
	}
}

$sql = "Select * from fluxo_caixa where cod_fluxo = " . limpa_int($fluxo);
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
if ($registros > 0) {
	if ($rs = mysql_fetch_array($query)){
		$cod_cliente = $rs['cod_cliente'];
		$cod_financeiro = $rs['cod_financeiro'];
		$vencimento = DataMysqlPhp($rs['vencimento']);
		$parcela = $rs['parcela'];
		$total_parcelas = $rs['total_parcelas'];
		$obs = $rs['obs'];
	}
}
	
$sql = "Select * from clientes where cod_cliente = " . $cod_cliente;
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
if ($registros > 0) {
	if ($rs = mysql_fetch_array($query)){
			
			if ($rs['tipo_pessoa'] == 'PF') {
				$cliente = $rs['nome'];
			} else if ($rs['tipo_pessoa'] == 'PJ') {
				$cliente = $rs['empresa'];
			}
			$email = $rs['email'];
			$cnpj = $rs['cnpj'];
			$cpf = $rs['cpf'];
			$endereco = $rs['endereco'];
			$cep = $rs['cep'];
			$estado = $rs['estado'];
			$cidade = $rs['cidade'];
			$telefone = $rs['telefone'];
			$site = $rs['site'];
	}
}

$demostrativo = '';

if (($cod_financeiro == '2') || ($cod_financeiro == '3')) { $demostrativo = "Parcela ". $parcela . " de ". $total_parcelas ."."; }

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $valor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $nosso_numero;  // Nosso numero - REGRA: Máximo de 8 caracteres!
$dadosboleto["numero_documento"] = $numero_documento;	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $vencimento; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = mb_convert_encoding($cliente, "ISO-8859-1", "UTF-8");
$dadosboleto["endereco1"] = mb_convert_encoding($endereco, "ISO-8859-1", "UTF-8");
$dadosboleto["endereco2"] =  ExibeCidade($cidade) ." - ". ExibeEstado($estado) ." -  CEP: ". $cep;

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Referente ao serviço de ". mb_convert_encoding((strtolower(PegaFinanceiro($cod_financeiro))), "ISO-8859-1", "UTF-8") . ".";
$dadosboleto["demonstrativo2"] = $site;
$dadosboleto["demonstrativo3"] = $demostrativo;
$dadosboleto["instrucoes1"] = "Boleto emitido pelo sistema da Deltario Tecnologia - www.deltario.com.br";
$dadosboleto["instrucoes2"] = "Em caso de dúvidas entre em contato conosco: contato@deltario.com.br";
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - ITAÚ
$dadosboleto["agencia"] = "3032"; // Num da agencia, sem digito
$dadosboleto["conta"] = "38478";	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "0"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - ITAÚ
$dadosboleto["carteira"] = "175";  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

// SEUS DADOS
$dadosboleto["identificacao"] = "Deltario Tecnologia e Informatica Ltda";
$dadosboleto["cpf_cnpj"] = "12.844.978/0001-19";
$dadosboleto["endereco"] = "Rua Do Trabalho, 428, Apt 302, Vila Da Penha";
$dadosboleto["cidade_uf"] = "Rio de Janeiro / RJ";
$dadosboleto["cedente"] = "Deltario Tecnologia e Informatica Ltda";

// NÃO ALTERAR!
include("include/funcoes_itau.php"); 
include("include/layout_itau.php");
?>
