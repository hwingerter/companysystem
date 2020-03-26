<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
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
	
if ($credencial_editar == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
$acao = '';

if (isset($_REQUEST['acao'])){
	
    if ($_REQUEST['acao'] == "atualizar"){
		
		$totalcred = $_REQUEST['totalcred'];
		$licenca = $_REQUEST['id'];
		
		$sql = "Delete from licenca_permissao where cod_licenca = ". $licenca;
		mysql_query($sql);
		
		for($i=1; $i<=$totalcred;$i++) {
			if (isset($_REQUEST['area'.$i])) {
				if ($_REQUEST['area'.$i] != '') {
					$sql = "Insert into licenca_permissao (cod_licenca,cod_permissao) values (". $licenca .",". $_REQUEST['area'.$i] .")";
					mysql_query($sql);
				}
			}
		}
		
		echo "<script language='javascript'>window.location='licencas.php?sucesso=2';</script>";
		die();
	
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
	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="permissoes.php">Permissões</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Permissões</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Permissões da Licença</h2>
		</div>
		<div class="panel-body">
			<form action="permissoes.php" class="form-horizontal row-border" name='frm' method="post">
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
			  <input type="hidden" name="totalcred" value="<?php echo $totalcred; ?>">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Licença</b></label>
					<div class="col-sm-8">
						<label class="col-sm-2 control-label"><?php echo ExibeLicenca($_REQUEST['id']); ?></label>
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
				from 		area a
				order by 	a.ordem; ";

				$query = mysql_query($sql);

				while ($rs = mysql_fetch_array($query))
				{ 
				?>

					<div class="panel-heading">
						<h2><?php echo $rs['nome']; ?></h2>
					</div>	


					<?php 

					$sql2 = "
					select 		p.cod_permissao, p.descricao
								,(
									select 	case when count(*) > 0 then 'S' else 'N' end 
									from	licenca_permissao lp 
					                where 	lp.cod_permissao = p.cod_permissao 
					                and 	lp.cod_licenca = ".$licenca.") as TemPermissao
					from 		permissoes p
					inner join	area a on a.cod_area = p.cod_area
					where 		a.cod_area = ".$rs['cod_area']."
					order by 	cod_permissao;";

					$query2 = mysql_query($sql2);

					while ($rs2 = mysql_fetch_array($query2))
					{ 
					?>

					<div class="form-group">
						<label class="col-sm-2 control-label"><b><?php echo $rs2['descricao']; ?></b></label>
						<div class="col-sm-8">
							<label class="checkbox-inline icheck">
								<input type="checkbox" name="area<?php echo $rs2['cod_permissao']; ?>" id="area<?php echo $rs2['cod_permissao']; ?>" value="<?php echo $rs2['cod_permissao']; ?>"
								<?php 
									if ($rs2['TemPermissao'] == "S"){ echo " checked "; }
								?>							
								> 
								Permite
							</label>
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
						<button class="btn-default btn" onclick="javascript:window.location='licencas.php';">Voltar</button>
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