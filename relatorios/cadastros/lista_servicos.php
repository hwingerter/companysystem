<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Lista de Serviços</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Lista de Serviços</h1>
                    </div>
                    <div class="container-fluid">						


		<div class="row">
			<div class="col-sm-8">
				<button class="btn-primary btn" onclick="window.print();">Imprimir</button>
			</div>
		</div>

		<br>

        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Serviços</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="100">Serviço</th>
                            <th width="50">Tipo de Serviço</th>
							<th width="20">Custo com Produtos</th>
							<th width="20">Preço de Venda</th>
							<th width="20">Desconto Máximo</th>
							<th width="20">Desconto Promocional</th>
							<th width="20">Duração Aproximada</th>
							<th width="20">Comissão</th>
							<th width="20">Desconta Custo das Comissões</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    
	//CARREGA LISTA
    $sql = "
    select 		s.nome, ts.descricao, s.custo_produtos, s.preco_venda, s.desconto_maximo, s.desconto_promocional, s.duracao_aproximada
                ,ifnull(s.comissao_fixa, s.comissao_percentual) as comissao 
                ,case when s.descontar_custo_produtos = 1 then 'Sim' else 'Não' end as descontar_custo_produtos 
    from 		servico s
    inner join	tipo_servico ts on ts.cod_tipo_servico = s.cod_tipo_servico
    where 		s.cod_empresa = ".$_SESSION['cod_empresa']."
	order by	s.nome asc;
	";
	
	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){ 
	    	
		?>
                        <tr>
                            <td align="left"><?php echo $rs['nome'];?></td>
                            <td align="left"><?php echo $rs['descricao'];?></td>
							<td align="left"><?php echo $rs['custo_produtos']; ?></td>
							<td align="left"><?php echo $rs['preco_venda']; ?></td>
							<td align="left"><?php echo $rs['desconto_maximo']; ?></td>
							<td align="left"><?php echo $rs['desconto_promocional']; ?></td>
							<td align="left"><?php echo $rs['duracao_aproximada']; ?></td>							
							<td align="left"><?php echo $rs['comissao']; ?></td>						
							<td align="left"><?php echo $rs['descontar_custo_produtos']; ?></td>						
                        </tr>
    <?php
			
		} // while
	?>
                        <tr>
                            <td align="right" colspan="9"><b>Quantidade: <?php echo $registros; ?></b></td>
                        </tr>
<?php
	} else { // registro
	?>
                        <tr>
                            <td align="center" colspan="7">Nenhum registro encontrado!</td>
                        </tr>
<?php
	}
?>		
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
</div>

    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->

<?php include('../../include/rodape_interno_relatorio.php'); ?>