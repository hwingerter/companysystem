<?php 

function CriarPreferencias($cod_empresa, $empresa, $telefone, $nome, $email)
{
	//PREFERENCIAS
	//DEFAULT
	$salao_nome = $empresa;
	$salao_telefone = $telefone;
	$salao_proprietario = $nome;
	$salao_email = $email;
	$salao_cep = "";
	$salao_endereco = "";
	$salao_numero = "";
	$salao_complemento = "";
	$salao_bairro = "";
	$salao_cidade = "";
	$salao_estado = "";
	$comissao_flg_1 = true;
	$comissao_flg_2 = true;
	$comissao_flg_3 = false;
	$comissao_flg_4 = false;
	$comissao_flg_5 = false;
	$comissao_flg_6 = false;
	$comissao_flg_7 = false;
	$agenda_hora_inicial = "08:00";
	$agenda_hora_final = "17:00";
	$agenda_intervalo = "30";
	$agenda_cor_1 = "#d823be";
	$agenda_cor_2 = "#398b36";
	$agenda_flg_1 = false;
	$agenda_flg_2 = false;
	$agenda_flg_3 = false;
	$agenda_flg_4 = false;
	$cadastro_cidade_padrao = "";
	$cadastro_estado_padrao = "";
	$cadastro_cep_padrao = "";
	$cadastro_flag_1 = true;
	$cadastro_flag_2 = false;
	$cadastro_flag_3 = true;
	$cadastro_flag_4 = true;
	$cadastro_flag_5 = true;
	$cadastro_flag_6 = true;
	$cadastro_flag_7 = true;
	$cadastro_flag_8 = true;
	$cadastro_flag_9 = false;
	$estoque_flg_1 = true;

	$sqlPreferencias = "
	INSERT INTO `empresas_preferencias`
	(`cod_empresa`,
	`salao_nome`,
	`salao_telefone`,
	`salao_proprietario`,
	`salao_email`,
	`salao_cep`,
	`salao_endereco`,
	`salao_numero`,
	`salao_complemento`,
	`salao_bairro`,
	`salao_cidade`,
	`salao_estado`,
	`comissao_flg_1`,
	`comissao_flg_2`,
	`comissao_flg_3`,
	`comissao_flg_4`,
	`comissao_flg_5`,
	`comissao_flg_6`,
	`comissao_flg_7`,
	`agenda_hora_inicial`,
	`agenda_hora_final`,
	`agenda_intervalo`,
	`agenda_cor_1`,
	`agenda_cor_2`,
	`agenda_flg_1`,
	`agenda_flg_2`,
	`agenda_flg_3`,
	`agenda_flg_4`,
	`cadastro_cidade_padrao`,
	`cadastro_estado_padrao`,
	`cadastro_cep_padrao`,
	`cadastro_flag_1`,
	`cadastro_flag_2`,
	`cadastro_flag_3`,
	`cadastro_flag_4`,
	`cadastro_flag_5`,
	`cadastro_flag_6`,
	`cadastro_flag_7`,
	`cadastro_flag_8`,
	`cadastro_flag_9`,
	`estoque_flg_1`)
	VALUES
	(".$cod_empresa.",
	'".$salao_nome."',
	'".$salao_telefone."',
	'".$salao_proprietario."',
	'".$salao_email."',
	'".$salao_cep."',
	'".$salao_endereco."',
	'".$salao_numero."',
	'".$salao_complemento."',
	'".$salao_bairro."',
	'".$salao_cidade."',
	'".$salao_estado."',
	'".$comissao_flg_1."',
	'".$comissao_flg_2."',
	'".$comissao_flg_3."',
	'".$comissao_flg_4."',
	'".$comissao_flg_5."',
	'".$comissao_flg_6."',
	'".$comissao_flg_7."',
	'".$agenda_hora_inicial."',
	'".$agenda_hora_final."',
	'".$agenda_intervalo."',
	'".$agenda_cor_1."',
	'".$agenda_cor_2."',
	'".$agenda_flg_1."',
	'".$agenda_flg_2."',
	'".$agenda_flg_3."',
	'".$agenda_flg_4."',
	'".$cadastro_cidade_padrao."',
	'".$cadastro_estado_padrao."',
	'".$cadastro_cep_padrao."',
	'".$cadastro_flag_1."',
	'".$cadastro_flag_2."',
	'".$cadastro_flag_3."',
	'".$cadastro_flag_4."',
	'".$cadastro_flag_5."',
	'".$cadastro_flag_6."',
	'".$cadastro_flag_7."',
	'".$cadastro_flag_8."',
	'".$cadastro_flag_9."',
	'".$estoque_flg_1."');
	";

	//echo "teste".$sqlPreferencias;die;

	if (!mysql_query($sqlPreferencias)){
		die (mysql_error());
	}
}

function MontarPreferencias($cod_empresa)
{
	session_start();

	$sqlPreferencias = "select * from empresas_preferencias where cod_empresa = ".$cod_empresa.";";
	//echo $sqlPreferencias;die;
	$queryPreferencias = mysql_query($sqlPreferencias);
	$rs = mysql_fetch_array($queryPreferencias);

	/*
	$salao_nome = $rs["salao_nome"];
	$salao_telefone = $rs["salao_telefone"];
	$salao_proprietario = $rs["salao_proprietario"];
	$salao_email = $rs["salao_email"];
	$salao_cep = $rs["salao_cep"];
	$salao_endereco = $rs["salao_endereco"];
	$salao_numero = $rs["salao_numero"];
	$salao_complemento = $rs["salao_complemento"];
	$salao_bairro = $rs["salao_bairro"];
	$salao_cidade = $rs["salao_cidade"];
	$salao_estado = $rs["salao_estado"];
	*/
	$_SESSION['comissao_flg_1'] = $rs["comissao_flg_1"];
	$_SESSION['comissao_flg_2'] = $rs["comissao_flg_2"];
	$_SESSION['comissao_flg_3'] = $rs["comissao_flg_3"];
	$_SESSION['comissao_flg_4'] = $rs["comissao_flg_4"];
	$_SESSION['comissao_flg_5'] = $rs["comissao_flg_5"];
	$_SESSION['comissao_flg_6'] = $rs["comissao_flg_6"];
	$_SESSION['comissao_flg_7'] = $rs["comissao_flg_7"];
	
	$_SESSION['agenda_hora_inicial'] = $rs["agenda_hora_inicial"];
	$_SESSION['agenda_hora_final'] 	 = $rs["agenda_hora_final"];
	$_SESSION['agenda_intervalo'] 	 = $rs["agenda_intervalo"];
	/*
	$agenda_cor_1 = $rs["agenda_cor_1"];
	$agenda_cor_2 = $rs["agenda_cor_2"];
	$agenda_flg_1 = $rs["agenda_flg_1"];
	$agenda_flg_2 = $rs["agenda_flg_2"];
	$agenda_flg_3 = $rs["agenda_flg_3"];
	$agenda_flg_4 = $rs["agenda_flg_4"];
	*/
	/*
	$cadastro_cidade_padrao = $rs["cadastro_cidade_padrao"];
	$cadastro_estado_padrao = $rs["cadastro_estado_padrao"];
	$cadastro_cep_padrao = $rs["cadastro_cep_padrao"];
	*/
	$_SESSION['cadastro_flag_1'] 	= $rs["cadastro_flag_1"];
	$_SESSION['cadastro_flag_2'] 	= $rs["cadastro_flag_2"];
	$_SESSION['cadastro_flag_3'] 	= $rs["cadastro_flag_3"];
	$_SESSION['cadastro_flag_4'] 	= $rs["cadastro_flag_4"];
	$_SESSION['cadastro_flag_5'] 	= $rs["cadastro_flag_5"];
	$_SESSION['cadastro_flag_6'] 	= $rs["cadastro_flag_6"];
	$_SESSION['cadastro_flag_7'] 	= $rs["cadastro_flag_7"];
	$_SESSION['cadastro_flag_8'] 	= $rs["cadastro_flag_8"];
	$_SESSION['cadastro_flag_9'] 	= $rs["cadastro_flag_9"];
	/*			
	$estoque_flg_1 = $rs["estoque_flg_1"];
	*/

}
?>