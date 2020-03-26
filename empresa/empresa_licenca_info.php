<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
$cod_empresa = $_SESSION['cod_empresa'];

if (($credencial_incluir == '1') || ($credencial_editar == '1')) 
{ // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	if (isset($_REQUEST['acao'])) {
	
		$acao = '';
	
		if (isset($_REQUEST['empresa'])) { $empresa = $_REQUEST['empresa']; } else { $empresa = ''; }
		if (isset($_REQUEST['email'])) { $email = $_REQUEST['email']; } else { $email = '';	}
		if (isset($_REQUEST['tipo_pessoa'])) { $tipo_pessoa = $_REQUEST['tipo_pessoa']; } else { $tipo_pessoa = '';	}
		if (isset($_REQUEST['cnpj'])) { $cnpj = $_REQUEST['cnpj']; } else { $cnpj = '';	}
		if (isset($_REQUEST['endereco'])) { $endereco = $_REQUEST['endereco']; } else { $endereco = ''; }
		if (isset($_REQUEST['cep'])) { $cep = $_REQUEST['cep']; } else { $cep = ''; }
		if (isset($_REQUEST['codestado'])) { $estado = $_REQUEST['codestado']; } else { $estado = ''; }
		if (isset($_REQUEST['codcidade'])) { $cidade = $_REQUEST['codcidade']; } else { $cidade = ''; }
		if (isset($_REQUEST['telefone'])) { $telefone = $_REQUEST['telefone']; } else { $telefone = ''; }
		
		if (isset($_REQUEST['inscricao_estadual'])) { $inscricao_estadual = $_REQUEST['inscricao_estadual']; } else { $inscricao_estadual = ''; }
		if (isset($_REQUEST['inscricao_municipal'])) { $inscricao_municipal = $_REQUEST['inscricao_municipal']; } else { $inscricao_municipal = ''; }
		

		if ($_REQUEST['acao'] == "nova_licenca"){
					
			//retorno após pagseguro
			$url_retorno = urlencode("../empresa/empresa_licenca.php?cod_empresa=".$cod_empresa);
			
			$descricao_licenca_atual = $_REQUEST['descricao_licenca_atual'];
			$cod_licenca_renovacao = $_REQUEST['cod_licenca'];
			$dt_inicio = date('Y-m-d');
			$dt_vencimento = date("Y-m-d", strtotime('+10 day'));
			$flg_situacao = "A";

			//dados da licença
			$sql = "select valor from licencas where cod_licenca = ".$cod_licenca_renovacao;
			//echo $sql;die;
			$query = mysql_query($sql);
			$rs = mysql_fetch_array($query);
			$valor_licenca = $rs['valor'];

			//inativo as demais licenças
			$sql = "update empresas_licenca set flg_situacao = 'I' where cod_empresa = ".$cod_empresa;
			//echo $sql;die;
			mysql_query($sql);
			
			//crio nova licenca
			$sqlLicenca = "
			INSERT INTO empresas_licenca
			(`cod_empresa`,
			`cod_licenca`,
			`dt_inicio`,
			`dt_vencimento`,
			`valor`,
			`flg_situacao`)
			VALUES
			(".$cod_empresa.",
			".$cod_licenca_renovacao.",
			'".$dt_inicio."',
			'".$dt_vencimento."',
			".$valor_licenca.",
			'".$flg_situacao."'
			);
			";
			
			//echo $sqlLicenca;die;
		
			mysql_query($sqlLicenca);
			?>
			<script>
				location.href="../pagseguro/index.php?licenca=<?php echo $descricao_licenca_atual;?>&valor=<?php echo $valor_licenca;?>&url_retorno=<?php echo $url_retorno;?>";
			</script>
			<?php
			die;		
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			
			$sql = "update empresas set empresa='". limpa($empresa) ."', email = '". limpa($email) ."', cnpj = '". limpa($cnpj) ."',".
			" endereco = '". limpa($endereco) ."', cep = '". limpa($cep) ."', telefone = '". limpa($telefone) ."', inscricao_estadual = '". limpa($inscricao_estadual) ."', inscricao_municipal = '". limpa($inscricao_municipal) ."'";
			if ($estado != '') { $sql .= ", estado = ". limpa_int($estado); }
			if ($cidade != '') { $sql .= ", cidade = ". limpa_int($cidade); }
			$sql .= " where cod_empresa = ".$_REQUEST['id'];

			echo $sql;die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='empresas.php?sucesso=2';</script>";
			
		}
		
	}

	
	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "ver_licenca"){
			
			$acao = $_REQUEST['acao'];
		
			$sql = "
			select 		e.empresa, el.dt_inicio, el.dt_vencimento, el.flg_situacao
						, date_format(el.dt_inicio, '%d/%m/%Y') as dt_inicio_formatada, date_format(el.dt_vencimento, '%d/%m/%Y') as dt_vencimento_formatada
						,el.valor, e.cod_empresa, l.descricao, l.cod_licenca as cod_licenca_atual
			from 		empresas_licenca el
			inner join 	empresas e on e.cod_empresa = el.cod_empresa
			inner join licencas l on l.cod_licenca = el.cod_licenca
			where 		e.cod_empresa = ".$cod_empresa."
			order by 	el.dt_vencimento desc
			limit 1
			";

			//echo $sql;die;

			$query = mysql_query($sql);
			$registros = mysql_num_rows($query);
			if ($registros > 0) {
				if ($rs = mysql_fetch_array($query)){

					$cod_empresa 	= $rs['cod_empresa'];
					$empresa		= $rs['empresa'];
					
					$dt_inicial 	= $rs['dt_inicio'];
					$dt_vencimento 	= $rs['dt_vencimento'];

					$dt_inicio_formatada 	= $rs['dt_inicio_formatada'];
					$dt_vencimento_formatada 	= $rs['dt_vencimento_formatada'];

					$flg_situacao 	= $rs['flg_situacao'];
					$valor 			= ValorMysqlPhp($rs['valor']);
					$cod_licenca_atual 	= $rs['cod_licenca_atual'];
					$licenca_atual 	= $rs['descricao'];


					$dt_atual = date($rs['dt_inicio']);

					$dt_vencimento = date($rs['dt_vencimento']);
					
					//echo $dt_atual."<br>".$dt_vencimento."<br>";

					$dias_expirar = strtotime($dt_vencimento) - strtotime($dt_atual);
					
					$dias = floor($dias_expirar / (60 * 60 * 24));
					
					$flg_renovar = "N";

					if($dias >= 5){
						$flg_renovar = "S";
					}
					
				}
			}
		
		}
		
	}

	
?>
	 <script src="cidade_ComboAjax.js"></script>
	 <script src="../js/mascaramoeda.js"></script>

	<script language='JavaScript'>
	function Atualizar() {
		document.forms['frm'].action = "empresa_info.php?atualizar=1";
		document.forms['frm'].submit();
	}
	</script>	 

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="empresa_licenca_info.php?acao=ver_licenca">Licença</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Licença</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados da Empresa</h2>
		</div>
		<div class="panel-body">
			<form action="empresa_licenca_info.php" class="form-horizontal row-border" name='frm' method="post">

              <input type="hidden" name="acao" value="nova_licenca">
			  <input type="hidden" name="cod_empresa" value="<?php echo $cod_empresa; ?>">
			  <input type="hidden" name="descricao_licenca_atual" value="<?php echo $licenca_atual; ?>">

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Empresa</b></label>
					<div class="col-sm-6">
					<?php echo $empresa;?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Liçenca Atual</b></label>
					<div class="col-sm-2"><?php echo $licenca_atual; ?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data da Contratação do Plano</b></label>
					<div class="col-sm-2">
					<?php echo $dt_inicio_formatada; ?>

					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data do Vencimento do Plano</b></label>
					<div class="col-sm-2">
					<?php echo $dt_vencimento_formatada; ?>

					</div>
				</div>

				<?php if($flg_renovar == "S"){ ?>

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Licença</b></label>
					<div class="col-sm-3">
						<?php ComboLicencaRenovacao($cod_licenca_atual); ?>
					</div>
				</div>

				<?php } ?>

			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<?php if($flg_renovar == "S"){ ?>
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Renovar Licença</button>						
						<?php } ?>
						&nbsp;
						<button class="btn-default btn" onclick="javascript:window.location='../inicio.php';">Voltar página inicial</button>
						
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
							</div>
<?php 
}
	
include('../include/rodape_interno2.php');

?>