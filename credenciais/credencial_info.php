<?php

	require_once "../include/topo_interno2.php";

	require_once "../include/funcoes.php";

	require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************

	for ($i=0; $i < count($credenciais); $i++) 
	{ 
		switch($credenciais[$i])
		{
			case "credencial_ver":
			$credencial_ver = 1;		
			break;
			case "credencial_editar":
			$credencial_editar = 1;		
			break;
		}
	}
	
if ($credencial_editar == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
$acao = '';

$tipo_conta = $_REQUEST['id'];

if (isset($_REQUEST['acao'])){
	
    if ($_REQUEST['acao'] == "atualizar"){
		
		$credencial = $_REQUEST['credencial'];
		$tipo_conta = $_REQUEST['id'];
		$voltar = $_REQUEST['voltar'];
		
		$sql = "delete from tipo_conta_credencial where cod_tipo_conta = ". $tipo_conta;
		//echo $sql."<br>";
		mysql_query($sql);

		for($i=0; $i<count($credencial);$i++) 
		{
			$sql = "Insert into tipo_conta_credencial (cod_tipo_conta,cod_credencial) values (". $tipo_conta .",". $credencial[$i] .")";
			//echo $sql."<br>";
			mysql_query($sql);
		}

		//die;
		
		if($voltar != ""){
			echo "<script language='javascript'>window.location='".$voltar."?sucesso=2';</script>";
			die();
		}else{
			echo "<script language='javascript'>window.location='credenciais.php?sucesso=2';</script>";
			die();
		}


	
	}

}
	
?>

<script language="javascript">

	function SelecionarTodosCadastros(){

		for(i=1; i<=12; i++){

			var item = "cheque_" + i;

			document.getElementById(item).style.display = "none";

		}

		for(i=1; i<=numero; i++){

			var item = "cheque_" + i;

			document.getElementById(item).style.display = "block";

		}

	}

</script>


				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="credenciais.php">Credenciais</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Credenciais</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Credencial do Tipo de Conta</h2>
		</div>
		<div class="panel-body">
			<form action="credencial_info.php" class="form-horizontal row-border" name='frm' method="post">
              
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
			  <input type="hidden" name="totalcred" value="<?php echo $totalcred; ?>">
			  <input type="hidden" name="voltar" value="<?php echo $voltar; ?>">

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo de Conta</b></label>
					<div class="col-sm-8">
						<label class="col-sm-2 control-label"><?php echo ExibeNomeTipoConta($_REQUEST['id']); ?></label>
					</div>
				</div>

				<?php

				$sql = "
				select 		a.cod_area, a.nome
				from 		area a
				inner join 	permissoes p on p.cod_area = a.cod_area
				inner join 	tipo_conta_permissao t on p.cod_permissao = t.cod_permissao
				where		t.cod_tipo_conta = ".$tipo_conta."
				group by	a.cod_area, a.nome
				order by 	a.ordem;
				";
				$query = mysql_query($sql);
				while ($rs = mysql_fetch_array($query)) 
				{ 
					$cod_area = $rs['cod_area'];
				?>
				
					<div class="panel-heading">
						<h2><?php echo $rs['nome'];?></h2>
					</div>	

					<?php
					$sql2 = "
					select 		p.*
					from 		permissoes p
					inner join 	tipo_conta_permissao t on t.cod_permissao = p.cod_permissao
					where		t.cod_tipo_conta = ".$tipo_conta."
					and 		p.cod_area = ".$cod_area."
					order by 	p.descricao;
					";
					//echo $sql2;

					$query2 = mysql_query($sql2);
					while ($rs2 = mysql_fetch_array($query2)) 
					{ 
						$cod_permissao = $rs2['cod_permissao'];
					?>

						<div class="form-group">
							<label class="col-sm-2 control-label"><b><?php echo $rs2['descricao'];?></b></label>
							<div class="col-sm-8">

								<?php
								$sql3 = "
								select 		c.*,
											(
											select 	case when count(*) > 0 then 'S' else 'N' end
											from	tipo_conta_credencial
											where	cod_tipo_conta =  ".$tipo_conta."
											and 	cod_credencial = c.cod_credencial
											) as TemCredencial
								from 		credenciais c
								where 		c.cod_permissao = ".$cod_permissao."
								order by 	c.descricao;
								";
								//echo $sql3;
								$query3 = mysql_query($sql3);
								while ($rs3 = mysql_fetch_array($query3)) 
								{ 
								?>

									<label class="checkbox-inline icheck">
										<input type="checkbox" name="credencial[]" id="area1" value="<?php echo $rs3['cod_credencial'];?>"  
										<?php if ($rs3['TemCredencial']=='S'){ echo ' Checked '; }?>
										> <?php echo $rs3['descricao'];?>
									</label>

								<?php
								}
								?>

							</div>
						</div>

					<?php
					}
			
				}
?>

			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='credenciais.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 
} // EDITAR
	
	include('../include/rodape_interno2.php');

?>