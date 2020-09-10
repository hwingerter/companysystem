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

if (isset($_REQUEST['acao'])){
	
    if ($_REQUEST['acao'] == "atualizar"){
	

		$id 	= $_REQUEST['id'];
		$menu 	= $_REQUEST['menu'];

		$sql = "Delete from tipo_conta_permissao where cod_tipo_conta = ". $id;
		mysql_query($sql);

		for($i=0; $i<count($menu);$i++) 
		{
			$sql = "Insert into tipo_conta_permissao (cod_tipo_conta,cod_permissao) values (". $id .",". $menu[$i] .");";
			//echo $sql."<br>";
			mysql_query($sql);
		}
		
		//die;
		echo "<script language='javascript'>window.location='adm_perfil.php?sucesso=2';</script>";
		die();
	
	}

}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
	
		if (isset($_REQUEST['id'])) {
			$cod_tipo_conta = $_REQUEST["id"];
		}
		$sql = "Select descricao from tipo_conta where cod_tipo_conta = ".$cod_tipo_conta;
		$query = mysql_query($sql);
		$rs = mysql_fetch_array($query);
		$descricao = $rs["descricao"];
		
	
	}
	
}
	
?>

<script language="javascript" src="js/licenca.js"></script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="permissoes.php">Permissões</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Permissões do Tipo de Conta</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2><?php echo $descricao; ?></h2>
		</div>
		<div class="panel-body">
			<form action="permissoes.php" class="form-horizontal row-border" name='frm' method="post">
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
			  <input type="hidden" name="totalcred" value="<?php echo $totalcred; ?>">

				<?php 

				$sql = "
				select 		a.cod_area, a.nome
				from 		area a
				order by 	a.ordem; 
				";

				$query = mysql_query($sql);

				while ($rs = mysql_fetch_array($query))
				{ 
				?>

					<div class="panel-heading">
						<h2><?php echo $rs['nome']; ?></h2>
						<span style="padding-left:5px;">
							<input type="checkbox" name="area1" id="<?php echo $rs['cod_area']; ?>" onClick="SelecionaTodos(this.id, this.checked);"> Todos
						</span>
					</div>	


					<?php 

					$sql2 = "
					select 		p.cod_permissao, p.descricao, 
								(
								select 	case when count(*) > 0 then 'S' else 'N' end
								from	tipo_conta_permissao
								where	cod_tipo_conta =  ".$cod_tipo_conta."
								and 	cod_permissao = p.cod_permissao
								) as TemPermissao
					from 		permissoes p
					inner join	area a on a.cod_area = p.cod_area
					where 		a.cod_area = ".$rs['cod_area']."
					order by 	p.descricao asc;";
					//echo $sql2;die;
					$query2 = mysql_query($sql2);

					while ($rs2 = mysql_fetch_array($query2))
					{ 
					?>

					<div class="form-group">
						<label class="col-sm-3 control-label"><b><?php echo $rs2['descricao']; ?></b></label>
						<div class="col-sm-8">
							<label class="checkbox">
								<input type="checkbox" name="menu[]" id="area_<?php echo $rs['cod_area']; ?>" value="<?php echo $rs2['cod_permissao']; ?>"
								<?php 
									if ($rs2['TemPermissao'] == "S"){ echo " checked "; }
								?>							
								> 
								Permitir
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
} // EDITAR
	
include('../include/rodape_interno2.php');

?>