<?php 

	include('../include/topo_interno.php');
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
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
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
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
	
	
	if (isset($_REQUEST['atualizar'])) { $atualizar = $_REQUEST['atualizar']; } else { $atualizar = ''; }
	
if ($atualizar != '1') {
	
	if (isset($_REQUEST['acao'])) {
		
		if ($_REQUEST['acao'] == "nova_licenca"){
			
			$sql = "insert into empresas (empresa, email, cnpj, endereco, cep, telefone, inscricao_estadual, inscricao_municipal";
			if ($estado != '') { $sql .= ", estado"; }
			if ($cidade != '') { $sql .= ", cidade"; }
			$sql .= ") values ('". limpa($empresa) ."','". limpa($email) ."', '". limpa($cnpj) ."','". limpa($endereco) ."','". limpa($cep) ."','". limpa($telefone) ."','". limpa($inscricao_estadual) ."','". limpa($inscricao_municipal) ."'";
			if ($estado != '') { $sql .= ",". limpa_int($estado); }
			if ($cidade != '') { $sql .= ",". limpa_int($cidade); }
			$sql .= ")";
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='empresas.php?sucesso=1';</script>";
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			
			$sql = "update empresas set empresa='". limpa($empresa) ."', email = '". limpa($email) ."', cnpj = '". limpa($cnpj) ."',".
			" endereco = '". limpa($endereco) ."', cep = '". limpa($cep) ."', telefone = '". limpa($telefone) ."', inscricao_estadual = '". limpa($inscricao_estadual) ."', inscricao_municipal = '". limpa($inscricao_municipal) ."'";
			if ($estado != '') { $sql .= ", estado = ". limpa_int($estado); }
			if ($cidade != '') { $sql .= ", cidade = ". limpa_int($cidade); }
			$sql .= " where cod_empresa = ".$_REQUEST['id'];
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='empresas.php?sucesso=2';</script>";
			
		}
		
	}
	
	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "alterar"){
			
			$acao = $_REQUEST['acao'];
		
			$sql = "
			select 		e.empresa, date_format(el.dt_inicio, '%d/%m/%Y') as dt_inicio, date_format(el.dt_vencimento, '%d/%m/%Y') as dt_vencimento, el.flg_situacao
						,el.valor, e.cod_empresa
			from 		empresas_licenca el
			inner join 	empresas e on e.cod_empresa = el.cod_empresa
			where 		el.cod_empresa_licenca = ".$_REQUEST['cod_empresa_licenca']."";

			$query = mysql_query($sql);
			$registros = mysql_num_rows($query);
			if ($registros > 0) {
				if ($rs = mysql_fetch_array($query)){
					$cod_empresa 	= $rs['cod_empresa'];
					$empresa		= $rs['empresa'];
					$dt_inicial 	= $rs['dt_inicio'];
					$dt_vencimento 	= $rs['dt_vencimento'];
					$flg_situacao 	= $rs['flg_situacao'];
					$valor 			= ValorMysqlPhp($rs['valor']);
					
				}
			}
		
		}
		
	}

}

/*
$cod_empresa = $_REQUEST['cod_empresa'];

$sql = "Select empresa from empresas where cod_empresa = " . $cod_empresa;
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
$rs = mysql_fetch_array($query);
$empresa = $rs['empresa'];
*/

	
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
<li class="active"><a href="empresas.php">Empresas</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Empresa</h1>
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
			<form action="empresa_info.php" class="form-horizontal row-border" name='frm' method="post">

              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="cod_empresa_licenca" value="<?php echo $_REQUEST['cod_empresa_licenca']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="nova_licenca">
              <?php } ?>		



				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Empresa</b></label>
					<div class="col-sm-6">
						<input type="text" class="form-control" value="<?php echo $empresa;?>" name="empresa" readOnly="true" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data da Contratação do Plano</b></label>
					<div class="col-sm-2">

						<input type="text" class="form-control mask" 
							id="dt_inicio" 
							name="dt_inicio" 
							data-inputmask-alias="dd/mm/yyyy" 
							data-inputmask="'alias': 'date'" 
							data-val="true" 
							data-val-required="Required" 
							placeholder="dd/mm/yyyy"
							value="<?php echo $dt_inicial; ?>"
							>

					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data do Vencimento do Plano</b></label>
					<div class="col-sm-2">

						<input type="text" class="form-control mask" 
							id="dt_vencimento" 
							name="dt_vencimento" 
							data-inputmask-alias="dd/mm/yyyy" 
							data-inputmask="'alias': 'date'" 
							data-val="true" 
							data-val-required="Required" 
							placeholder="dd/mm/yyyy"
							value="<?php echo $dt_vencimento; ?>"
							>

					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Situação do Plano</b></label>
					<div class="col-sm-2">
						<select name="flg_situacao" id="flg_situacao" class="form-control">

							<option value='A' <?php if ($flg_situacao == 'A') { echo " Selected "; } ?> > Ativo </option>

							<option value='I' <?php if ($flg_situacao == 'I') { echo " Selected "; } ?> > Inativo </option>

						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Valor do Plano</b></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" value="<?php echo $valor;?>" name="inscricao_estadual" maxlength="10" size="10"
						onKeyPress="return(moeda(this,'.',',',event));"
						>
					</div>
				</div>		
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Atualizar</button>						
						&nbsp;
						<button class="btn-default btn" onclick="javascript:window.location='empresa_licenca.php?cod_empresa=<?php echo $cod_empresa; ?>';">Voltar</button>
						
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
							</div>
<?php 
}
	
include('../include/rodape_interno.php');

?>