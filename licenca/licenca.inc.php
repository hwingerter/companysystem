<?php

function LicenciarEmpresa_30Dias($cod_empresa, $cod_licenca)
{

    $sql = "select valor from licencas where cod_licenca = ".$cod_licenca.";";
    $query 	= mysql_query($sql);
	$rs 	= mysql_fetch_array($query);
    $valor = $rs['valor'];


	$dt_inicio = date("Y-m-d");
	$dt_vencimento = date("Y-m-d", strtotime('+30 day'));
	$flg_situacao = "A";

	$sqlLicenca = "
	INSERT INTO empresas_licenca
	(`cod_empresa`,
	`cod_licenca`,
	`dt_inicio`,
	`dt_vencimento`,
	`valor`,
	`flg_situacao`)
	VALUES
	(".$cod_empresa.",
	".$cod_licenca.",
	'".$dt_inicio."',
	'".$dt_vencimento."',
	".$valor.",
	'".$flg_situacao."'
	);
	";
	
	//echo $sqlLicenca;die;

	mysql_query($sqlLicenca);

}

function LicenciarEmpresa($cod_empresa, $cod_licenca)
{

    $sql = "select valor from licencas where cod_licenca = ".$cod_licenca.";";
    $query 	= mysql_query($sql);
	$rs 	= mysql_fetch_array($query);
    $valor = $rs['valor'];


	$dt_inicio = date("Y-m-d");
	$dt_vencimento = date("Y-m-d", strtotime('+10 day'));
	$flg_situacao = "A";

	$sqlLicenca = "
	INSERT INTO empresas_licenca
	(`cod_empresa`,
	`cod_licenca`,
	`dt_inicio`,
	`dt_vencimento`,
	`valor`,
	`flg_situacao`)
	VALUES
	(".$cod_empresa.",
	".$cod_licenca.",
	'".$dt_inicio."',
	'".$dt_vencimento."',
	".$valor.",
	'".$flg_situacao."'
	);
	";
	
	//echo $sqlLicenca;die;

	mysql_query($sqlLicenca);

}

function ObterSituacaoLicencaAtual($cod_empresa)
{

    if ($cod_empresa == ""){
        return "A";
    }

	$sql = "select dt_vencimento from empresas_licenca where cod_empresa = ".$cod_empresa.";";
    $query 	= mysql_query($sql);
	$rs 	= mysql_fetch_array($query);

    $DataAtual       = date("Y-m-d");
    $data_vencimento = $rs['dt_vencimento'];

    $dt1 = strtotime($DataAtual);
    $dt2 = strtotime($data_vencimento);

    if($dt1 > $dt2)
    {
        //echo "entrei1";die;
        return "I";
    }
    else{
        //echo "entrei2";die;
        return "A";
    }

}

function ObterLicencaAtual($cod_empresa)
{

	$sql = "
	select 		cod_licenca
	from 		empresas_licenca 
	where 		cod_empresa = ".$cod_empresa." 
	and 		flg_situacao = 'A'
	order by	cod_empresa_licenca
	limit		1;
	";
	//echo $sql;die;
    $query 	= mysql_query($sql);
	if(mysql_num_rows($query) > 0){
		$rs 	= mysql_fetch_array($query);
		return $rs['cod_licenca'];
	}
	else {
		return 0;
	}

}

function InativarLicencaAtualEmpresa($cod_empresa)
{

    $sql = "update empresas_licenca set flg_situacao = 'I' where cod_empresa = ".$cod_empresa.";";
    //echo $sql;die;
    mysql_query($sql);

}

?>