<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	for ($i=0; $i < count($credenciais); $i++) 
	{ 
		switch($credenciais[$i])
		{
			case "tipo_conta_ver":
			$credencial_ver = 1;		
			break;
		}
	}
	
if ($credencial_ver == '1') 
{	
			
	if (isset($_REQUEST['id'])) {
		$cod_perfil = $_REQUEST["id"];
	}
	
	$sql = "Select * from tipo_conta where cod_tipo_conta = " . $cod_perfil;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$nome 		= $rs['descricao'];
		}
	}
	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="adm_perfil.php">Tipo de Conta</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Tipo de Conta</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Tipo de Conta</h2>
		</div>
		<div class="panel-body">
			<form action="adm_perfil_info.php" class="form-horizontal row-border" name='frm' method="post">

              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>			

				<div class="row">

					<div class="form-group">
						<label class="col-sm-2 control-label"><b>Nome</b></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo $nome; ?>" name="nome" maxlength="100" disabled>
						</div>
					</div>

				</div>

				<?php

				$sql = "
				select 		a.cod_area, a.nome
				from 		area a
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
					where 		p.cod_area = ".$cod_area."
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
								
								$sql3 = "select 		c.* ";

								if ($cod_perfil != "") {
									
									$sql3 = $sql3."
									,(
									select 	case when count(*) > 0 then 'S' else 'N' end
									from	tipo_conta_credencial
									where	cod_tipo_conta =  ".$cod_perfil."
									and 	cod_credencial = c.cod_credencial
									) as TemCredencial
									";

								} else {
									$sql3 = "select  c.*, '' as TemCredencial ";
								}
								
									$sql3 = $sql3."
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
										disabled
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
						<button class="btn-default btn" onclick="javascript:window.location='adm_perfil.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 
} // INCLUIR OU EDITAR

	
include('../include/rodape_interno2.php');
	
?>