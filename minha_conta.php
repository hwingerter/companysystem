<?php 

require_once "include/topo_interno.php";

require_once "include/funcoes.php";
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	
if (isset($_REQUEST['acao'])){
	
	if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = '';	}
	if (isset($_REQUEST['email'])) { $email = $_REQUEST['email']; } else { $email = '';	}
	if (isset($_REQUEST['senha']) && ($_REQUEST['senha']!="")) { $senha = $_REQUEST['senha']; } else { $senha = '';	}
	if (isset($_REQUEST['confirmar_senha']) && ($_REQUEST['confirmar_senha']!="")) { $confirmar_senha = $_REQUEST['confirmar_senha']; } else { $confirmar_senha = '';	}
	
 	if ($_REQUEST['acao'] == "atualizar"){
		
		$Erro = "";

		//validações
		if(($senha != "") || ($confirmar_senha != ""))
		{
			if($senha != $confirmar_senha){

				$Erro = "1";
				$MensagemErro = "Senhas não conferem!";

			}
		}

		if ($Erro == "")
		{
			$sql = "update usuarios set nome='".limpa($nome)."', email='". limpa($email) ."'";
			if ($senha != '') { 
				$senha .= "&D31R#i017$";
				$senha = md5($senha);
				$sql .= ", senha = '". $senha ."'"; 
			}
			$sql .= " where cod_usuario = ". $_SESSION['usuario_id'];
			//echo $sql;die;
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='minha_conta.php?sucesso=1';</script>";
		}
	
	}
	
}

	$sql = "Select * from usuarios where cod_usuario = " . $_SESSION['usuario_id'];
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$nome = $rs['nome'];
			$email = $rs['email'];
		}
	}
	
?>
        <div id="wrapper">
            <div id="layout-static">

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="minha_conta.php">Minha Conta</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Minha Conta</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                
<?php
if ($sucesso == '1') {
?>
<div class="alert alert-dismissable alert-success">
	<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados alterados com sucesso!</strong>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div>
<?php
} 
?>	

<?php if ($Erro == "1") {?>
	<div class="alert alert-dismissable alert-danger">
		<i class="fa fa-fw fa-check"></i>&nbsp; <strong><?php echo $MensagemErro; ?></strong>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	</div>	
<?php } ?>


<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados da minha conta</h2>
		</div>
		
		
		<div class="panel-body">
			<form action="minha_conta.php" class="form-horizontal row-border" name='frm' method="post">
              <input type="hidden" name="acao" value="atualizar">
				<div class="form-group">
					<label class="col-sm-2 control-label">Nome</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $nome; ?>" name="nome" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $email; ?>" name="email" maxlength="100">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Senha</label>
					<div class="col-sm-2">
						<input type="password" class="form-control" value="" name="senha" maxlength="10">
					</div>
					<div class="col-sm-8">
							<label style="font-weight:bold;">Caso queira alterar sua senha, basta preencher o campo.</label>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label">Confirmar Senha</label>
					<div class="col-sm-2">
						<input type="password" class="form-control" value="" name="confirmar_senha" maxlength="10">
					</div>
				</div>				
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Atualizar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 

require_once('include/rodape_interno.php'); 

?>