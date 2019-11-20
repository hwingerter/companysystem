<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Lista de Produtos</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Lista de Produtos</h1>
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
                <h2>Produtos</h2>
          	</div>


          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="100">Produto</th>
                            <th width="50">Tipo de Produto</th>
							<th width="20">Custo</th>
							<th width="20">Preço de Venda</th>
							<th width="20">Desconto Máximo</th>
							<th width="20">Desconto Promocional</th>
							<th width="20">Comissão</th>
							<th width="20">Desconta Custo das Comissões</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    
	//CARREGA LISTA
    $sql = "
    select 		s.descricao as produto, ts.descricao as tipo_produto, s.custo, s.preco_venda, s.desconto_maximo, s.desconto_promocional, s.cod_tipo_comissao
                ,case when s.cod_tipo_comissao = 1 then s.comissao_percentual else s.comissao_fixa end as comissao
                ,case when s.descontar_custo_produtos = 1 then 'Sim' else 'Nao' end as descontar_custo_produtos 
    from 		produtos s
    inner join	grupo_produtos ts on ts.cod_grupo_produto = s.cod_grupo_produto
    where 		s.cod_empresa = ".$_SESSION['cod_empresa']."
	order by	s.descricao asc;
	";
	
	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	if ($registros > 0) {

		while (($rs = mysql_fetch_array($query))){ 
	    	
		?>
                        <tr>
                            <td align="left"><?php echo $rs['produto'];?></td>
                            <td align="left"><?php echo $rs['tipo_produto'];?></td>
							<td align="left"><?php echo $rs['custo']; ?></td>
							<td align="left"><?php echo $rs['preco_venda']; ?></td>
							<td align="left"><?php echo $rs['desconto_maximo']; ?></td>
							<td align="left"><?php echo $rs['desconto_promocional']; ?></td>
                            <td align="left"><?php
                            
                            if (cod_tipo_comissao == 1) {
                                echo $rs['comissao']."%";    
                            }else{
                                echo "R$ ".$rs['comissao'];    
                            }
                            ?></td>						
							<td align="left"><?php echo $rs['descontar_custo_produtos']; ?></td>						
                        </tr>
    <?php
			
		} // while
	?>
                        <tr>
                            <td align="right" colspan="8"><b>Quantidade: <?php echo $registros; ?></b></td>
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