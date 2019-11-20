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
	

if ($credencial_editar == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	$acao = '';
	
	if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = ''; }
	if (isset($_REQUEST['email'])) { $email = $_REQUEST['email']; } else { $email = '';	}
	if (isset($_REQUEST['cod_empresa'])) { $cod_empresa = $_REQUEST['cod_empresa']; } else { $cod_empresa = '';	}
	if (isset($_REQUEST['cod_tipo_conta'])) { $tipo_conta = $_REQUEST['cod_tipo_conta']; } else { $tipo_conta = '';	}
	if (isset($_REQUEST['senha'])) { $senha = $_REQUEST['senha']; } else { $senha = '';	}
	if (isset($_REQUEST['status'])) { $status = $_REQUEST['status']; } else { $status = ''; }

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "incluir")
	{	

		$cod_usuario_cadastro = $_SESSION['usuario_id'];
		$dt_cadastro = date('Y-m-d');

		$sql = "insert into usuarios (nome, email, status, tipo_conta ";

		if ($senha != '') { 
			$sql .= ", senha"; 
			$senha .= "&D31R#i017$";
			$senha = md5($senha);
		}

		$sql .= ",cod_usuario_cadastro, dt_cadastro) values ('".limpa($nome)."', '". limpa($email) ."','". limpa($status) ."', ". limpa($tipo_conta).", ";
		if ($senha != '') { $sql .= "'". $senha ."'";}
		$sql .= " ,". $cod_usuario_cadastro .", '". $dt_cadastro ."')";

		//echo $sql;die;

		mysql_query($sql);

		//pegar usuário cadastrado.
		$sql = "Select max(cod_usuario) as cod_usuario from usuarios where cod_usuario_cadastro = ".$cod_usuario_cadastro."";
		//echo $sql;die;
		$query = mysql_query($sql);
		$rs = mysql_fetch_array($query);
		$cod_usuario_cadastrado = $rs['cod_usuario'];

		//inserir usuário na empresa
		$sql = "insert into	usuarios_grupos_empresas (cod_usuario, cod_empresa) values (". limpa($cod_usuario_cadastrado) .", ".limpa($cod_empresa).");";
		//echo $sql;die;
		mysql_query($sql);

		echo "<script language='javascript'>window.location='adm_usuarios.php?sucesso=1';</script>";
		
	}else if ($_REQUEST['acao'] == "atualizar"){

		$cod_usuario = $_REQUEST['id'];

		$sql = "update usuarios set nome='".limpa($nome)."', status='". limpa($status) ."'
				, email = '". limpa($email) ."', tipo_conta = ". $tipo_conta." ";

		if ($senha != '') { 
			$senha .= "&D31R#i017$";
			$senha = md5($senha);
			$sql .= ", senha = '". $senha ."'"; 
		}

		$sql .= " where cod_usuario = ".$cod_usuario;

		mysql_query($sql);

		$sql = "Select cod_usuario from usuarios_grupos_empresas where cod_usuario = ".$cod_usuario."";
		//echo $sql;die;
		$query = mysql_query($sql);
		$rs = mysql_fetch_array($query);
		
		if($rs['cod_usuario'] == ""){
			$sql = "insert into	usuarios_grupos_empresas (cod_usuario, cod_empresa) values (". limpa($cod_usuario) .", ".limpa($cod_empresa).");";
			mysql_query($sql);
		}
		
		echo "<script language='javascript'>window.location='adm_usuarios.php?sucesso=2';</script>";
	
	}
	
}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['id'])) {
			$cod_usuario = $_REQUEST["id"];
		}
		
		$sql = "
		select		u.cod_usuario, tp.cod_empresa, tp.cod_tipo_conta, u.nome, u.status, u.email
		from 		usuarios u
		inner join 	tipo_conta tp on tp.cod_tipo_conta = u.tipo_conta
		where 		u.cod_usuario = ".$cod_usuario.";
		";
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){
				$nome = $rs['nome'];
				$status = $rs['status'];
				$email = $rs['email'];
				$cod_tipo_conta = $rs['cod_tipo_conta'];
				$cod_grupo	= $rs['cod_grupo'];
				$cod_empresa = $rs['cod_empresa'];
			}
		}
	
	}
	
}

?>
<script>
function EmpresaCarregaTipoConta(cod_empresa, cod_tipo_conta)
{

	$("#lblCarregandoTipoConta").hide();

	$.ajax({
	    type: "GET",
	    url: "ajaxEmpresaListaTipoConta.php?cod_empresa="+ cod_empresa +"&cod_tipo_conta=" + cod_tipo_conta + "&"+new Date().getTime(),
	    beforeSend: function () {
			$("#QuadroTipoConta").show();
	        $("#lblCarregandoTipoConta").show();
	    },
	    success: function (data){					
			//setInterval(function(){ 
				$("#lblCarregandoTipoConta").hide();
				$("#DivTipoConta").html(data);
				$("#DivTipoConta").show();
			//}, 3000);	

	    },
	    error: function (xhr, ajaxOptions, thrownError) {
	        console.log("error: xhr: " + xhr.status + " - thrownError: " + thrownError);
	    },
	});
	
}
</script>


				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="adm_usuarios.php">Usuários</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Usuário</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Usuário</h2>
		</div>
		<div class="panel-body">
			<form action="adm_usuario_info.php" class="form-horizontal row-border" name='frm' method="post">
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>				

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Nome</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $nome ."'";}?> name="nome" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>E-mail</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $email ."'";}?> name="email" maxlength="255">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Senha</b></label>
					<div class="col-sm-8">
						<input type="password" class="form-control" value="" name="senha" maxlength="10"> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Empresa</b></label>
					<div class="col-sm-8">
						<?php
							
							ComboAdmEmpresa($cod_empresa);
						?>						
					</div>
				</div>			
				<div class="form-group" id="QuadroTipoConta" style="display:none;">
					<label class="col-sm-2 control-label"><b>Tipo Conta</b></label>
					<div class="col-sm-8" id="DivTipoConta">
						<label id="lblCarregandoTipoConta" style="display:none;" class="label label-primary">Carregando...</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Status</b></label>
					<div class="col-sm-8">
						<select class="form-control" id="source" name="status">
							<option value="A" <?php if ($acao == "alterar"){ if ($status == 'A') { echo "selected"; } }?>>Ativo</option>
							<option value="I" <?php if ($acao == "alterar"){ if ($status == 'I') { echo "selected"; } }?>>Inativo</option>
						</select>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='adm_usuarios.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 
}
	
if ($_REQUEST['acao'] == "alterar"){
?>
<script>
	EmpresaCarregaTipoConta('<?php echo $cod_empresa; ?>', '<?php echo $cod_tipo_conta; ?>');
</script>
<?php
}

include('../include/rodape_interno2.php');

?>