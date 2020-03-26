<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

require_once "../licenca/licenca.inc.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	//if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	//}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "credencial_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "credencial_editar") {
			$credencial_editar = 1;
			break;
		}
	}


$cod_empresa = $_REQUEST['cod_empresa'];
$cod_tipo_conta = $_REQUEST['id'];
$voltar = $_REQUEST['voltar'];

$cod_licenca = ObterLicencaAtual($cod_empresa);

if ($credencial_editar == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
$acao = '';

if (isset($_REQUEST['acao'])){
	
    if ($_REQUEST['acao'] == "atualizar"){
		
		$tipo_conta = $_REQUEST['id'];
		$voltar = $_REQUEST['voltar'];
		$cred = $_REQUEST['credencial'];
		
		$sql = "Delete from tipo_conta_credencial where cod_tipo_conta = ". $tipo_conta;
		mysql_query($sql);
		
		for($i=0; $i<count($cred);$i++) {

			$sql = "Insert into tipo_conta_credencial (cod_tipo_conta,cod_credencial) values (". $tipo_conta .",". $cred[$i] .")";
			//echo $sql."<br>";
			mysql_query($sql);
		}

		//die;
		
		if($voltar != ""){
			echo "<script language='javascript'>window.location='".$voltar."?sucesso=2';</script>";
			die();
		}else{
			echo "<script language='javascript'>window.location='adm_perfil.php?sucesso=2';</script>";
			die();
		}


	
	}

}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
	
		if (isset($_REQUEST['id'])) {
			$licenca = $_REQUEST["id"];
		}
		
		$sql = "Select count(*) as total from permissoes";
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)) { 
				$totalcred = $rs["total"];
			}
		}
		
		// ZERA O VETOR
		for($i=1; $i<=$totalcred;$i++) {
			$cred[$i] = 0;
		}
		
		$sql = "Select licenca_permissao.cod_permissao from licenca_permissao left join permissoes on  ".
		"licenca_permissao.cod_permissao = permissoes.cod_permissao where licenca_permissao.cod_licenca = " . $licenca;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			$i = 1;
			while ($rs = mysql_fetch_array($query)) { 
				$cred[$i] = $rs["cod_permissao"];
				$i = $i + 1;
			}
		}
		
	}
	
}
	
$sql = "select descricao from tipo_conta where cod_tipo_conta = ".$cod_tipo_conta."";
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)) { 
				$descricao_tipo_conta = $rs["descricao"];
			}
		}

?>

<script language="javascript" src="js/licenca.js"></script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="permissoes.php">Credenciais</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Credenciais do Tipo de Conta</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Credenciais do Tipo de Conta</h2>
		</div>
		<div class="panel-body">
			<form action="credencial_info.php" class="form-horizontal row-border" name='frm' method="post">
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
			  <input type="hidden" name="totalcred" value="<?php echo $totalcred; ?>">
			  <input type="hidden" name="cod_empresa" value="<?php echo $cod_empresa; ?>">
				<div class="form-group">
					<label class="col-sm-1 control-label"><b>Tipo de Conta</b></label>
					<div class="col-sm-3">
						<label class="col-sm-8 control-label"><?php echo $descricao_tipo_conta; ?></label>
					</div>
				</div>

				<?php 

				$sql = "Select licenca_permissao.cod_permissao from licenca_permissao left join permissoes on  ".
				"licenca_permissao.cod_permissao = permissoes.cod_permissao where licenca_permissao.cod_licenca = " . $licenca;
				//echo $sql;die;
				$query = mysql_query($sql);
				$registros = mysql_num_rows($query);
				if ($registros > 0) {
					$i = 1;
					while ($rs = mysql_fetch_array($query)) { 
						$cred[$i] = $rs["cod_permissao"];
						$i = $i + 1;
					}
				}

				 ?>


				<?php 

				$sql = "
				select 		a.cod_area, a.nome
				from 		licencas l 
				inner join	licenca_permissao lp on lp.cod_licenca = l.cod_licenca
				inner join 	permissoes p on p.cod_permissao = lp.cod_permissao
				inner join 	area a on a.cod_area = p.cod_area
				where 		l.cod_licenca = ".$cod_licenca."
				group by	a.cod_area, a.nome;
				";

				$query = mysql_query($sql);

				while ($rs = mysql_fetch_array($query))
				{ 
				?>

					<div class="panel-heading">
						<h2><?php echo $rs['nome']; ?></h2>
						<span style="padding-left:5px;">
							<input type="checkbox" name="area<?php echo $rs['cod_area']; ?>" id="<?php echo $rs['cod_area']; ?>" value="<?php echo $rs['cod_area']; ?>" onClick="SelecionaTodos(this.id, this.checked);"> Todos
						</span>
					</div>	


					<?php 

					$sql2 = "
						select 		p.cod_permissao, p.descricao
						from 		permissoes p
						inner join	area a on a.cod_area = p.cod_area
						where 		a.cod_area = ".$rs['cod_area']."
						group by	p.cod_permissao, p.descricao
						order by 	p.descricao asc;
						";
					//echo $sql2;die;
					$query2 = mysql_query($sql2);

					while ($rs2 = mysql_fetch_array($query2))
					{ 
					?>

					<div class="form-group">
						<label class="col-sm-3 control-label"><b><?php echo $rs2['descricao']; ?></b></label>
						<div class="col-sm-8">

							<?php 

							$sql3 = "
							select 		c.cod_credencial, c.descricao,
										(
										select 	case when count(*) > 0 then 'S' else 'N' end 
										from	tipo_conta_credencial tcc
										where 	tcc.cod_tipo_conta = ".$cod_tipo_conta."
										and 	tcc.cod_credencial = c.cod_credencial
										) as TemPermissao
							from 		credenciais c
							left join	permissoes p on p.cod_permissao = c.cod_permissao
							where 		p.cod_permissao = ".$rs2['cod_permissao']."
							order by 	c.cod_credencial asc;
							";
							//echo $sql3;//die;
							$query3 = mysql_query($sql3);

							while ($rs3 = mysql_fetch_array($query3))
							{ 

							?>

							<div class="col-sm-8">
								<label class="checkbox">
									<input type="checkbox" name="credencial[]" id="area_<?php echo $rs['cod_area']; ?>" value="<?php echo $rs3['cod_credencial']; ?>"
									
									<?php if ($rs3['TemPermissao'] == "S") {
										echo " checked ";
									}
									?>

									> 
									<?php echo $rs3['descricao'];?>							
								</label>
							</div>

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

						<?php if ($voltar!="") {?>
							<button class="btn-default btn" onclick="javascript:window.location='<?php echo $voltar;?>';">Voltar</button>
						<?php
						} else {
						?>
							<button class="btn-default btn" onclick="javascript:window.location='licencas.php';">Voltar</button>
						<?php
						}
						?>

						

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