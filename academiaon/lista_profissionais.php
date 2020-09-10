<?php 

	include('../include/topo_interno2.php');
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fornecedor_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fornecedor_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fornecedor_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fornecedor_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if ($excluir != '') {
		$sql = "delete from fornecedores where cod_fornecedor = ". $excluir;
		mysql_query($sql);
		
		$excluir = '1';
	}
	
	//FUN��O QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	$sql = "Select COUNT(cod_fornecedor) as total from fornecedores  ";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " where empresa like '%".$_REQUEST['nome']."%' ";
			}
		}
	}	
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)) {
			$totalregistro = $rs['total'];
		}
	}
	
	
  	// Calcula a quantidade de paginas
	$registrosPagina = 30; // Define a quantidade de registro por Paginas
	$paginas = $totalregistro / $registrosPagina; // Calcula o total de paginas
	$resto = $totalregistro % $registrosPagina; // Pega o resto da divis�o
	$paginas = intval($paginas); // Converte o resultado para inteiro
	if ($resto > 0) { $paginas = $paginas + 1; } // Se o resto maior do que 0, soma a var paginas para a pagina��o ficar correta
	
	if (isset($_REQUEST['pagina'])) {
		$pagina = $_REQUEST['pagina']; // recupera a pagina
	} else { // Primeira pagina
		$pagina = 1;
	}
	
   $inicio = ( $pagina - 1 ) * $registrosPagina; //Defini o inicio da lista
   $final = $registrosPagina + $inicio; //Define o final da lista
   $contador = 0; //Seta variavel de Contador
   
   // Converte para inteiro
   $pagina = intval($pagina);	

   $cod_grupo = $_SESSION['cod_grupo'];
   $cod_empresa = $_SESSION['cod_empresa'];

}
	
?>
                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">						
                            <div class="page-heading">            
                                <h1>Profissionais</h1>
                            </div>
                            <div class="container-fluid">

<form action="fornecedores.php" class="form-horizontal row-border" name='frm' method="post">
	<input type='hidden' name='acao' value='buscar'>
<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-sky">
            <div class="panel-heading">
                <h2>Profissionais</h2>
          </div>
          <div class="panel-body">
            <div class="table-vertical">
                <table class="table table-striped">
                    <thead>
                        <tr>
							<th width="200">Nome</th>
							<th width="200">Contato</th>
                        </tr>
                    </thead>
                    <tbody>
						<tr>
							<td data-title="Título" align="left">Vinícius Possebon</td>
							<td data-title="Data" align="left">(21)9996-0656</td>
						</tr>	
						<tr>
							<td data-title="Título" align="left">Carol Borba</td>
							<td data-title="Data" align="left">(21)9889-0556</td>
						</tr>	
						<tr>
							<td data-title="Título" align="left">Sérgio Bertoluci - Xtreme 21</td>
							<td data-title="Data" align="left">(21)7896-0656</td>
						</tr>	
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
</div>
</form>
                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->

<?php

	
	include('../include/rodape_interno.php');

?>