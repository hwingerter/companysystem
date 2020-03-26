<?php 

include('../include/topo_interno.php');

$acao = '';
$cod_empresa 			= $_SESSION['cod_empresa'];
$cod_usuario_inclusao 	= $_SESSION['usuario_id'];	
$cod_caixa 				= $_SESSION['cod_caixa'];	
$cod_comanda 			= $_REQUEST['cod_comanda'];
$cod_comanda_item		= $_REQUEST['cod_comanda_item'];

if (isset($_REQUEST['acao'])){

	if (isset($_REQUEST['cod_cliente'])) { $cod_cliente = $_REQUEST['cod_cliente']; } else { $cod_cliente = ''; }

    if ($_REQUEST['acao'] == "incluir_nova_comanda")
    {

		$sql = "insert into comanda (cod_empresa, cod_cliente, cod_caixa, dt_inclusao, cod_usuario) values ('".limpa($cod_empresa)."', '".limpa($cod_cliente)."', ".$cod_caixa.", now(), ".$cod_usuario_inclusao.")";
		//echo $sql;die;
		mysql_query($sql);

		//retorna a comanda criada
		$sql = "select max(cod_comanda) as nova_comanda from comanda where cod_empresa = ".$cod_empresa." and cod_cliente = ".$cod_cliente." and cod_usuario = ".$cod_usuario_inclusao."";

		$query = mysql_query($sql);
		$rs = mysql_fetch_array($query);
		$cod_comanda = $rs['nova_comanda'];
	
		echo "<script language='javascript'>window.location='nova_comanda.php?acao=listar_itens&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>"; die;

    }
    elseif($_REQUEST['acao'] == "Gravar")
    {

        if (isset($_REQUEST['cod_cliente']) && ($_REQUEST['cod_cliente'] != "")) { $cod_cliente = limpa($_REQUEST['cod_cliente']); } else { $cod_cliente = 'NULL'; }

        if (isset($_REQUEST['cod_profissional']) && ($_REQUEST['cod_profissional'] != "")) { $cod_profissional = limpa($_REQUEST['cod_profissional']); } else { $cod_profissional = 'NULL'; }

        if (isset($_REQUEST['cod_servico']) && ($_REQUEST['cod_servico'] != "0")) { $cod_servico = "'".limpa($_REQUEST['cod_servico'])."'"; } else { $cod_servico = 'NULL'; }

        if (isset($_REQUEST['cod_produto']) && ($_REQUEST['cod_produto'] != "0")) { $cod_produto = "'".limpa($_REQUEST['cod_produto'])."'"; } else { $cod_produto = 'NULL'; }
			
        if (isset($_REQUEST["valor"]) && ($_REQUEST['valor'] != "")) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = 'NULL'; }

        if (isset($_REQUEST["quantidade"])) { $quantidade = $_REQUEST["quantidade"]; } else { $quantidade = "NULL"; }

        if ($cod_cliente != "")
        {
            if (($cod_servico == "NULL" && $cod_produto =="NULL"))
            {
                $sql = "insert into comanda (cod_empresa, cod_cliente, cod_caixa, dt_inclusao, cod_usuario) values ('".limpa($cod_empresa)."', '".limpa($cod_cliente)."', ".$cod_caixa.", now(), ".$cod_usuario_inclusao.")";
                //echo $sql;die;
                mysql_query($sql);
    
                echo "<script language='javascript'>window.location='comanda.php';</script>"; die;
            }
            else
            {
                if ($cod_comanda == "")
                {
                    $sql = "insert into comanda (cod_empresa, cod_cliente, cod_caixa, dt_inclusao, cod_usuario) values ('".limpa($cod_empresa)."', '".limpa($cod_cliente)."', ".$cod_caixa.", now(), ".$cod_usuario_inclusao.")";
                    //echo $sql;die;
                    mysql_query($sql);
            
                    //retorna a comanda criada
                    $sql = "select max(cod_comanda) as nova_comanda from comanda where cod_empresa = ".$cod_empresa." and cod_cliente = ".$cod_cliente." and cod_usuario = ".$cod_usuario_inclusao."";
            
                    $query = mysql_query($sql);
                    $rs = mysql_fetch_array($query);
                    $cod_comanda = $rs['nova_comanda'];
                }           

                //descontos e acréscimos
                $flg_desconto_acrescimo = "NULL"; 
                $percentual_desconto    = "NULL";
                $valor_desconto         = "NULL";
                $valor_acrescimo        = "NULL";

                if (isset($_REQUEST["flg_desconto_acrescimo"]) && ($_REQUEST['flg_desconto_acrescimo'] != "0")) 
                { 
                    $flg_desconto_acrescimo = "'".$_REQUEST["flg_desconto_acrescimo"]."'"; 

                    if ($_REQUEST['flg_desconto_acrescimo'] == "1")
                    {
                        $percentual_desconto = $_REQUEST['percentual_desconto'];               
                    }
                    elseif ($_REQUEST['flg_desconto_acrescimo'] == "2"){
        
                        $valor_desconto = ValorPhpMysql($_REQUEST['valor_desconto']); 
                    }
                    elseif ($_REQUEST['flg_desconto_acrescimo'] == "3"){

                        $valor_acrescimo = ValorPhpMysql($_REQUEST['valor_acrescimo']);
                    }

                }

            
                /*  Comissão do Profissional */

                $cod_tipo_comissao	= "NULL";
                $valor_comissao 	= "NULL";

                $sql = "
                select 	cod_tipo_comissao
                        ,case cod_tipo_comissao
                            when 1 then comissao_percentual
                            when 2 then comissao_fixa
                        end as comissao
                from 	profissional_comissao 
                where 	cod_empresa = ".$cod_empresa." 
                and 	cod_profissional = ".$cod_profissional."
                and 	cod_servico = ".$cod_servico."
                ";

                //echo $sql; die;

                $query = mysql_query($sql);
                $total = mysql_num_rows($query);

                $valor_comissao = "NULL";

                if ($total > 0)
                {
                    $rs    				= mysql_fetch_array($query);
                    $cod_tipo_comissao	= $rs["cod_tipo_comissao"];
                    $valor_comissao 	= $rs["comissao"];
                }
                else
                {

                    if($cod_servico != "")
                    {
                        $sql = "
                        select 	cod_tipo_comissao
                                ,case cod_tipo_comissao
                                    when 1 then comissao_percentual
                                    when 2 then comissao_fixa
                                end as comissao
                        from 	servico
                        where 	cod_empresa = ".$cod_empresa." 
                        and 	cod_servico = ".$cod_servico."
                        ";
                        //echo $sql; die;

                        $query = mysql_query($sql);
                        $rs    				= mysql_fetch_array($query);
                        $cod_tipo_comissao	= $rs["cod_tipo_comissao"];
                        $valor_comissao 	= $rs["comissao"];

                    }
                    elseif ($cod_produto != "")
                    {
                        $sql = "
                        select 	cod_tipo_comissao
                                ,case cod_tipo_comissao
                                    when 1 then comissao_percentual
                                    when 2 then comissao_fixa
                                end as comissao
                        from 	produtos
                        where 	cod_empresa = ".$cod_empresa." 
                        and 	cod_produto = ".$cod_produto."
                        ";
                        $query = mysql_query($sql);
                        $rs    				= mysql_fetch_array($query);
                        $cod_tipo_comissao	= $rs["cod_tipo_comissao"];
                        $valor_comissao 	= $rs["comissao"];
                    }

                }

                //echo $cod_tipo_comissao . " - " . $valor_comissao."<br><br>";

                /*********/


                $sql = "
                    INSERT INTO `comanda_item`
                    (`cod_comanda`,
                    `cod_empresa`,
                    `cod_cliente`,
                    `cod_profissional`,
                    `cod_produto`,
                    `cod_servico`,
                    `valor`,
                    `quantidade`,
                    `flg_desconto_acrescimo`,
                    `percentual_desconto`,
                    `valor_desconto`,
                    `valor_acrescimo`,
                    `cod_tipo_comissao`,
                    `valor_comissao`,
                    `dt_inclusao`)
                    VALUES
                    (".$cod_comanda.", 
                    ".$cod_empresa.", 
                    ".$cod_cliente.", 
                    ".$cod_profissional.", 
                    ".$cod_produto.", 
                    ".$cod_servico.", 
                    ".$valor.", 
                    ".$quantidade.",
                    ".$flg_desconto_acrescimo.",
                    ".$percentual_desconto.",
                    ".$valor_desconto.",
                    ".$valor_acrescimo.",
                    ".$cod_tipo_comissao.",
                    ".$valor_comissao.",
                    now())
                    ;";

                
                //echo $sql; die;

                mysql_query($sql);

                echo "<script language='javascript'>window.location='nova_comanda.php?acao=listar_itens&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>"; die;

            }
       
        }

    }
    elseif($_REQUEST['acao'] == "excluir_item_comanda")
    {

        $sql = "delete from comanda_item where cod_empresa=".$cod_empresa." and cod_cliente=".$cod_cliente." and cod_comanda=".$cod_comanda."  and cod_comanda_item = ".$cod_comanda_item."";
        //echo $sql;die;
		mysql_query($sql);

        echo "<script language='javascript'>window.location='nova_comanda.php?acao=listar_itens&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>"; die;

    }

}
