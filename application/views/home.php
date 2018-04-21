<?php $this->load->view("includes/banner");?>

<div class="col-md-11 col-xs-12 interface">
				<nav class=""><!--Painel de Funçoes-->
<!--FUNÇOES SECRETARIO-->
			<?php
				if($_SESSION['logged']['sigeUserNivel']=='s'){
			?>
					<ul>
						<li>
							<a href="<?= base_url('gerenciar/escolas');?>">
							<h6>Gerenciar</h6>
								<h3>Escolas</h3>	
							</a>
						</li>
						<li>
							<a href="<?= base_url('gerenciar/diretores') ;?>">
								<h6>Gerenciar</h6>
								<h3>Diretores</h3>	
							</a>
						</li>								
						<li>
							<a href="<?= base_url('gerenciar/professores') ;?>">
								<h6>Gerenciar</h6>	
								<h3>Professores</h3>
							</a>
						</li>
						<li>
							<a href="<?= base_url('gerenciar/alunos');?>">
								<h6>Gerenciar</h6>	
								<h3>Alunos</h3>	
							</a>
						</li>											
						<li>
							<a href="<?= base_url('gerenciar/avisos');?>">
							<h6>Gerenciar</h6>
								<h3>Avisos</h3>	
							</a>
						</li>						
					</ul>

<!--SECRETARIO-->

<!--FUNÇOES DIRETORES-->

			<?php

				}elseif($_SESSION['logged']['sigeUserNivel']=='d'){
			?>

					<ul>
						<li>
							<a href="<?= base_url('gerenciar/professores') ;?>">
							<h6>Gerenciar</h6>
								<h3>Professores</h3>	
							</a>
						</li>							
						<li>
							<a href="<?= base_url('gerenciar/turmas') ;?>">
							<h6>Gerenciar</h6>	
								<h3>Turmas</h3>
							</a>
						</li>
						<li>
							<a href="<?= base_url('gerenciar/alunos') ;?>">
								<h6>Gerenciar</h6>	
								<h3>Alunos</h3>	
							</a>
						</li>					
						<li>
							<a href="<?= base_url('gerenciar/horarios');?>">
							<h6>Gerenciar</h6>
								<h3>Horários</h3>	
							</a>
						</li>						
						<li>
							<a href="<?= base_url('gerenciar/avisos');?>">
							<h6>Gerenciar</h6>
								<h3>Avisos</h3>	
							</a>
						</li>						
						<li>
							<a href="<?= base_url('gerenciar/declaracao');?>">
								<h3>Declaração</h3>	
							</a>
						</li>
					</ul>
<!--DIRETORES-->
			<?php
				}elseif($_SESSION['logged']['sigeUserNivel']=='p'){
			?>
<!--FUNÇOES PROFESSORES-->
					<ul>
						<li>
							<a href="<?= base_url('gerenciar/notasefaltas');?>">
							<h3>Cadastrar</h3>
								<h6>Notas e Frequência</h6>	
							</a>
						</li>						
						<li>
							<a href="<?= base_url('quadroHorario');?>">
							<h3>Horário</h3>
								<h6>de aula</h6>	
							</a>
						</li>						
						<li>
							<a href="#">
							<h6>Quadro de</h6>
								<h3>Avisos</h3>	
							</a>
						</li>												
						<li>
							<a href="#">
							<h3>Biblioteca</h3>
								<h6>Virtual</h6>	
							</a>
						</li>						
					</ul>
<!--PROFESSORES-->
			<?php
				}elseif($_SESSION['logged']['sigeUserNivel']=='a'){
			?>
<!--FUNÇOES ALUNOS-->
					<ul>
						<li>
							<a href="<?= base_url('portalaluno');?>">
							<h6>Consultar</h6>
								<h3>Notas e Faltas</h3>	
							</a>
						</li>						
						<li>
							<a href="<?= base_url('horarioAula');?>">
							<h3>Horário</h3>
								<h6>de aula</h6>	
							</a>
						</li>						
						<li>
							<a href="#">
							<h6>Quadro de</h6>
								<h3>Avisos</h3>	
							</a>
						</li>										
						<li>
							<a href="#">
								<h3>Biblioteca</h3>
							</a>
						</li>
						<li>
							<a href="#">
								<h3>Simulados</h3>	
							</a>
						</li>
						<li>
							<a href="#">
								<h3>Declaração</h3>	
							</a>
						</li>	
						<li>
							<a href="#">
							<h3>Jogos</h3>
								<h6>Educativos</h6>	
							</a>
						</li>
						<li>
							<a href="#">
								<h3>Vídeos</h3>	
								<h6>Educativos<h6>
							</a>
						</li>								
					</ul>
<!--Alunos-->
			<?php
				}else{
						redirect('login');
				}
			?>

				</nav><!-- Painel de Funçoes-->
			</div><!-- Interface -->


