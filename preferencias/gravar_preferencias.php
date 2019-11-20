<?php 

session_start();

include('../config/conexao.php');

include('../include/funcoes.php');

include('preferencias_inc.php');
	
//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************


if (isset($_REQUEST["acao"])){ 
	$acao = $_REQUEST["acao"]; 
}

$cod_empresa = $_SESSION['cod_empresa'];

switch ($acao) 
{
	case 'dados_salao':

		if (isset($_REQUEST["salao_nome"])) { $salao_nome = $_REQUEST["salao_nome"]; } else { $salao_nome = "NULL"; }
		if (isset($_REQUEST["salao_telefone"])) { $salao_telefone = $_REQUEST["salao_telefone"]; } else { $salao_telefone = "NULL"; }
		if (isset($_REQUEST["salao_proprietario"])) { $salao_proprietario = $_REQUEST["salao_proprietario"]; } else { $salao_proprietario = "NULL"; }
		if (isset($_REQUEST["salao_email"])) { $salao_email = $_REQUEST["salao_email"]; } else { $salao_email = "NULL"; }
		if (isset($_REQUEST["salao_cep"])) { $salao_cep = $_REQUEST["salao_cep"]; } else { $salao_cep = "NULL"; }
		if (isset($_REQUEST["salao_endereco"])) { $salao_endereco = $_REQUEST["salao_endereco"]; } else { $salao_endereco = "NULL"; }
		if (isset($_REQUEST["salao_numero"])) { $salao_numero = $_REQUEST["salao_numero"]; } else { $salao_numero = "NULL"; }
		if (isset($_REQUEST["salao_complemento"])) { $salao_complemento = $_REQUEST["salao_complemento"]; } else { $salao_complemento = "NULL"; }
		if (isset($_REQUEST["salao_bairro"])) { $salao_bairro = $_REQUEST["salao_bairro"]; } else { $salao_bairro = "NULL"; }
		if (isset($_REQUEST["salao_cidade"])) { $salao_cidade = $_REQUEST["salao_cidade"]; } else { $salao_cidade = "NULL"; }
		if (isset($_REQUEST["salao_estado"])) { $salao_estado = $_REQUEST["salao_estado"]; } else { $salao_estado = "NULL"; }

		$sqlPreferencias = "		
		update
			empresas_preferencias
		set
			salao_nome = '".$salao_nome."'
			,salao_telefone = '".$salao_telefone."'
			,salao_proprietario = '".$salao_proprietario."'
			,salao_email = '".$salao_email."'
			,salao_cep = '".$salao_cep."'
			,salao_endereco = '".$salao_endereco."'
			,salao_numero = '".$salao_numero."'
			,salao_complemento = '".$salao_complemento."'
			,salao_bairro = '".$salao_bairro."'
			,salao_cidade = '".$salao_cidade."'
			,salao_estado = '".$salao_estado."'
		where
			cod_empresa = ".$cod_empresa."
		";

		//echo $sqlPreferencias;die;

		mysql_query($sqlPreferencias);


		break;
	
	case 'comissoes':

		if (isset($_REQUEST["comissao_flg_1"])) { $comissao_flg_1 = "true"; } else { $comissao_flg_1 = "false"; }
		if (isset($_REQUEST["comissao_flg_2"])) { $comissao_flg_2 = "true"; } else { $comissao_flg_2 = "false"; }
		if (isset($_REQUEST["comissao_flg_3"])) { $comissao_flg_3 = "true"; } else { $comissao_flg_3 = "false"; }
		if (isset($_REQUEST["comissao_flg_4"])) { $comissao_flg_4 = "true"; } else { $comissao_flg_4 = "false"; }
		if (isset($_REQUEST["comissao_flg_5"])) { $comissao_flg_5 = "true"; } else { $comissao_flg_5 = "false"; }
		if (isset($_REQUEST["comissao_flg_6"])) { $comissao_flg_6 = "true"; } else { $comissao_flg_6 = "false"; }
		if (isset($_REQUEST["comissao_flg_7"])) { $comissao_flg_7 = "true"; } else { $comissao_flg_7 = "false"; }

		$sqlPreferencias = "		
		update
			empresas_preferencias
		set
			comissao_flg_1 = ".$comissao_flg_1."
			,comissao_flg_2 = ".$comissao_flg_2."
			,comissao_flg_3 = ".$comissao_flg_3."
			,comissao_flg_4 = ".$comissao_flg_4."
			,comissao_flg_5 = ".$comissao_flg_5."
			,comissao_flg_6 = ".$comissao_flg_6."
			,comissao_flg_7 = ".$comissao_flg_7."
		where
			cod_empresa = ".$cod_empresa."
		";

		//echo $sqlPreferencias;die;

		mysql_query($sqlPreferencias);

		break;

	case 'agenda':

		if (isset($_REQUEST["agenda_hora_inicial"])) { $agenda_hora_inicial = "'".$_REQUEST["agenda_hora_inicial"]."'"; } else { $agenda_hora_inicial = "NULL"; }
		if (isset($_REQUEST["agenda_hora_final"])) { $agenda_hora_final = "'".$_REQUEST["agenda_hora_final"]."'"; } else { $agenda_hora_final = "NULL"; }
		if (isset($_REQUEST["agenda_intervalo"])) { $agenda_intervalo = "'".$_REQUEST["agenda_intervalo"]."'"; } else { $agenda_intervalo = "NULL"; }
		if (isset($_REQUEST["agenda_cor_1"])) { $agenda_cor_1 = "'".$_REQUEST["agenda_cor_1"]."'"; } else { $agenda_cor_1 = "NULL"; }
		if (isset($_REQUEST["agenda_cor_2"])) { $agenda_cor_2 = "'".$_REQUEST["agenda_cor_2"]."'"; } else { $agenda_cor_2 = "NULL"; }

		if (isset($_REQUEST["agenda_flg_1"])) { $agenda_flg_1 = "true"; } else { $agenda_flg_1 = "false"; }
		if (isset($_REQUEST["agenda_flg_2"])) { $agenda_flg_2 = "true"; } else { $agenda_flg_2 = "false"; }
		if (isset($_REQUEST["agenda_flg_3"])) { $agenda_flg_3 = "true"; } else { $agenda_flg_3 = "false"; }
		if (isset($_REQUEST["agenda_flg_4"])) { $agenda_flg_4 = "true"; } else { $agenda_flg_4 = "false"; }

		$sqlPreferencias = "		
		update
			empresas_preferencias
		set
			agenda_hora_inicial = ".$agenda_hora_inicial."
			,agenda_hora_final = ".$agenda_hora_final."
			,agenda_intervalo = ".$agenda_intervalo."
			,agenda_cor_1 = ".$agenda_cor_1."
			,agenda_cor_2 = ".$agenda_cor_2."
			,agenda_flg_1 = ".$agenda_flg_1."
			,agenda_flg_2 = ".$agenda_flg_2."
			,agenda_flg_3 = ".$agenda_flg_3."
			,agenda_flg_4 = ".$agenda_flg_4."
		where
			cod_empresa = ".$cod_empresa."
		";

		//echo $sqlPreferencias;die;

		mysql_query($sqlPreferencias);

		break;

	case 'cadastros':

		if (isset($_REQUEST["cadastro_cidade_padrao"])) { $cadastro_cidade_padrao = "'".$_REQUEST["cadastro_cidade_padrao"]."'"; } else { $cadastro_cidade_padrao = "NULL"; }
		if (isset($_REQUEST["cadastro_estado_padrao"])) { $cadastro_estado_padrao = "'".$_REQUEST["cadastro_estado_padrao"]."'"; } else { $cadastro_estado_padrao = "NULL"; }
		if (isset($_REQUEST["cadastro_cep_padrao"])) { $cadastro_cep_padrao = "'".$_REQUEST["cadastro_cep_padrao"]."'"; } else { $cadastro_cep_padrao = "NULL"; }

		if (isset($_REQUEST["cadastro_flag_1"])) { $cadastro_flag_1 = "true"; } else { $cadastro_flag_1 = "false"; }
		if (isset($_REQUEST["cadastro_flag_2"])) { $cadastro_flag_2 = "true"; } else { $cadastro_flag_2 = "false"; }
		if (isset($_REQUEST["cadastro_flag_3"])) { $cadastro_flag_3 = "true"; } else { $cadastro_flag_3 = "false"; }
		if (isset($_REQUEST["cadastro_flag_4"])) { $cadastro_flag_4 = "true"; } else { $cadastro_flag_4 = "false"; }
		if (isset($_REQUEST["cadastro_flag_5"])) { $cadastro_flag_5 = "true"; } else { $cadastro_flag_5 = "false"; }
		if (isset($_REQUEST["cadastro_flag_6"])) { $cadastro_flag_6 = "true"; } else { $cadastro_flag_6 = "false"; }
		if (isset($_REQUEST["cadastro_flag_7"])) { $cadastro_flag_7 = "true"; } else { $cadastro_flag_7 = "false"; }
		if (isset($_REQUEST["cadastro_flag_8"])) { $cadastro_flag_8 = "true"; } else { $cadastro_flag_8 = "false"; }
		if (isset($_REQUEST["cadastro_flag_9"])) { $cadastro_flag_9 = "true"; } else { $cadastro_flag_9 = "false"; }

		$sqlPreferencias = "		
		update
			empresas_preferencias
		set
			cadastro_cidade_padrao = ".$cadastro_cidade_padrao."
			,cadastro_estado_padrao = ".$cadastro_estado_padrao."
			,cadastro_cep_padrao = ".$cadastro_cep_padrao."
			,cadastro_flag_1 = ".$cadastro_flag_1."
			,cadastro_flag_2 = ".$cadastro_flag_2."
			,cadastro_flag_3 = ".$cadastro_flag_3."
			,cadastro_flag_4 = ".$cadastro_flag_4."
			,cadastro_flag_5 = ".$cadastro_flag_5."
			,cadastro_flag_6 = ".$cadastro_flag_6."
			,cadastro_flag_7 = ".$cadastro_flag_7."
			,cadastro_flag_8 = ".$cadastro_flag_8."
			,cadastro_flag_9 = ".$cadastro_flag_9."
		where
			cod_empresa = ".$cod_empresa."
		";

		//echo $sqlPreferencias;die;

		mysql_query($sqlPreferencias);

		break;


	case 'estoque':

		if (isset($_REQUEST["estoque_flg_1"])) { $estoque_flg_1 = "true"; } else { $estoque_flg_1 = "false"; }

		$sqlPreferencias = "		
		update
			empresas_preferencias
		set
			estoque_flg_1 = ".$estoque_flg_1."
		where
			cod_empresa = ".$cod_empresa."
		";

		//echo $sqlPreferencias;die;

		mysql_query($sqlPreferencias);

		break;

}

MontarPreferencias($cod_empresa);

echo "<script language='javascript'>window.location='preferencias.php?sucesso=1';</script>";




?>