<?php
	
function CriaPreferenciaEmpresa($cod_empresa)
{

    //DEFAULT
    $salao_nome = "";
    $salao_telefone = "";
    $salao_proprietario = "";
    $salao_email = "";
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
    $agenda_cor_1 = "";
    $agenda_cor_2 = "";
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


    $sql = "
    INSERT INTO `claudio_company`.`empresas_preferencias`
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
    ('".$cod_empresa."',
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

    //echo $sql;die;

    //mysql_query($sql);

}


?>
