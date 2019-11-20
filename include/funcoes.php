<?php

/*goHTTPS();

function goHTTPS() {
	if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
	    $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	
	    header('HTTP/1.1 301 Moved Permanently');
	    header("Location: $redirect_url");
	    exit();
	}
}
*/

function limpa($dado) 
{
	$lixo = array("'", "%", "\\", "/", "\"", ";", "\0", chr(0), chr(1), chr(2), chr(3), chr(4), chr(5), chr(6), chr(7), chr(8), chr(9), chr(10), chr(11), chr(12), chr(13), chr(14), chr(15), chr(16));
    $resp = str_replace($lixo, "", $dado);
	$resp = addslashes($resp);
	
	return $resp;
}

function limpa_int($inteiro) {
	
	$resp = intval($inteiro);
	$resp = addslashes($resp);
	
	return $resp;
}

function DataMysqlPhp($dataPagina){

	$dia = substr($dataPagina,8,2);
	$mes = substr($dataPagina,5,2);
	$ano = substr($dataPagina,0,4);
	return ($dia."/".$mes."/".$ano);

}

function DataPhpMysql($dataPagina){

	if ($dataPagina != ""){
		$dia = substr($dataPagina,0,2);
		$mes = substr($dataPagina,3,2);
		$ano = substr($dataPagina,6,6);
		return ($ano.'-'.$mes.'-'.$dia);
	}else{
		return('Null');
	}	
}


function DataPhpMysql2($dataPagina){

	if ($dataPagina != ""){
		$dia = substr($dataPagina,0,2);
		$mes = substr($dataPagina,3,2);
		$ano = substr($dataPagina,6,6);
		return ("'".$ano.'-'.$mes.'-'.$dia."'");
	}else{
		return('Null');
	}	
}

function ValorMysqlPhp($valor){
	
	$valor = str_replace(".", ",", $valor);
	return $valor;
	
}

function ValorPhpMysql($valor){
	
	$valor = str_replace(".", "", $valor);
	$valor = str_replace(",", ".", $valor);
	return $valor;
	
}

function ValidaData($dat,$campo){
	$data = explode("/","$dat"); // fatia a string $dat em pedados, usando / como refer�ncia
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];
 
	// verifica se a data � v�lida!
	// 1 = true (v�lida)
	// 0 = false (inv�lida)
	$res = checkdate($m,$d,$y);
	if ($res == 1){
	   //echo "data ok!";
	} else {
	   echo "<script language='javascript'>alert('Data ". $campo ." invalida!'); history.back(1);</script>";
	   die;
	}
}
 
function redimensiona($imagem,$nova,$caminho,$altura) {
   
   //imagem original
	$source_image = $caminho . $imagem;
	
   //altura m�xima
    //$thumb_height = 480;
	$thumb_height = $altura;
	
   //qualidade - vai de 0 a 100
    $quality = 100;
	
	$destino = $caminho;
	$caminho .= $nova;
	
   //checa se imagem existe
   if(!file_exists($source_image)) {
      echo "Imagem n�o encontrada";
   } else {
   		
       //tipos suportados (jpg, png, gif, etc...)
        $supported_types = array(1, 2, 3, 7);

        //retorna informa��es da imagem
        list($width_orig, $height_orig, $image_type) = getimagesize($source_image);

        //checa se � um tipo suportado
        if(!in_array($image_type, $supported_types)) {
            echo "Tipo n�o suportado de imagem: " . $image_type;
        }
        else
        {
			
           //nome da imagem
            $path_parts = pathinfo($source_image);
            //$filename = $path_parts["filename"];
			$filename = $nova;
			
           //calcula as propor��es
            $aspect_ratio = (float) $width_orig / $height_orig;

            //calcula a largura da thumb baseada na altura
            $thumb_width = round($thumb_height * $aspect_ratio);
 
            //detecta o tipo de arquivo
            $source = imagecreatefromstring(file_get_contents($source_image));

            //cria canvas
            $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width_orig, $height_orig);
			
           //destr�i, para liberar mem�ria
            imagedestroy($source);
 
            //cria thumb baseada no tipo da imagem
            switch ( $image_type )
            {
                case 1:
                    imagegif($im, $fileName);
					$filename .= ".gif";
                    $thumbnail = $filename;
					$caminho .= ".gif";
                    break;

                case 2:
                    $filename .= ".jpg";
					$thumbnail = $filename;
                    imagejpeg($thumb, $thumbnail, $quality);
					$caminho .= ".jpg";
                    break;

                case 3:
                    imagepng($im, $fileName);
                    $filename .= ".png";
					$thumbnail = $filename;
					$caminho .= ".png";
                    break;

                case 7:
                    imagewbmp($im, $fileName);
                    $filename .= ".bmp";
					$thumbnail = $filename;
					$caminho .= ".bmp";
                    break;
            }
        }
    }
	
  // LOCAL
  //$origem = $_SERVER['DOCUMENT_ROOT'] . '/deltario/sistema/';
  
  //AR
  $origem = $_SERVER['DOCUMENT_ROOT'] . '/sistema/';
  
	// COPIA IMAGEM NOVA E DELETA ANTIGA.
	copy($origem . $filename, $destino . $filename);
	unlink($origem . $filename);
	unlink($destino . $imagem);
}

function TipoExtensao($arquivo) {
	
	$arquivo = $_FILES["$arquivo"]["type"];
	
	if (($arquivo == 'image/pjpeg') || ($arquivo == 'image/jpeg'))  {
		$extensao = "jpg";
	} else if ($arquivo == 'image/x-png') {
		$extensao = "png";
	} else if ($arquivo == 'image/bmp') {
		$extensao = "bmp";
	} else if ($arquivo == 'image/gif') {
		$extensao = "gif";
	} else if ($arquivo == 'application/pdf') {
		$extensao = "pdf";
	}
	
	return $extensao;
}

function somar_data($data, $dias, $meses, $ano){
  $data = explode("/", $data);
  $resData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano));
  
  return $resData;
}

function ExibeNomeUsuario($usuario) {
	
	$sql = "Select * from usuarios where cod_usuario = ". $usuario;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){ 
			echo $rs['nome'];
		}
	}
	
}


function ComboLicenca($cod_licenca) 
{
	
	$sql = "
	select cod_licenca, descricao, valor from licencas order by 1;
	";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_licenca' class='form-control' id='cod_licenca'>";
		echo "<option value=''>Selecione...</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_licenca'] ."'";
			$retVal = ($rs['cod_licenca'] == $cod_licenca) ? " selected " : "" ;
			echo $retVal.">".$rs['descricao']." (".$rs['valor'].")". "</option>";	

		}
		echo "</select>";
	}
	
}

function ComboLicencaRenovacao($cod_licenca_atual) {
	
	$sql = "
		select 	cod_licenca
		,descricao
		,case 
			when cod_licenca = 1 then '29,99' 
			when cod_licenca = 3 then '49,99' 
			when cod_licenca = 4 then '69,99'         
		end as valor        
		from 	licencas 
		order by 1;
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_licenca' class='form-control' id='cod_licenca'>";
		echo "<option value=''>Selecione...</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_licenca'] ."'";
			if ($cod_licenca_atual == $rs['cod_licenca']) { echo " selected ";}
			echo ">".$rs['descricao']." (".$rs['valor'].")". "";
			echo "</option>";	

		}
		echo "</select>";
	}
	
}


function AdmComboTipoConta($cod_empresa, $tipoconta) {
	
	$sql = "
	select		tc.cod_tipo_conta, tc.descricao as tipoconta
	from 		tipo_conta tc
	";
	"
	where 		tc.cod_empresa = ".$cod_empresa."
	order by 	tc.descricao asc;
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='tipo_conta' class='form-control' id='tipo_conta'>";
		echo "<option value=''>Selecione...</option>";
		while ($rs = mysql_fetch_array($query)){ 
			
			echo "<option value='". $rs['cod_tipo_conta'] ."'";
			
			if ($tipoconta == $rs['cod_tipo_conta']) { echo " Selected"; }

			echo ">".$rs['tipoconta'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "N�o tem nenhum Tipo de Conta cadastrado";
	}
	
}


function ComboTipoConta($cod_empresa, $cod_tipo_conta) {
	
	$sql = "
	select		tc.cod_tipo_conta, tc.descricao
	from 		tipo_conta tc
	where 		cod_tipo_conta <> 1
	and 		tc.cod_empresa = ".$cod_empresa."
	order by 	tc.descricao asc;
	;";

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='tipo_conta' class='form-control' id='tipo_conta'>";
		echo "<option value=''>Selecione...</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_tipo_conta'] ."'";
			if ($cod_tipo_conta == $rs['cod_tipo_conta']) { echo " Selected"; }
			echo ">" . $rs['descricao'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "N�o tem nenhum Tipo de Conta cadastrado";
	}
	
}


function ComboGrupo($cod_grupo, $Bloqueio) {
	
	$sql = "
	select		cod_grupo, nome
	from		grupos
	where		`status` = 'A'
	order by	nome asc
	";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_grupo' class='form-control' id='cod_grupo' ".$Bloqueio.">";
		echo "<option value=''>Selecione o grupo</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_grupo'] ."'";
			if ($cod_grupo == $rs['cod_grupo']) { echo " Selected"; }
			echo ">" . $rs['nome'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "N�o tem nenhum Tipo de Conta cadastrado";
	}
	
}

function ComboGrupo_CarregaEmpresa_Ajax($Grupo, $IdDiv, $pagina) {
	
	$sql = "
	select		cod_grupo, nome
	from		grupos
	where		`status` = 'A'
	order by	nome asc
	";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='Grupo' class='form-control' id='Grupo' onChange='CarregaEmpresa();'>";
		echo "<option value=''>Selecione o grupo</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_grupo'] ."'";
			if ($Grupo == $rs['cod_grupo']) { echo " Selected"; }
			echo ">" . $rs['nome'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "N�o tem nenhum Tipo de Conta cadastrado";
	}
	
}

function ExibeTipoConta($tipo) {
	
	$resp = '';
	
	$sql = "Select * from tipo_conta where cod_tipo_conta = ". $tipo;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){ 
			$resp = $rs['descricao'];
		}
	} 
	
	return $resp;
	
}

function ExibeLicenca($licenca) {
	
	$resp = '';
	
	$sql = "Select * from licencas where cod_licenca = ". $licenca;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){ 
			$resp = $rs['descricao'];
		}
	} 
	
	return $resp;
	
}

function ExibeNomeTipoConta($tipo) {
	
	$sql = "Select * from tipo_conta where cod_tipo_conta = ". $tipo;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){ 
			echo $rs['descricao'];
		}
	}
	
}

function ExibeEstado($cod_estado) {
	
	$resp = '';
	
	if ($cod_estado == '') { $cod_estado = 0; }
	
	$sql_estado = "Select * from estados where cod_estado = ". $cod_estado ." order by uf asc";
	$query_estado = mysql_query($sql_estado);
	$registros_estado = mysql_num_rows($query_estado);
	if ($registros_estado > 0) {
		if ($rs_estado = mysql_fetch_array($query_estado)){ 
			$resp = $rs_estado['uf'];
		}
	}
	
	return $resp;
}

function ExibeCidade($cod_cidade) {
	
	$resp = '';
	
	if ($cod_cidade == '') { $cod_cidade = 0; }
	
	$sql_cidade = "Select * from cidades where cod_cidade = ". $cod_cidade ." order by nome asc";
	$query_cidade = mysql_query($sql_cidade);
	$registros_cidade = mysql_num_rows($query_cidade);
	if ($registros_cidade > 0) {
		if ($rs_cidade = mysql_fetch_array($query_cidade)){ 
			$resp = mb_convert_encoding($rs_cidade['nome'], "ISO-8859-1", "UTF-8");
		}
	}
	
	return $resp;
}

function ComboFinanceiro($financeiro) {
	
	$resp = '';
	
	$sql = "Select * from financeiro order by descricao asc";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_financeiro' class='form-control'>";
		echo "<option value=''></option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_financeiro'] ."'";
			if ($financeiro == $rs['cod_financeiro']) { echo " Selected"; }
			echo ">". $rs['descricao'] ."</option>";
		}
		echo "</select>";
	}
	
	return $resp;
	
}

function ComboAdmEmpresa($cod_empresa) {
	
	$sql = "
	Select 		cod_empresa, empresa 
	from 		empresas 
	order by 	empresa asc";

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		?>

		<select name='cod_empresa' id='cod_empresa' class='form-control' onChange="EmpresaCarregaTipoConta(this.value, '');">;
		
		<?php
		echo "<option value=''>Selecione...</option>";

		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_empresa'] ."'";
			if ($cod_empresa == $rs['cod_empresa']) { echo " Selected"; }
			echo ">".$rs['empresa'];
			echo "</option>";
		}
		echo "</select>";
	} 
	
	return $resp;
	
}

function ComboCliente($cliente, $cod_empresa) {
	
	$resp = '';
	
	$sql = "
	Select 		cod_cliente, nome 
	from 		clientes 
	where 		cod_empresa = ".$cod_empresa."	
	order by 	nome asc";

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_cliente' id='cod_cliente' class='form-control'>";
		echo "<option value=''>Selecione...</option>";

		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_cliente'] ."'";
			if ($cliente == $rs['cod_cliente']) { echo " Selected"; }
			echo ">".$rs['nome'];
			echo "</option>";
		}
		echo "</select>";
	} 
	
	return $resp;
	
}

function ComboBuscaCliente($cod_empresa) {
	
	$resp = '';
	
	$sql = "
	Select 		cod_cliente, nome 
	from 		clientes 
	where 		cod_empresa = ".$cod_empresa."	
	order by 	nome asc";

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_cliente' id='cod_cliente' class='form-control'>";
		echo "<option value='0'>Todos</option>";

		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_cliente'] ."'";
			echo ">".$rs['nome'];
			echo "</option>";
		}
		echo "</select>";
	} 
	
	return $resp;
	
}

function ComboMeses($mes) {
	

	echo "<select name='mes' class='form-control'>";

	$i=1;
	echo "<option value=''>Selecione</option>";
	while($i<=12){
		echo "<option value='".$i."'";
		if ($mes == $i) { echo " Selected"; }
		echo ">".RetornaMes($i); 
		echo "</option>";
	$i++;
	}
	echo "</select>";
	
}


function ExibeCliente($cliente) {
	
	$sql_cliente = "Select * from clientes where cod_cliente = ". $cliente;
	$query_cliente = mysql_query($sql_cliente);
	$registros_cliente = mysql_num_rows($query_cliente);
	if ($registros_cliente > 0) {
		if ($rs_cliente = mysql_fetch_array($query_cliente)){ 
			if ($rs_cliente['tipo_pessoa'] == 'PF') {
				echo $rs_cliente['nome'];
			} else if ($rs['tipo_pessoa'] == 'PJ') {
				echo $rs_cliente['empresa'];
			}
		}
	} 
	
}


function ExibeFinanceiro($financeiro) {
	
	$sql_financeiro = "Select * from financeiro where cod_financeiro = ". $financeiro;
	$query_financeiro = mysql_query($sql_financeiro);
	$registros_financeiro = mysql_num_rows($query_financeiro);
	if ($registros_financeiro > 0) {
		if ($rs_financeiro = mysql_fetch_array($query_financeiro)){ 
			echo $rs_financeiro['descricao'];
		}
	} 
	
}

function PegaFinanceiro($financeiro) {
	
	$resp = '';
	
	$sql_financeiro = "Select * from financeiro where cod_financeiro = ". $financeiro;
	$query_financeiro = mysql_query($sql_financeiro);
	$registros_financeiro = mysql_num_rows($query_financeiro);
	if ($registros_financeiro > 0) {
		if ($rs_financeiro = mysql_fetch_array($query_financeiro)){ 
			$resp = $rs_financeiro['descricao'];
		}
	} 
	
	return $resp;
	
}

function RetornaNumeroDocumentoBoleto($cod_fluxo) {
	
	$resp = '';
	
	$sql_boleto = "Select * from boletos where cod_fluxo = ". $cod_fluxo;
	$query_boleto = mysql_query($sql_boleto);
	$registros_boleto = mysql_num_rows($query_boleto);
	if ($registros_boleto > 0) {
		if ($rs_boleto = mysql_fetch_array($query_boleto)){ 
			$resp = $rs_boleto['numero_documento'];
		}
	}
	
	return $resp;	
	
}


function ComboFornecedor($fornecedor, $cod_empresa) {
	
	$sql = "
	Select 		f.cod_fornecedor, f.nome_fantasia
	from 		fornecedores f
	where 		f.cod_empresa = ".$cod_empresa."
	order by 	f.nome_fantasia asc ";
	
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_fornecedor' class='form-control' id='cod_fornecedor'>";
		echo "<option value=''>Selecione</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_fornecedor'] ."'";
			if ($fornecedor == $rs['cod_fornecedor']) { echo " Selected"; }
			echo ">" . $rs['nome_fantasia'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "Nenhum fornecedor encontrado";
	}
	
}

function ComboGrupoProduto($grupo, $cod_grupo) {
	
	$sql = "
	Select 		g.cod_grupo_produto, g.descricao
	from 		grupo_produtos g
	where 		g.cod_empresa = ".$cod_grupo."
	order by 	g.descricao asc;";

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_grupo_produto' class='form-control' id='cod_grupo_produto'>";
		echo "<option value=''>Selecione</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_grupo_produto'] ."'";
			if ($grupo == $rs['cod_grupo_produto']) { echo " Selected"; }
			echo ">" . $rs['descricao'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "Nenhum grupo de produto encontrado";
	}
	
}

function DiaDaSemana($diasemana)
{

	switch($diasemana)
	{
		case"0": $diasemana = "Domingo"; break;

		case"1": $diasemana = "Segunda-Feira"; break;

		case"2": $diasemana = "Terça-Feira"; break;

		case"3": $diasemana = "Quarta-Feira"; break;

		case"4": $diasemana = "Quinta-Feira"; break;

		case"5": $diasemana = "Sexta-Feira"; break;

		case"6": $diasemana = "Sábado"; break;

		default: $diasemana = "Domingo"; break;

	}

	return $diasemana;

}

function RetornaMes($mes){

	switch ($mes) 
	{
        case "1":    $mes = "Janeiro";     break;
        case "2":    $mes = "Fevereiro";   break;
        case "3":    $mes = "Março";       break;
        case "4":    $mes = "Abril";       break;
        case "5":    $mes = "Maio";        break;
        case "6":    $mes = "Junho";       break;
        case "7":    $mes = "Julho";       break;
        case "8":    $mes = "Agosto";      break;
        case "9":    $mes = "Setembro";    break;
        case "10":    $mes = "Outubro";     break;
        case "11":    $mes = "Novembro";    break;
        case "12":    $mes = "Dezembro";    break; 
	}
	 
	return $mes;

}

/*SERVICO*/

function ComboCategoriaServico($cod_empresa, $cod_categoria) {
	
	$sql = "
	select		cod_categoria, nome
	from		categoria
	order by	nome asc
	";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_categoria' class='form-control' id='cod_categoria'>";
		echo "<option value=''>Selecione a categoria</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_categoria'] ."'";
			if ($cod_categoria == $rs['cod_categoria']) { echo " Selected"; }
			echo ">" .$rs['nome'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "N�o tem nenhuma categoria cadastrado";
	}
	
}

function ComboTipoDeServico($cod_empresa, $cod_tipo_servico) {
	
	$sql = "
	select		cod_tipo_servico, descricao
	from		tipo_servico
	where 		cod_empresa = ".$cod_empresa."
	order by	descricao asc
	";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_tipo_servico' class='form-control' id='cod_tipo_servico'>";
		echo "<option value=''>Selecione o Tipo de Serviço</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_tipo_servico'] ."'";
			if ($cod_tipo_servico == $rs['cod_tipo_servico']) { echo " Selected"; }
			echo ">" .$rs['descricao'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "Nenhum tipo de serviço cadastrado";
	}

}

function ComboTipoComissao($cod_tipo_comissao) {
	
	$sql = "
	select		cod_tipo_comissao, nome
	from		tipo_comissao
	order by	nome asc
	";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_tipo_comissao' class='form-control' id='cod_tipo_comissao'>";
		echo "<option value='0'>Selecione o Tipo da Comissão</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_tipo_comissao'] ."'";
			if ($cod_tipo_comissao == $rs['cod_tipo_comissao']) { echo " Selected"; }
			echo ">" .$rs['nome'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "N�o tem nenhum nenhum tipo de comissao";
	}

}

function ComboDescontoCustoProduto($descontar_custo_produtos) {

	echo "<select name='descontar_custo_produtos' class='form-control' id='descontar_custo_produtos'>";
	
	echo "<option value='1'";
		if (descontar_custo_produtos == 1) { echo " Selected "; }
	echo ">Sim</option>";

	echo "<option value='2'";
		if (descontar_custo_produtos == 2) { echo " Selected "; }
	echo ">Não</option>";

	echo "</select>";

}


/*CARTAO*/

function ComboTiposOperacao($cod_tipo_operacao) {
	
	$sql = "
	select		cod_tipo_operacao, descricao
	from		tipo_operacao
	order by	descricao asc
	";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_tipo_operacao' class='form-control' id='cod_tipo_operacao' onChange='javascript:SelecioneTipoOperacao(this.value);' >";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_tipo_operacao'] ."'";
			if ($cod_tipo_operacao == $rs['cod_tipo_operacao']) { echo " Selected"; }
			echo ">".$rs['descricao'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "N�o tem nenhum nenhum tipo de comissao";
	}

}


function ComboNumeroMaximoParcelasCartaoCredito($numero_maximo_parcelas) {
	
	echo "<select name='numero_maximo_parcelas' class='form-control' id='numero_maximo_parcelas'>";

	$i=1;
	while ($i<=96){
		
		echo "<option value='".$i."'";
			if ($i == $numero_maximo_parcelas) { echo " Selected"; }
				echo ">" .$i. "</option>";
		
	$i++;
	}

	echo "</select>";

}


function ComboTipoRepasseCartaoCredito($cod_tipo_prazo){

	$sql = "
	select		cod_tipo_prazo, descricao
	from		tipo_prazo_cartao
	order by	descricao asc
	";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_tipo_prazo' class='form-control' id='cod_tipo_prazo'>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_tipo_prazo'] ."'";
			if ($cod_tipo_prazo == $rs['cod_tipo_prazo']) { echo " Selected"; }
			echo ">" .$rs['descricao'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "N�o tem nenhum nenhum tipo de prazo";
	}

}

/* CONTA */

function ComboContaPaga($parcela, $paga) 
{
?>
	<select name="flg_paga_<?php echo $parcela; ?>" id="flg_paga_<?php echo $parcela; ?>" class="form-control" onChange="javascript:ContaPaga('<?php echo $parcela;?>', this.value);">
	
		<option value='N' <?php if ($paga == 'N') { echo " Selected "; } ?> > Não </option>

		<option value='S' <?php if ($paga == 'S') { echo " Selected "; } ?> > Sim </option>

	</select>

<?php
}

function ComboQuitarAutomaticamente($parcela, $flg_quitar_automatico) {

	echo "<select name='flg_quitar_automatico_".$parcela."' id='flg_quitar_automatico_".$parcela."' class='form-control'>";
	
	echo "<option value='S' ";
		if ($flg_quitar_automatico == 'S') { echo " Selected "; }
	echo ">Sim</option>";

	echo "<option value='N' ";
		if ($flg_quitar_automatico == 'N') { echo " Selected "; }
	echo ">Não</option>";

	echo "</select>";

}


function ComboUsouDaGaveta($div, $parcela, $UsouDaGaveta, $cod_empresa) {
?>

	<select name="flg_usoudagaveta_<?php echo $parcela; ?>" id="flg_usoudagaveta_<?php echo $parcela; ?>" class="form-control" onChange="CarregaDataCaixa('<?php echo $div; ?>', '<?php echo $parcela; ?>', '<?php echo $cod_empresa; ?>', this.value);">
	
		<option value='N' <?php if ($UsouDaGaveta == 'N') { echo " Selected "; } ?> > Não </option>

		<option value='S' <?php if ($UsouDaGaveta == 'S') { echo " Selected "; } ?> > Sim </option>

	</select>

<?php
}


/******************************************************
					COMANDA 
******************************************************/

//CÁLCULOS

function TotalComanda($cod_empresa, $cod_cliente, $cod_comanda){

	$sql = "
	select 		format(ifnull(
					((i.valor * i.quantidade))
					, '0.00'), 2) as total_comanda
	from 		comanda_item i 
	inner join 	comanda c on c.cod_comanda = i.cod_comanda
	where 		i.cod_comanda = ".$cod_comanda."
	and 		i.cod_cliente = ".$cod_cliente."
	and 		i.cod_empresa = ".$cod_empresa."
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

	return $rs['total_comanda'];

}

function TotalPago($cod_empresa, $cod_cliente, $cod_comanda){

	$sql = "
	select 		ifnull(sum(valor), 0.00) as valor_pago
	from 		comanda_pagamento
	where 		cod_empresa  = ".$cod_empresa." 
	and 		cod_cliente = ".$cod_cliente." 
	and 		cod_comanda = ".$cod_comanda."
	and 		cod_forma_pagamento in (1,2,3,4,5,6)
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
	return $rs['valor_pago'];

}

function TotalFiado($cod_empresa, $cod_cliente, $cod_comanda){

	$sql = "
	select 		ifnull(sum(valor*(ifnull(num_parcelas, 1))), 0.00) as fiado
	from 		comanda_pagamento
	where 		cod_empresa  = ".$cod_empresa." 
	and 		cod_cliente = ".$cod_cliente." 
	and 		cod_comanda in (".$cod_comanda.")
	and 		cod_forma_pagamento = 6;
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
	return number_format($rs['fiado'], 2, ',', '.');

}

function Comanda_Desconto($cod_empresa, $cod_cliente, $cod_comanda){

	$sql = "
	select 		format(ifnull(valor_desconto, 0.0), 2) as desconto
	from 		comanda
	where 		cod_comanda = ".$cod_comanda." 
	and 		cod_cliente = ".$cod_cliente." 
	and 		cod_empresa = ".$cod_empresa."
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
	return $rs['desconto'];

}

function Comanda_Creditos($cod_empresa, $cod_cliente, $cod_comanda){

	$sql = "
	select 		format(ifnull(i.valor, 0.0), 2) as credito
	from 		comanda_pagamento i
	where 		i.cod_comanda = ".$cod_comanda."
	and 		i.cod_cliente = ".$cod_cliente."
	and 		i.cod_empresa = ".$cod_empresa."
	and 		i.cod_forma_pagamento = 8;
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

	return $rs['credito'];

}


function Comanda_AtualizaSituacao($cod_empresa, $cod_cliente, $cod_comanda, $cod_forma_pagamento){

	$total_comanda	= TotalComanda($cod_empresa, $cod_cliente, $cod_comanda);
	$total_pago		= TotalPago($cod_empresa, $cod_cliente, $cod_comanda);

	if($cod_forma_pagamento == "1" || $cod_forma_pagamento == "2" || $cod_forma_pagamento == "3" || $cod_forma_pagamento == "4" || $cod_forma_pagamento == "5"){
		
		if($total_pago >= $total_comanda){

			$sql = "
			update 		comanda 
			set 		situacao = 2
			where 		cod_comanda = ".$cod_comanda." 
			and 		cod_cliente = ".$cod_cliente." 
			and 		cod_empresa = ".$cod_empresa." ";
	
			//echo $sql; die;
			mysql_query($sql);		

		}elseif($total_pago < $total_comanda){

			$sql = "
			update 		comanda 
			set 		situacao = 1
			where 		cod_comanda = ".$cod_comanda." 
			and 		cod_cliente = ".$cod_cliente." 
			and 		cod_empresa = ".$cod_empresa." ";
	
			//echo $sql; die;
			mysql_query($sql);	

		}

	}

}

function Comanda_AdicionaTransacaoAoCaixa($cod_empresa, $cod_caixa, $cod_comanda, $tipo_transacao, $descricao, $valor, $cod_usuario){

	if($cod_comanda == ""){

			$sql = "
			INSERT INTO `caixa_gaveta`
			(`cod_empresa`,
			`cod_caixa`,
			`cod_comanda`,
			`tipo_transacao`,
			`descricao`,
			`valor`,
			`cod_usuario`,
			`dt_transacao`
			)
			VALUES
			(".$cod_empresa.",
			".$cod_caixa.",
			NULL,
			'".$tipo_transacao."',
			'".$descricao."',
			".$valor.",
			".$cod_usuario.",
			now()
			);
			";

			//echo $sql."<br>"; die;

			mysql_query($sql);

	}else{
		
		$comandas = explode(",", $cod_comanda);

		$i=0;
		while ($i < count($comandas)) {


			$sql = "
			INSERT INTO `caixa_gaveta`
			(`cod_empresa`,
			`cod_caixa`,
			`cod_comanda`,
			`tipo_transacao`,
			`descricao`,
			`valor`,
			`cod_usuario`,
			`dt_transacao`
			)
			VALUES
			(".$cod_empresa.",
			".$cod_caixa.",
			".$comandas[$i].",
			'".$tipo_transacao."',
			'".$descricao."',
			".$valor.",
			".$cod_usuario.",
			now()
			);
			";

			//echo "Entrei 2 - ".$sql."<br>";

			mysql_query($sql);

		$i++;

		}

	}

}



//CAMPOS

function ComboProfissional($cod_empresa, $cod_profissional) {
	
	$sql = "
	Select 		f.cod_profissional, f.nome
	from 		profissional f
	where 		f.cod_empresa = ".$cod_empresa."
	order by 	f.nome asc ";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_profissional' class='form-control' id='cod_profissional'>";
		//echo "<option value=''>Todos</option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_profissional'] ."'";
			if ($cod_profissional == $rs['cod_profissional']) { echo " Selected"; }
			echo ">" . $rs['nome'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "Nenhum fornecedor encontrado";
	}
	
}

function ComandaComboProfissional($cod_empresa, $cod_profissional) {
	
	$sql = "
	Select 		f.cod_profissional, f.nome
	from 		profissional f
	where 		f.cod_empresa = ".$cod_empresa."
	order by 	f.nome asc ";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_profissional' class='form-control' id='cod_profissional'>";
		echo "<option value='0'> Escolha um Profissional </option>";
		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_profissional'] ."'";
			if ($cod_profissional == $rs['cod_profissional']) { echo " Selected"; }
			echo ">" . $rs['nome'] . "</option>";
		}
		echo "</select>";
	} else {
		echo "Nenhum fornecedor encontrado";
	}
	
}


function ComboServico($cod_empresa, $cod_servico) {


	$sql = "
	select		cod_servico, nome
	from		servico
	where 		cod_empresa = ".$cod_empresa."
	order by	nome asc
	";

	$query = mysql_query($sql);

	?>

	<select name="cod_servico" id="cod_servico" class="form-control" onChange="CarregarValorServico('<?php echo $cod_empresa; ?>', this.value);">

		<option value="" selected> Selecione </option>
	
		<?php 

		while ($rs = mysql_fetch_array($query)){ 

		?>

		<option value="<?php echo $rs['cod_servico']; ?>" <?php if ($cod_servico == $rs['cod_servico']) { echo " Selected"; } ?>> <?php echo $rs['nome']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php
}

function ComandaComboServico($cod_empresa, $cod_servico) 
{


	$sql = "
	select		cod_servico, nome
	from		servico
	where 		cod_empresa = ".$cod_empresa."
	order by	nome asc
	";

	$query = mysql_query($sql);

	?>

	<select name="cod_servico" id="cod_servico" class="form-control" onChange="CarrregarValorServico('<?php echo $cod_empresa; ?>', this.value);">

		<option value="0" selected> Escolha um Serviço </option>
	
		<?php 

		while ($rs = mysql_fetch_array($query)){ 

		?>

		<option value="<?php echo $rs['cod_servico']; ?>" <?php if ($cod_servico == $rs['cod_servico']) { echo " Selected"; } ?>> <?php echo $rs['nome']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php
}

function ComboProduto($cod_empresa, $cod_produto) {


	$sql = "
	select 		p.cod_produto, p.descricao
	from 		grupo_produtos gp
	inner join 	produtos p on p.cod_grupo_produto = gp.cod_grupo_produto
	where 		gp.cod_empresa = ".$cod_empresa."
	order by 	p.descricao asc;
	";

	$query = mysql_query($sql);

	?>

	<select name="cod_produto" id="cod_produto" class="form-control" onChange="CarrregarValorProduto('<?php echo $cod_empresa; ?>', this.value);">

		<option value="" selected> Selecione </option>
	
		<?php 

		while ($rs = mysql_fetch_array($query)){ 

		?>

		<option value="<?php echo $rs['cod_produto']; ?>" <?php if ($cod_produto == $rs['cod_produto']) { echo " Selected"; } ?>> <?php echo $rs['descricao']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php
}

function ComandaComboProduto($cod_empresa, $cod_produto) {


	$sql = "

	select 		p.cod_produto, p.descricao
	from 		produtos p 
	where 		p.cod_empresa = ".$cod_empresa."
	order by 	p.descricao asc;

	";

	$query = mysql_query($sql);

	?>

	<select name="cod_produto" id="cod_produto" class="form-control" onChange="CarrregarValorProduto('<?php echo $cod_empresa; ?>', this.value);">

		<option value="0" selected> Escolha um Produto </option>

		<?php 

		while ($rs = mysql_fetch_array($query)){ 

		?>

		<option value="<?php echo $rs['cod_produto']; ?>" <?php if ($cod_produto == $rs['cod_produto']) { echo " Selected"; } ?>> <?php echo $rs['descricao']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php
}


function comboBandeiras_Cartao($cod_empresa) 
{
	$sql = "
	select 		cod_cartao, bandeira
	from 		cartao
	where 		cod_empresa = ".$cod_empresa."
	order by 	bandeira;
	";

	//echo $sql;

	$query = mysql_query($sql);

	?>

	<select name="cod_cartao_credito" id="cod_cartao_credito" class="form-control">

		<option value="0" selected> Todos </option>
	
		<?php 

		while ($rs = mysql_fetch_array($query)){ 

		?>

		<option value="<?php echo $rs['cod_cartao']; ?>"> <?php echo $rs['bandeira']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php
}



function comboCartaoDebito($cod_empresa, $i, $cod_cartao) {


	$sql = "
	select 		cod_cartao, bandeira
	from 		cartao
	where 		cod_empresa = ".$cod_empresa."
	and 		cod_tipo_operacao in (1,3)
	order by 	bandeira;
	";

	//echo $sql;

	$query = mysql_query($sql);

	?>

	<select name="cod_cartao_debito_<?php echo $i; ?>" id="cod_cartao_debito_<?php echo $i; ?>" class="form-control">

		<option value="0" selected> Nenhum </option>
	
		<?php 

		while ($rs = mysql_fetch_array($query)){ 

		?>

		<option value="<?php echo $rs['cod_cartao']; ?>" <?php if ($cod_cartao == $rs['cod_cartao']) { echo " Selected"; } ?>> <?php echo $rs['bandeira']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php 

}

function comboCartaoCredito($cod_empresa, $i, $cod_cartao) 
{
	$sql = "
	select 		cod_cartao, bandeira
	from 		cartao
	where 		cod_empresa = ".$cod_empresa."
	and 		cod_tipo_operacao in (1, 2)
	order by 	bandeira;
	";

	//echo $sql;

	$query = mysql_query($sql);

	?>

	<select name="cod_cartao_credito_<?php echo $i; ?>" id="cod_cartao_credito_<?php echo $i; ?>" class="form-control">

		<option value="0" selected> Selecione </option>
	
		<?php 

		while ($rs = mysql_fetch_array($query)){ 

		?>

		<option value="<?php echo $rs['cod_cartao']; ?>" <?php if ($cod_cartao == $rs['cod_cartao']) { echo " Selected"; } ?>> <?php echo $rs['bandeira']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php
}

function ComboFormaPagamento() 
{
	$sql = "
	select		cod_forma_pagamento, descricao
	from 		formas_pagamento
	order by 	cod_forma_pagamento asc;
	";

	//echo $sql;

	$query = mysql_query($sql);

	?>

	<select name="cod_forma_pagamento" id="cod_forma_pagamento" class="form-control">

		<option value="0" selected> Selecione </option>
	
		<?php 

		while ($rs = mysql_fetch_array($query))
		{ 

		?>

			<option value="<?php echo $rs['cod_forma_pagamento']; ?>"> <?php echo $rs['descricao']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php

}


function ComboBanco($cod_empresa, $i, $cod_banco) 
{
	$sql = "
	select		cod_banco, descricao
	from 		banco
	order by 	cod_banco asc;
	";

	//echo $sql;

	$query = mysql_query($sql);

	?>

	<select name="cod_banco_<?php echo $i; ?>" id="cod_banco_<?php echo $i; ?>" class="form-control">

		<option value="0" selected> Selecione </option>
	
		<?php 

		while ($rs = mysql_fetch_array($query))
		{ 

		?>

			<option value="<?php echo $rs['cod_banco']; ?>"> <?php echo $rs['descricao']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php

}

/******************************************************
			CAIXA 
******************************************************/

function comboGavetaCaixaAberto(){
?>
	
		<select name="caixa_aberto" id="caixa_aberto" class="form-control">

			<option value=''>  </option>
		
			<option value='1'> Sangria </option>
	
			<option value='2'> Refor�o </option>

			<option value='3'> Emitir Vale </option>			

			<option value='4'> Receber D�vida </option>			

			<option value='5'> Negociar Cheques </option>			

			<option value='6'> Repassar Gorjetas </option>			

			<option value='7'> Informa��es do Caixa </option>			

			<option value='8'> Fechar Caixa </option>			
	
		</select>
	
<?php
}

function comboGavetaCaixaFechado() {
?>
	
		<select name="caixa_fechado" id="caixa_fechado" class="form-control">
		
			<option value='1'> Abrir Novo Caixa </option>
	
			<option value='2'> Reabrir �ltimo Caixa </option>

			<option value='3'> Reabrir Caixa Antigo </option>			

			<option value='4'> Cadastrar Caixa Antigo </option>			

			<option value='5'> Visualizar Caixas Fechados </option>			
	
		</select>
	
<?php
}

function ComboReabrirCaixaAntigo($cod_empresa, $cod_caixa) 
{
	$sql = "
	select		cod_caixa, DATE_FORMAT(dt_abertura, '%d/%m/%Y %H:%i:%s') as data_abertura
	from 		caixa
	where 		cod_empresa = ".$cod_empresa."
	order by 	dt_abertura desc;
	";

	//echo $sql;

	$query = mysql_query($sql);

	?>

	<select name="cod_caixa_antigo" id="cod_caixa_antigo" class="form-control">

		<?php 

		while ($rs = mysql_fetch_array($query))
		{ 

		?>

			<option value="<?php echo $rs['cod_caixa']; ?>" 
				<?php if ($rs['cod_caixa'] == $cod_caixa) { echo " selected "; } ?>
				> <?php echo $rs['data_abertura']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php

}

function ExisteDataNoCaixa($cod_empresa, $data){

	$sql = "
	select		case when count(*) > 0 then 'sim' else 'nao' end ExisteData
	from		caixa
	where 		convert(dt_abertura, date) = '".$data." 00:00:00'
	and 		cod_empresa = ".$cod_empresa.";
	";

	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

	return $rs['ExisteData'];

}


function SaldoCaixa($cod_empresa, $cod_caixa){

	$sql = "
	select 		format(ifnull(i.valor, '0.00'), 2) as SaldoCaixa
	from 		caixa i 
	where		i.cod_empresa = ".$cod_empresa."
	and 		i.cod_caixa = ".$cod_caixa."
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

	return $rs['SaldoCaixa'];

}

function CaixaDiaAnteriorAberto($cod_empresa, $dataAtual){

	$sql = "
	select		max(cod_caixa) as cod_caixa
	from 		caixa
	where 		situacao = 1
	and 		dt_abertura < '".$dataAtual."'
	and			cod_empresa = ".$cod_empresa."
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

	return $rs['cod_caixa'];

}

function TemClientesDivida($cod_empresa) {
	
	$resp = '';
	
	$sql = "
	Select 		count(*)
	from 		clientes cli
	inner join	comanda c on c.cod_cliente = cli.cod_cliente
	inner join 	comanda_pagamento cp on cp.cod_comanda = c.cod_comanda
	where 		cp.cod_empresa = ".$cod_empresa."
	and 		cp.cod_forma_pagamento = 6
	and 		c.cod_comanda not in (
					select		cod_comanda 
	                from 		comanda_pagamento cp2 
	                where 		cp2.cod_empresa=".$cod_empresa."
					and 		cp2.cod_comanda=cp.cod_comanda
	                and 		cp2.cod_forma_pagamento <> 6
				)
	group by 	cli.cod_cliente, cli.nome
	order by 	cli.nome asc;

	";

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	
	return $registros;
	
}

function ComboClienteDividas($cliente, $cod_empresa) {
	
	$resp = '';
	
	$sql = "
	Select 		cli.cod_cliente, cli.nome
	from 		clientes cli
	inner join	comanda c on c.cod_cliente = cli.cod_cliente
	inner join 	comanda_pagamento cp on cp.cod_comanda = c.cod_comanda
	where 		cp.cod_empresa = ".$cod_empresa."
	and 		cp.cod_forma_pagamento = 6
	and 		c.cod_comanda not in (
					select		cod_comanda 
	                from 		comanda_pagamento cp2 
	                where 		cp2.cod_empresa=".$cod_empresa."
					and 		cp2.cod_comanda=cp.cod_comanda
	                and 		cp2.cod_forma_pagamento <> 6
				)
	group by 	cli.cod_cliente, cli.nome
	order by 	cli.nome asc;

	";

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		echo "<select name='cod_cliente' id='cod_cliente' class='form-control'>";
		echo "<option value=''></option>";

		while ($rs = mysql_fetch_array($query)){ 
			echo "<option value='". $rs['cod_cliente'] ."'";
			if ($cliente == $rs['cod_cliente']) { echo " Selected"; }
			echo ">"; 
			
			echo $rs['nome'];
					
			echo "</option>";
		}
		echo "</select>";
	} 
	
	//return $resp;
	
}

/******************************************************
					COMISSAO 
******************************************************/

//C�LCULOS

function BuscaComissaoProfissional($cod_empresa, $cod_profissional, $cod_servico, $cod_produto)
{

	$sql = "

	select 	case cod_tipo_comissao
			when 1 then comissao_percentual
			when 2 then comissao_fixa
			end as comissao
	from 	profissional_comissao 
	where 	cod_empresa = ".$cod_empresa." 
	and 	cod_profissional = ".$cod_profissional."
	";

	if($cod_servico != "")
	{
		$sql = $sql . " and cod_servico = ".$cod_servico."";

	}elseif($cod_produto != "")
	{
		$sql = $sql . " and cod_produto = ".$cod_produto."";
	}

	//echo $sql."<br>";

	$query = mysql_query($sql);
	$total = mysql_num_rows($query);
	$rs    = mysql_fetch_array($query);

	if ($total > 0){

		echo "style = 'font-weight:bold;'";

	}

}


function BuscaComissao($cod_empresa, $cod_profissional, $cod_servico, $cod_produto)
{

	$sql = "

	select 	cod_tipo_comissao
			,case cod_tipo_comissao
				when 1 then comissao_percentual
				when 2 then comissao_fixa
			end as comissao
	from 	profissional_comissao 
	where 	cod_empresa = ".$cod_empresa." 
	and 	cod_profissional = ".$cod_profissional."
	";

	if($cod_servico != "")
	{
		$sql = $sql . " and cod_servico = ".$cod_servico."";

	}elseif($cod_produto != "")
	{
		$sql = $sql . " and cod_produto = ".$cod_produto."";
	}

	//echo $sql."<br>";

	$query = mysql_query($sql);
	$total = mysql_num_rows($query);
	$rs    = mysql_fetch_array($query);

	if ($total > 0){

		if($rs["cod_tipo_comissao"] == 1)
		{
			$comissao = $rs['comissao']." %";
		}
		else
		{
			$comissao = "R$ ".$rs['comissao'];
		}

		return $comissao;

	}
	else
	{

		$sql = "
		select 	cod_tipo_comissao
				,case cod_tipo_comissao
					when 1 then comissao_percentual
					when 2 then comissao_fixa
				end as comissao
 		from 	servico 
		where 	cod_empresa = ".$cod_empresa." 
		and 	cod_servico = ".$cod_servico.";
		";

		$query = mysql_query($sql);
		$total = mysql_num_rows($query);
		$rs    = mysql_fetch_array($query);

		if($rs["cod_tipo_comissao"] == 1)
		{
			return $rs['comissao']."%";
		}
		else
		{
			return "R$ ".$rs['comissao'];
		}

	}

}


function ComboComissaoUsoDeGavetaParaPagamento($div, $parcela, $cod_empresa) {
	?>
	
		<select name="flg_usoudagaveta" id="flg_usoudagaveta" class="form-control" onChange="CarregaDataCaixaPagamentoComissao('<?php echo $div; ?>', '<?php echo $parcela; ?>', '<?php echo $cod_empresa; ?>', this.value);">
		
			<option value='N' selected> Não </option>
	
			<option value='S' > Sim </option>
	
		</select>
	
	<?php
	}


/************************************************

				AGENDA

************************************************/
function ComboFuncionario($cod_empresa, $cod_profissional) {


	$sql = "
	select		cod_profissional, nome
	from		profissional
	where 		cod_empresa = ".$cod_empresa."
	order by	nome asc
	";

	$query = mysql_query($sql);

	?>

	<select name="cod_profissional" id="cod_profissional" class="form-control">

		<option value="" selected> Selecione </option>
	
		<?php 

		while ($rs = mysql_fetch_array($query)){ 

		?>

		<option value="<?php echo $rs['cod_profissional']; ?>" <?php if ($cod_profissional == $rs['cod_profissional']) { echo " Selected"; } ?>> <?php echo $rs['nome']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php
}

function ComboRepetir() {
?>

	<select name="repetir" id="repetir" class="form-control">

		<option value="0" selected> Nunca </option>
		<option value="1" > Semanalmente </option>
		<option value="2" > Quinzenalmente </option>

		<?php 
		$cont = 3;
		while ($cont <= 12){ 

		?>

		<option value="<?php echo $cont; ?>"> A cada  <?php echo $cont; ?> semanas </option>

		<?php 

		$cont++;
		}

		?>

	</select>

<?php
}


/***************************************************
					ESTOQUE
***************************************************/

function ComboTipoMovimentacao ($cod_empresa, $cod_tipo_movimentacao) 
{
	$sql = "
	select 		cod_tipo_movimentacao, descricao
	from 		tipo_movimentacao
	order by 	cod_tipo_movimentacao asc;
	";
	
	$query = mysql_query($sql);

	?>

	<select name="cod_tipo_movimentacao" id="cod_tipo_movimentacao" class="form-control" onChange="javascript:SelecionarTipoMovimentacao(this.value);">
	
		<?php 

		while ($rs = mysql_fetch_array($query)){ 

		?>

		<option value="<?php echo $rs['cod_tipo_movimentacao']; ?>" <?php if ($cod_tipo_movimentacao == $rs['cod_tipo_movimentacao']) { echo " Selected"; } ?>> 
			<?php echo $rs['descricao']; ?> 
		</option>

		<?php 

		}

		?>

	</select>

<?php
}


function comboProdutoEstoque ($cod_empresa, $cod_produto) 
{
	$sql = "
	select 		gp.cod_produto, gp.descricao
	from 		produtos gp
	where 		gp.cod_empresa = ".$cod_empresa."
	order by 	gp.descricao asc;
	";

	$query = mysql_query($sql);

	?>

	<select name="cod_produto" id="cod_produto" class="form-control" onChange="EstoqueAtual(this.value);">

		<option value="" selected> Selecione o Produto </option>
	
		<?php 

		while ($rs = mysql_fetch_array($query)){ 

		?>

		<option value="<?php echo $rs['cod_produto']; ?>" <?php if ($cod_produto == $rs['cod_produto']) { echo " Selected"; } ?>> <?php echo $rs['descricao']; ?> </option>

		<?php 

		}

		?>

	</select>

<?php
}

?>