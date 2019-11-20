
<?php
$tipo_conta = str_replace('-', '<br>', $_SESSION['tipo_conta']);
?>

<div class="static-sidebar-wrapper sidebar-midnightblue">
    <div class="static-sidebar">
        <div class="sidebar">
		    <div class="widget stay-on-collapse" id="widget-welcomebox">
		        <div class="widget-body welcome-box tabular">
		            <div class="tabular-row">
		                <div class="tabular-cell welcome-options">
		                    <span class="welcome-text">Bem vindo(a),</span>
		                    <a href="minha_conta.php" class="name">Fulano de Tal</a>
		                    <span>Assistente Administrativo</span>
		                </div>
		            </div>
		        </div>
		    </div>
			<div class="widget stay-on-collapse" id="widget-sidebar">
				<nav role="navigation" class="widget-body">
					<ul class="acc-menu">
						<li class="nav-separator">Menu</li>
						<li><a href="<?php echo host; ?>/inicio.php"><i class="fa fa-home"></i><span>Home</span></a></li>

				  			<?php

							  //if ($_SESSION['usuario_conta'] == '1') {
							  		
							  ?>		
							  <li><a href="javascript:;"><i class="fa fa-cogs"></i><span>Programas</span></a>
								<ul class="acc-menu">
								<li><a href="<?php echo host; ?>academiaon/programa.php"><span>Últimos Programas</span></a></li>
								<li><a href="<?php echo host; ?>empresa/empresas.php"><span>Programas Pendentes</span></a></li>
								<li><a href="<?php echo host; ?>tipo_conta/adm_perfil.php"><span>Programas Concluídos</span></a></li>
								<li><a href="<?php echo host; ?>licenca/licencas.php"><span>Programas Contratados</span></a></li>
								<li><a href="<?php echo host; ?>grupos_empresas/grupos.php"><span>Favoritos</span></a></li>
								</ul>
							  </li>
							  <?php
							  //}
							  
							  //if ($_SESSION['cod_empresa'] != '') { // Para ver os menu abaixo e obrigatorio escolher uma empresa.
							  ?>
							<li><a href="javascript:;"><i class="fa fa-users"></i><span>Profissionais</span></a>
							<ul class="acc-menu">									  
								<li><a href="<?php echo host; ?>usuarios/usuarios.php"><span>Novos Profissionais</span></a></li>
								<li><a href="<?php echo host; ?>preferencias/preferencias.php"><span>Profissionais Contratados</span></a></li>
								<li><a href="<?php echo host; ?>preferencias/preferencias.php"><span>Favoritos</span></a></li>

							  <?php
							  for ($i = 0; $i <= $totalcredencial-1; $i++) {
								if ($credenciais[$i] == 'credencial_ver') {
							  ?>										
								<li><a href="<?php echo host; ?>credenciais/credenciais.php"><span>Credenciais</span></a></li>
							  <?php
							  		break;
							  	}
							  }
								?>
							  </ul>
							</li>
							<li><a href="javascript:;"><i class="fa fa-list"></i><span>Minhas Avaliações</span></a>
								<ul class="acc-menu">
									<li><a href="<?php echo host; ?>empresa/empresas.php"><span>Última Avaliação</span></a></li>
									<li><a href="<?php echo host; ?>empresa/empresas.php"><span>Avaliação Por Profissional</span></a></li>
									<li><a href="<?php echo host; ?>empresa/empresas.php"><span>Hitórico</span></a></li>								  								
								</ul>
							</li>					
							<li><a href="javascript:;"><i class="fa fa-folder-open"></i><span>Meus Documentos</span></a>
								<ul class="acc-menu">
									<li><a href="<?php echo host; ?>empresa/empresas.php"><span>Exames</span></a></li>
									<li><a href="<?php echo host; ?>empresa/empresas.php"><span>Protuários</span></a></li>
									<li><a href="<?php echo host; ?>empresa/empresas.php"><span>Ficha de Anamnese</span></a></li>								  								
								</ul>
							</li>					

							<li><a href="javascript:;"><i class="fa fa-calendar"></i><span>Agendamentos</span></a>
								<ul class="acc-menu">
									<li><a href="<?php echo host; ?>agenda/agenda.php"><span>Agendar</span></a></li>
									<li><a href="<?php echo host; ?>agenda/localizar_reserva.php"><span>Localizar Consulta</span></a></li>
									<li><a href="<?php echo host; ?>agenda/agendamentos.php"><span>Últimas Consultas Realizadas</span></a></li>
								</ul>
							</li>				  

								<li><a href="<?php echo host; ?>logout.php"><i class="fa fa-sign-out"></i><span>Sair</span></a></li>

							</ul>
						</nav>
				    </div>
				</div>
		    </div>
</div>