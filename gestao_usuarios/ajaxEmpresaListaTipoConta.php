<?php

include('../config/conexao.php');

include('../include/funcoes.php');
	
//header('Content-type: text/html; charset=iso-8859-1');
	
$cod_empresa = $_REQUEST['cod_empresa']; 
$cod_tipo_conta = $_REQUEST['cod_tipo_conta'];
    
if ($cod_empresa != "")
{

    $sql = "
    select		tc.cod_tipo_conta, tc.descricao
    from 		tipo_conta tc
    where 		tc.cod_empresa = ".$cod_empresa."
    order by 	tc.descricao asc;
    ";
    //echo $sql;die;

    $query = mysql_query($sql);

    ?>

        <select name="cod_tipo_conta" id="cod_tipo_conta" class="form-control">

        <option value="" selected> Selecione </option>

        <?php 

        while ($rs = mysql_fetch_array($query))
        { 

            ?>

            <option value="<?php echo $rs['cod_tipo_conta']; ?>" <?php if($cod_tipo_conta == $rs['cod_tipo_conta']){ echo " selected "; }?>> <?php echo $rs['descricao']; ?> </option>

            <?php 

        }

        ?>

        </select>


    <?php


}

?>
