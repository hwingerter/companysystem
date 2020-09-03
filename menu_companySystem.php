<?php

$usuario_nome 	= $_SESSION['usuario_nome'];
$tipo_conta		= $_SESSION['tipo_conta'];
$cod_empresa 	= $_SESSION['cod_empresa'];

$nome_empresa 	= $_SESSION['empresa'];
$perfil 		= $_SESSION['tipo_conta_descricao'];

$texto_bem_vindo = $nome_empresa."<br>".$usuario_nome."<br>".$perfil;

?>

<div class="static-sidebar-wrapper sidebar-midnightblue">
    <div class="static-sidebar">
        <div class="sidebar">
		    <div class="widget stay-on-collapse" id="widget-welcomebox">
		        <div class="widget-body welcome-box tabular">
		            <div class="tabular-row">
		                <div class="tabular-cell welcome-options">
		                    <span class="welcome-text"><?php echo $texto_bem_vindo;?></span>
		                </div>
		            </div>
		        </div>
		    </div>
			<div class="widget stay-on-collapse" id="widget-sidebar">
				<nav role="navigation" class="widget-body">
					<ul class="acc-menu">
						
						<li><a href="<?php echo sistema; ?>inicio.php"><span>Início</span></a></li>

						<?php
						if ($acesso_minha_empresa == 1) {
						?>
							<li><a href="javascript:;"><i class="fa fa-cog"></i><span>Administração</span></a>
								<ul class="acc-menu">
									<?php if ($menu_licencas == 1) { ?>
									<li><a href="<?php echo sistema; ?>licenca/licencas.php"><span>Licenças</span></a></li>
									<?php } ?>
									<?php if ($menu_tipo_conta == 1) { ?>
									<li><a href="<?php echo sistema; ?>tipo_conta/adm_perfil.php"><span>Tipo de Conta</span></a></li>
									<?php } ?>
									<?php if ($menu_credencial == 1) { ?>
									<li><a href="<?php echo sistema; ?>credenciais/credenciais.php"><span>Credenciais</span></a></li>
									<?php } ?>
									<?php if ($menu_usuarios == 1) { ?>
									<li><a href="<?php echo sistema; ?>gestao_usuarios/adm_usuarios.php"><span>Usuários</span></a></li>								
									<?php } ?>
									<?php if ($menu_minhas_preferencias == 1) { ?>
									<li><a href="<?php echo sistema; ?>preferencias/preferencias.php"><span>Minhas Preferências</span></a></li>
									<?php } ?>
								</ul>
							</li>
						<?php
						}
						if ($acesso_cadastros == 1) {
						?>

							<li><a href="javascript:;"><i class="fa fa-list"></i><span>Cadastros</span></a>
								<ul class="acc-menu">
									<?php if ($menu_empresas == 1) { ?>
									<li><a href="<?php echo sistema; ?>adm_empresa/empresas.php"><span>Empresas</span></a></li>
									<?php } ?>
									<?php if ($menu_clientes == 1) { ?>
									<li><a href="<?php echo sistema; ?>cliente/clientes.php"><span>Clientes</span></a></li>
									<?php } ?>
									<?php if ($menu_fornecedores == 1) { ?>
									<li><a href="<?php echo sistema; ?>fornecedor/fornecedores.php"><span>Fornecedores</span></a></li>
									<?php } ?>
									<?php if ($menu_grupo_produtos == 1) { ?>
									<li><a href="<?php echo sistema; ?>grupo_produtos/grupo_produtos.php"><span>Grupo de Produtos</span></a></li>
									<?php } ?>
									<?php if ($menu_produtos == 1) { ?>
									<li><a href="<?php echo sistema; ?>produto/produtos.php"><span>Produtos</span></a></li>
									<?php } ?>
									<?php if ($menu_profissional == 1) { ?>
									<li><a href="<?php echo sistema; ?>profissional/profissionais.php"><span>Profissional</span></a></li>
									<?php } ?>
									<?php if ($menu_tipo_servico == 1) { ?>
									<li><a href="<?php echo sistema; ?>tipo_servico/tipo_servicos.php"><span>Tipos de Serviço</span></a></li>
									<?php } ?>
									<?php if ($menu_servicos == 1) { ?>
									<li><a href="<?php echo sistema; ?>servicos/servicos.php"><span>Serviços</span></a></li>
									<?php } ?>
									<?php if ($menu_cartao == 1) { ?>
									<li><a href="<?php echo sistema; ?>cartao/cartao.php"><span>Cartão</span></a></li>
									<?php } ?>
								</ul>
							</li>	

						<?php
						}
						if ($acesso_agenda == 1) {

							$agenda_ver = 0;
							$agenda_reserva = 0;
							$agenda_relatorio = 0;

							for ($i=0; $i < count($credenciais); $i++) 
							{ 
								switch($credenciais[$i])
								{
									case "agenda_ver":
									$agenda_ver = 1;		
									break;
									case "agenda_localizar":
									$agenda_reserva = 1;		
									break;
									case "agenda_relatorio":
									$agenda_relatorio = 1;		
									break;
								}
							}

						?>
							<li><a href="javascript:;"><i class="fa fa-list"></i><span>Agenda</span></a>
								<ul class="acc-menu">
									<?php if ($agenda_ver == 1) { ?>
									<li><a href="<?php echo sistema; ?>agenda/agenda.php"><span>Reservar</span></a></li>
									<?php } ?>
									<?php if ($agenda_reserva == 1) { ?>
									<li><a href="<?php echo sistema; ?>agenda/localizar_reserva.php"><span>Localizar Reserva</span></a></li>
									<?php } ?>
									<?php if ($agenda_relatorio == 1) { ?>
									<li><a href="<?php echo sistema; ?>agenda/agendamentos.php"><span>Relatório de Agendamentos</span></a></li>
									<?php } ?>
								</ul>
							</li>	

						<?php
						}
						if ($acesso_caixa == 1) {
						?>

							<li><a href="javascript:;"><i class="fa fa-money"></i><span>Caixa</span></a>
								<ul class="acc-menu">
									<li><a href="<?php echo sistema; ?>caixa/caixa_gaveta_caixa.php"><span>Gaveta do Caixa</span></a></li>
								</ul>
							</li>

						<?php
						}
						if ($acesso_vendas == 1) {
						?>

							<li><a href="javascript:;"><i class="fa fa-money"></i><span>Vendas</span></a>
								<ul class="acc-menu">
									<li><a href="<?php echo sistema; ?>comanda/comanda.php"><span>Comandas</span></a></li>
									<li><a href="<?php echo sistema; ?>comanda/comanda_historico_vendas.php"><span>Histórico de Vendas</span></a></li>
									<li><a href="<?php echo sistema; ?>comanda/comanda_historico_itens_vendidos.php"><span>Histórico de Itens Vendidos</span></a></li>
								</ul>
							</li>

						<?php
						}
						if ($acesso_financeiro == 1) {
						?>

							<li><a href="javascript:;"><i class="fa fa-money"></i><span>Financeiro</span></a>
								<ul class="acc-menu">
									<li><a href="<?php echo sistema; ?>financeiro/conta.php"><span>Contas e Despesas</span></a></li>
									<li><a href="<?php echo sistema; ?>financeiro/credito_clientes.php"><span>Créditos dos Clientes</span></a></li>
									<li><a href="<?php echo sistema; ?>adm_usuarios.php"><span>Contas e Receitas</span></a></li>
									<li><a href="<?php echo sistema; ?>financeiro/contas_receber_filtro.php">Contas a Receber</a></li>
									<li><a href="<?php echo sistema; ?>adm_usuarios.php"><span>Receber Dívidas</span></a></li>
									<li><a href="<?php echo sistema; ?>financeiro/controle_cheques_recebidos_filtro.php">Cheques Recebidos</a></li>
									<li><a href="<?php echo sistema; ?>fluxo_caixa.php"><span>Fluxo de Caixa</span></a></li>
									<li><a href="<?php echo sistema; ?>fluxo_caixa.php"><span>Extrato de Cartões</span></a></li>
									<li><a href="<?php echo sistema; ?>fluxo_caixa.php"><span>Recebimento de Clientes</span></a></li>
								</ul>
							</li>

						<?php
						}
						if ($acesso_salarios_comissoes == 1) {
						?>

							<li><a href="javascript:;"><i class="fa fa-money"></i><span>Salários e Comissões</span></a>
								<ul class="acc-menu">
									<li><a href="<?php echo sistema; ?>salarios_comissoes/profissionais.php"><span>Salários, Décimo e Férias</span></a></li>
									<li><a href="<?php echo sistema; ?>salarios_comissoes/comissoes.php"><span>Personalizar Comissões</span></a></li>
									<li><a href="<?php echo sistema; ?>salarios_comissoes/listar_pagamento_comissoes.php"><span>Pagar Profissionais</span></a></li>
									<li><a href="<?php echo sistema; ?>salarios_comissoes/pagamentos_realizados.php"><span>Pagamentos Realizados</span></a></li>
								</ul>
							</li>

						<?php
						}
						if ($acesso_estoque == 1) {
						?>

							<li><a href="javascript:;"><i class="fa fa-money"></i><span>Estoque</span></a>
								<ul class="acc-menu">
									<li><a href="<?php echo sistema; ?>estoque/estoque_atual.php"><span>Estoque Atual</span></a></li>
									<li><a href="<?php echo sistema; ?>tipo_movimentacao/tipo_movimentacao.php"><span>Tipos de Movimentação</span></a></li>
									<li><a href="<?php echo sistema; ?>estoque/lancar_compra.php"><span>Compra/Movimentação</span></a></li>
								</ul>
							</li>

						<?php
						}
						if ($acesso_relatorio == 1) {
						?>

							<li><a href="javascript:;"><i class="fa fa-money"></i>Relatórios</a>
								<ul class="acc-menu">
									<li><a href="javascript:;">De Clientes</a>
										<ul class="acc-menu">
											<li><a href="<?php echo sistema; ?>relatorios/clientes/lista_clientes.php">Lista de Clientes</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/clientes/credito_clientes.php">Crédito dos Clientes</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/clientes/lista_clientes_aniversariantes.php">Aniversariantes</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/clientes/clientes_mais_lucro.php">Clientes que dão mais lucro</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/clientes/lista_clientes_emails.php">Lista de E-mails</a></li>
										</ul>
									</li>
									<li><a href="javascript:;">De Profissionais</a>
										<ul class="acc-menu">
											<li><a href="<?php echo sistema; ?>relatorios/profissionais/valores_pagar.php">Valores a Pagar</a></li>
											<li><a href="<?php echo sistema; ?>salarios_comissoes/pagamentos_realizados.php"><span>Pagamentos Realizados</span></a></li>
											<li><a href="<?php echo sistema; ?>relatorios/profissionais/relatorio_comissao_filtro.php">Relatório de Comissões</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/profissionais/vales.php">Relatório de Vales</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/clientes/lista_clientes_emails.php">Lista de E-mails</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/profissionais/profisssional_mais_lucro_servico.php">Geram mais lucro (serviços)</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/profissionais/profisssional_mais_lucro_produto.php">Geram mais lucro (produtos)</a></li>
										</ul>
									</li>
									<li><a href="javascript:;">De Cadastros</a>
										<ul class="acc-menu">
											<li><a href="<?php echo sistema; ?>relatorios/cadastros/lista_clientes.php">Lista de Clientes</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/cadastros/lista_profissionais.php">Lista de Profissionais</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/cadastros/lista_servicos.php">Lista de Serviços</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/cadastros/lista_produtos.php">Lista de Produtos</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/cadastros/lista_fornecedores.php">Lista de Fornecedores</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/cadastros/lista_cartoes.php">Lista de Cartões</a></li>
										</ul>
									</li>
									<li><a href="javascript:;">Financeiros</a>
										<ul class="acc-menu">
										<li><a href="<?php echo sistema; ?>relatorios/financeiro/contas_e_despesas_filtro.php">Contas e Despesas</a></li>
										<li><a href="<?php echo sistema; ?>relatorios/clientes/credito_clientes.php">Crédito dos Clientes</a></li>
										<li><a href="<?php echo sistema; ?>relatorios/financeiro/contas_receber_filtro.php">Dívidas dos Clientes</a></li>
										<li><a href="<?php echo sistema; ?>relatorios/financeiro/recebimento_clientes_filtro.php">Recebimento de Clientes</a></li>
										<li><a href="<?php echo sistema; ?>financeiro/controle_cheques_recebidos_filtro.php">Cheques Recebidos</a></li>
										<li><a href="<?php echo sistema; ?>relatorios/financeiro/extrato_cartoes_filtro.php">Extrato de Cartões</a></li>
										</ul>
									</li>
									<li><a href="javascript:;">De Vendas</a>
										<ul class="acc-menu">
											<li><a href="<?php echo sistema; ?>relatorios/vendas/historico_vendas.php">Histórico de Vendas</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/vendas/historico_itens_vendidos.php">Histórico de Itens Vendidos</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/vendas/clientes_ausentes_salao_dias_filtro.php">Clientes Ausentes x dias</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/vendas/clientes_nao_fazem_servico_dias_filtro.php">Clientes Não Repetiram Serviço x dias</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/profissionais/profisssional_mais_lucro_servico.php">Geram mais lucro (serviços)</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/profissionais/profisssional_mais_lucro_produto.php">Geram mais lucro (produtos)</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/vendas/servicos_mais_lucrativos_filtro.php">Serviços mais lucrativos</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/vendas/produtos_mais_lucrativos.php">Produtos mais lucrativos</a></li>
										</ul>
									</li>
									<li><a href="javascript:;">De Lucros</a>
										<ul class="acc-menu">
											<li><a href="<?php echo sistema; ?>relatorios/lucros/lucro_bruto_filtro.php">Lucro Bruto</a></li>
										</ul>
									</li>
									<li><a href="javascript:;">Da Gaveta do Caixa</a>
										<ul class="acc-menu">
											<li><a href="<?php echo sistema; ?>relatorios/caixa/visualizar_caixas_fechados.php">Caixas Fechados</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/caixa/sangrias.php">Relatório de sangrias</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/profissionais/vales.php">Relatório de Vales</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/caixa/reforco.php">Relatório de Reforço</a></li>
										</ul>
									</li>
									<li><a href="javascript:;">De Estoque</a>
										<ul class="acc-menu">
											<li><a href="<?php echo sistema; ?>relatorios/estoque/estoque_atual.php">Estoque Atual</a></li>
											<li><a href="<?php echo sistema; ?>relatorios/estoque/extrato_seleciona_produto.php">Extrato de Estoque</a></li>
										</ul>
								</ul>
							</li>

						<?php 
						}
						?>
					
					
							<li><a href="<?php echo sistema; ?>logout.php"><i class="fa fa-sign-out"></i><span>Sair</span></a></li>

						</ul>

						</nav>
				    </div>
				</div>
		    </div>
</div>