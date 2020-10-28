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
			case "tipo_conta_editar":
			$credencial_editar = 1;		
			break;
			case "tipo_conta_excluir":
			$credencial_excluir = 1;		
			break;
			case "tipo_conta_incluir":
			$credencial_incluir = 1;		
			break;
			case "tipo_conta_areas":
			$credencial_areas = 1;		
			break;
		}
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	if (isset($_REQUEST['acao'])){
		
		$acao = '';

		$cod_empresa = $_SESSION['cod_empresa'];

		if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = ''; }
	
		if ($_REQUEST['acao'] == "incluir"){
			
			$credencial = $_REQUEST['credencial'];

			//insere novo tipo_conta
			$sql = "insert into tipo_conta (cod_empresa, descricao) values (".limpa($cod_empresa).", '".limpa($nome)."')";
			//echo $sql;die;
			mysql_query($sql);

			$sql = "select max(cod_tipo_conta) as cod_tipo_conta from tipo_conta where cod_empresa = ".$cod_empresa." limit 1;";
			$query = mysql_query($sql);
			$rs = mysql_fetch_array($query);
			$novo_cod_tipo_conta = $rs['cod_tipo_conta'];

			//recebe as credenciais
			$listaCredenciais = "";
			foreach ($credencial as $value) {
				if ($listaCredenciais == "") {
					$listaCredenciais = $value;
				} else {
					$listaCredenciais = $listaCredenciais.",". $value;
				}
			}

			//insere novas permissoes
			$sql="
			insert into tipo_conta_permissao 
			(cod_tipo_conta, cod_permissao)
			select ".$novo_cod_tipo_conta.", cod_permissao from credenciais
			where cod_credencial in (".$listaCredenciais.")
			group by cod_permissao;
			";
			//echo $sql;die;
			mysql_query($sql);
	
			//insere credenciais selecionadas
			for($i=0; $i<count($credencial);$i++) 
			{
				$sql = "Insert into tipo_conta_credencial (cod_tipo_conta,cod_credencial) values (". $novo_cod_tipo_conta .",". $credencial[$i] .")";
				//echo $sql."<br>";
				mysql_query($sql);
			}
			
			echo "<script language='javascript'>window.location='tipo_contas.php?sucesso=1';</script>";
			
		}else if ($_REQUEST['acao'] == "atualizar"){

			$cod_tipo_conta = $_REQUEST['id'];
			$credencial = $_REQUEST['credencial'];

			$listaCredenciais = "";
			foreach ($credencial as $value) {
				if ($listaCredenciais == "") {
					$listaCredenciais = $value;
				} else {
					$listaCredenciais = $listaCredenciais.",". $value;
				}
			}

			//echo $listaCredenciais;die;

			$sql = "update tipo_conta set descricao='".limpa($nome)."' where cod_tipo_conta = ".$_REQUEST['id'];
			mysql_query($sql);

			//apaga as permissoes
			$sql="delete from tipo_conta_permissao where cod_tipo_conta = ".$cod_tipo_conta.";";
			mysql_query($sql);

			//insere novas permissoes
			$sql="
			insert into tipo_conta_permissao 
			(cod_tipo_conta, cod_permissao)
			select ".$cod_tipo_conta.", cod_permissao from credenciais
			where cod_credencial in (".$listaCredenciais.")
			group by cod_permissao;
			";
			//echo $sql;die;
			mysql_query($sql);

			//apaga as credenciais
			$sql = "delete from tipo_conta_credencial where cod_tipo_conta = ". $cod_tipo_conta;
			//echo $sql."<br>";
			mysql_query($sql);
	
			//insere credenciais selecionadas
			for($i=0; $i<count($credencial);$i++) 
			{
				$sql = "Insert into tipo_conta_credencial (cod_tipo_conta,cod_credencial) values (". $cod_tipo_conta .",". $credencial[$i] .")";
				//echo $sql."<br>";
				mysql_query($sql);
			}

			
			echo "<script language='javascript'>window.location='tipo_contas.php?sucesso=2';</script>";
		
		}
		
	}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
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
			<form action="tipo_conta_info.php" class="form-horizontal row-border" name='frm' method="post">

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
							<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $nome ."'";}?> name="nome" maxlength="100">
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

								if (isset($_REQUEST['acao']) && ($_REQUEST['acao']=="alterar")) {
									
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
						<button class="btn-default btn" onclick="javascript:window.location='tipo_contas.php';">Voltar</button>
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