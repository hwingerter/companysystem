<?php 
require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	include('../include/email.php');

	//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	$Erro 					= "0";
	$MensagemErro 			= "Os seguintes erros foram encontrados: <br>";
	$ValidaEndereco			= $_SESSION['cadastro_flag_1'];
	$ValidaBairro			= $_SESSION['cadastro_flag_2'];
	$ValidaCidade			= $_SESSION['cadastro_flag_3'];
	$ValidaEstado			= $_SESSION['cadastro_flag_4'];
	$ValidaCEP 				= $_SESSION['cadastro_flag_5'];
	$ValidaNomeCompleto 	= $_SESSION['cadastro_flag_6'];
	$ValidaTelefoneCelular 	= $_SESSION['cadastro_flag_7'];
	$ValidaDiaMesAniversario= $_SESSION['cadastro_flag_8'];
	$ValidaEmail			= $_SESSION['cadastro_flag_9'];
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cliente_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cliente_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cliente_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "cliente_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usuário tem a credencial de incluir ou editar	
	
	$acao = '';
	
	$cod_empresa = $_SESSION['cod_empresa'];

	if (isset($_REQUEST['apelido'])) { $apelido = $_REQUEST['apelido']; } else { $apelido = ''; }
	if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = ''; }
	if (isset($_REQUEST['telefone'])) { $telefone = $_REQUEST['telefone']; } else { $telefone = ''; }
	if (isset($_REQUEST['celular'])) { $celular = $_REQUEST['celular']; } else { $celular = ''; }
	if (isset($_REQUEST['email'])) { $email = $_REQUEST['email']; } else { $email = '';	}
	if (isset($_REQUEST['dia'])) { $dia_aniversario = $_REQUEST['dia']; } else { $dia_aniversario = ''; }	
	if (isset($_REQUEST['mes'])) { $mes_aniversario = $_REQUEST['mes']; } else { $mes_aniversario = ''; }	
	if (isset($_REQUEST['cep'])) { $cep = $_REQUEST['cep']; } else { $cep = ''; }
	if (isset($_REQUEST['endereco'])) { $endereco = $_REQUEST['endereco']; } else { $endereco = ''; }
	if (isset($_REQUEST['numero'])) { $numero = $_REQUEST['numero']; } else { $numero = ''; }
	if (isset($_REQUEST['complemento'])) { $complemento = $_REQUEST['complemento']; } else { $complemento = ''; }
	if (isset($_REQUEST['bairro'])) { $bairro = $_REQUEST['bairro']; } else { $bairro = ''; }
	if (isset($_REQUEST['codcidade'])) { $cidade = $_REQUEST['codcidade']; } else { $cidade = ''; }
	if (isset($_REQUEST['codestado'])) { $estado = $_REQUEST['codestado']; } else { $estado = ''; }
	if (isset($_REQUEST['obs'])) { $obs = $_REQUEST['obs']; } else { $obs = ''; }
	
	if ($_REQUEST['acao'] == "atualizar")
	{
		$acao = "alterar";
	}
	else
	{
		$acao = "incluir";
	}

	if ((isset($_REQUEST['acao'])) && ( ($_REQUEST['acao'] == "incluir") || ($_REQUEST['acao'] == "atualizar")))
	{

		if ($ValidaNomeCompleto) {
			if ($nome == "") 
			{
				$Erro = "1";
				$MensagemErro .= "<br>- Preencher o campo Nome Completo";
			}			
		}

		if ($ValidaTelefoneCelular) {
			if (($telefone == "") && ($celular == "")) {
				$Erro = "1";
				$MensagemErro .= "<br>- Preencher o campo Telefone ou Celular";
			}			
		}

		if ($ValidaEmail) {
			if ($email == "") {
				$Erro = "1";
				$MensagemErro .= "<br>- Preencher o campo E-mail";
			}			
		}

		if ($ValidaDiaMesAniversario) {
			if (($dia_aniversario == "") && ($mes_aniversario == "")) {
				$Erro = "1";
				$MensagemErro .= "<br>- Preencher o campo Dia/Mês de Aniversário";
			}			
		}

		if ($ValidaCEP) {
			if ($cep == "") {
				$Erro = "1";
				$MensagemErro .= "<br>- Preencher o campo CEP";
			}			
		}

		if ($ValidaEndereco) {
			if ($endereco == "") {
				$Erro = "1";
				$MensagemErro .= "<br>- Preencher o campo Endereço";
			}			
		}

		if ($ValidaBairro) {
			if ($bairro == "") {
				$Erro = "1";
				$MensagemErro .= "<br>- Preencher o campo Bairro";
			}			
		}

		if ($ValidaCidade) {
			if ($cidade == "") {
				$Erro = "1";
				$MensagemErro .= "<br>- Selecionar o campo Cidade";
			}			
		}


		if ($ValidaEstado) {
			if ($estado == "") {
				$Erro = "1";
				$MensagemErro .= "<br>- Selecionar o campo Estado";
			}			
		}

		//validações
		if((!ValidarEmail($email) && ($email != "")))
		{
			$Erro = "1";
			$MensagemErro .= "<br>- E-mail Inválido!";

		}
		
		if ($Erro == "0")
		{
			if ($_REQUEST['acao'] == "incluir")
			{			
				$sql = "

				INSERT INTO `clientes`
				(`cod_empresa`,
				`apelido`,
				`nome`,
				`telefone`,
				`celular`,
				`email`,
				`dia_aniversario`,
				`mes_aniversario`,
				`cep`,
				`endereco`,
				`numero`,
				`complemento`,
				`bairro`,
				`cidade`,
				`estado`,
				`obs`)
				VALUES
				('".$cod_empresa."',
				'".$apelido."',
				'".$nome."',
				'".$telefone."',
				'".$celular."',
				'".$email."',
				'".$dia_aniversario."',
				'".$mes_aniversario."',
				'".$cep."',
				'".$endereco."',
				'".$numero."',
				'".$complemento."',
				'".$bairro."',
				'".$cidade."',
				'".$estado."',
				'".$obs."');

				";

				//echo $sql;die;

				mysql_query($sql);

				$sql = "Select max(cod_cliente) as cod_cliente from clientes where cod_empresa = ".$cod_empresa;
				$query 	= mysql_query($sql);
				$rs 	= mysql_fetch_array($query);
				$cliente_inserido = $rs['cod_cliente'];
				

				if((isset($_REQUEST['retorno'])) && ($_REQUEST['retorno'] == "nova_comanda")){
					echo "<script language='javascript'>window.location='../comanda/comanda_cliente.php?cod_cliente=".$cliente_inserido."';</script>";	

				}else{
					echo "<script language='javascript'>window.location='clientes.php?sucesso=1';</script>";

				}
				
			}else if ($_REQUEST['acao'] == "atualizar")
			{			
 				$sql = "

				UPDATE `clientes`
				SET
				`apelido` = '".$apelido."',
				`nome` = '".$nome."',
				`telefone` = '".$telefone."',
				`celular` = '".$celular."',
				`email` = '".$email."',
				`dia_aniversario` = '".$dia_aniversario."',
				`mes_aniversario` = '".$mes_aniversario."',
				`cep` = '".$cep."',
				`endereco` = '".$endereco."',
				`numero` = '".$numero."',
				`complemento` = '".$complemento."',
				`bairro` = '".$bairro."',
				`cidade` = '".$cidade."',
				`estado` = '".$estado."',
				`obs` = '".$obs."'
				WHERE `cod_cliente` = ".$_REQUEST['id'].";

				";

				//echo $sql;die;

				mysql_query($sql);

				echo "<script language='javascript'>window.location='clientes.php?sucesso=2';</script>";
				
			}
		}

	}
	
	if ((isset($_REQUEST['acao'])) && ($_REQUEST['acao'] == "alterar")) 
	{
			
			$acao = $_REQUEST['acao'];
			
			if (isset($_REQUEST['id'])) {
				$cliente = $_REQUEST["id"];
			}
			
			$sql = "Select * from clientes where cod_cliente = " . $cliente;
			$query = mysql_query($sql);
			$registros = mysql_num_rows($query);
			if ($registros > 0) {
				if ($rs = mysql_fetch_array($query)){

					$apelido = $rs["apelido"];
					$nome = $rs["nome"];
					$telefone = $rs["telefone"];
					$celular = $rs["celular"];
					$email = $rs["email"];
					$dia_aniversario = $rs["dia_aniversario"];
					$mes_aniversario = $rs["mes_aniversario"];
					$cep = $rs["cep"];
					$endereco = $rs["endereco"];
					$numero = $rs["numero"];
					$complemento = $rs["complemento"];
					$bairro = $rs["bairro"];
					$cidade = $rs["cidade"];
					$estado = $rs["estado"];
					$obs = $rs["obs"];

					
				}
			}
				
		}
	
?>
	 <script language='JavaScript' type="text/javascript" src="../js/cidade_ComboAjax.js"></script>
	 <script language='JavaScript' type="text/javascript" src="../js/jquery.mask.min.js"></script>
	<script language='JavaScript'>

		$(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                //$("#cidade").val("");
                //$("#uf").val("");
                //$("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        //$("#cidade").val("...");
                        //$("#uf").val("...");
                        //$("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                //$("#cidade").val(dados.localidade);
                                //$("#uf").val(dados.uf);
                                //("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
		
		});



	</script>	 

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="clientes.php">Clientes</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Cliente</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">

<?php if ($Erro == "1") {?>
	<div class="alert alert-dismissable alert-danger">
		<i class="fa fa-fw fa-check"></i>&nbsp; <strong><?php echo $MensagemErro; ?></strong>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	</div>	
<?php } ?>


<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Cliente</h2>
		</div>
		<div class="panel-body">
			<form action="cliente_info.php" class="form-horizontal row-border" name='frm' method="post">

	            <input type="hidden" name="retorno" value="<?php echo $_REQUEST['retorno']; ?>">

				<?php if ($acao=="alterar"){?>
				<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
				<input type="hidden" name="acao" value="atualizar">
				<?php }else{?>
				<input type="hidden" name="acao" value="incluir">
				<?php } ?>								
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Nome ou Apelido</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $apelido;?>" name="apelido" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Nome Completo</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $nome;?>" name="nome" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Telefone</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $telefone;?>" name="telefone" id="telefone" maxlength="50">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Celular</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $celular;?>" name="celular" id="celular" maxlength="50">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>E-mail</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $email;?>" name="email" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Dia/Mês Nascimento</b></label>
					<div class="col-sm-1">
						<input type="text" class="form-control" value="<?php echo $dia_aniversario;?>" name="dia" maxlength="2">
					</div>
					<div class="col-sm-2"><?php ComboMeses($mes_aniversario); ?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>CEP</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $cep;?>" name="cep" id="cep" maxlength="10">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Endereço</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $endereco;?>" name="endereco" id="rua" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Número</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $numero;?>" name="numero" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Complemento</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $complemento;?>" name="complemento" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Bairro</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $bairro;?>" name="bairro" id="bairro" maxlength="200">
					</div>
				</div>
			
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Estado</b></label>
					<div class="col-sm-8">
					  <select name="codestado" Onchange='atualizaCidade(this.value);' class="form-control">
						<option value="">UF</option>
	                    <?php
	                    $query = mysql_query("select * from estados order by uf asc") or die (mysql_error());
						while($rs = mysql_fetch_array($query)){
						?>
						<option value="<?php echo $rs['cod_estado'];?>"
						<?php if ($estado == $rs['cod_estado']) { echo " Selected"; }?>
						><?php echo htmlentities($rs['uf']);?></option>
	                    <?php
						}
						?>
					  </select>						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Cidade</b></label>
					<div class="col-sm-8">
                    <div id="city">
				  	<select name="codcidade" class="form-control">
						<option value="">Selecione</option>
 					</select>
					</div>						
					</div>
				</div>			

				<?php 
				if ($cidade != '') {
				?>
				<script language='JavaScript'>EditaCidade('<?php echo $estado; ?>','<?php echo $cidade; ?>');</script>
				<?php
				}
				?>	

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Observações</b></label>
					<div class="col-sm-8">
					  <textarea name="obs" style="width:100%; height: auto;"><?php echo $obs;?></textarea>
					</div>
				</div>				
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='clientes.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					
<?php 
}
include('../include/rodape_interno2.php');

?>

<script>
	$(document).ready(function(){
		$('#telefone').mask('(99) 9999-9999');
		$('#celular').mask('(99) 99999-9999');
		$('#cep').mask('99999-999');		
	});

</script>