<?php include('../../include/topo_interno_relatorio.php'); ?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
                    <ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="conta.php">Extrato do Estoque</a></li>
                    </ol>
					
                    <div class="page-heading">            
                        <h1>Extrato do Estoque</h1>
                    </div>
                    <div class="container-fluid">						

        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Extrato do Estoque</h2>
          	</div>

          <div class="panel-body">
            <div class="table-responsive">

                    <div class="form-group">
                        <div class="col-sm-1">
                            <label class="control-label"><b>Produto</b></label>
                        </div>

                        <form name="frm" action="extrato_estoque.php" method="post">

                        <div class="col-md-4">
                                <?php 
                                $sql = "select cod_produto, descricao from produtos where cod_empresa = ".$_SESSION['cod_empresa']." order by descricao asc; ";

                                $query = mysql_query($sql);
                                ?>

                                <select name='cod_produto' class="form-control">
                                    
                                    <option value="">Selecione...</option>

                                    <?php 

                                    while ($rs = mysql_fetch_array($query)){

                                        ?>
                                        <option value="<?php echo $rs['cod_produto']; ?>"

                                            <?php if($_REQUEST['cod_produto'] == $rs['cod_produto']) echo " selected "; ?>
                                            ><?php echo $rs['descricao']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="col-sm-2">
                                <button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
                            </div>										

                        </form>

                        </div>

                    </div>


            </div>
          </div>
        </div>
    </div>
</div>

    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->

<?php include('../../include/rodape_interno_relatorio.php'); ?>