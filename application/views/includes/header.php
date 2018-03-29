<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Avance <?php if(isset($titulo)) : echo $titulo; endif;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/estilo.css">
	<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<header>
		<div class="row">
			<nav class="col-md-1 col-xs-3 logo_sige">
				<a href="<?=base_url('home');?>">
					<img class="media-object" src="<?php echo base_url('assets/img/logo_avance.png');?>" alt="Logo Avance" title="Avance | Gestão Educacional" />
					</a>
			</nav>

<?php
	$nomeUser=explode(' ',$_SESSION['usuario_logado']['nome']);
?>
<!--
			<ul>
				<li>
					<?php echo anchor('crud/cadastrar','Cadastrar');?>
				</li>					
				<li>
					<?php echo anchor('crud/listar','Listar');?>
				</li>					
				<li>
					<?php echo anchor('crud/atualizar','Editar');?>
				</li>					
				<li>
					<?php echo anchor('crud/excluir','Excluir');?>
				</li>				
			</ul>
	
	-->

			<nav class="col-md-9 col-sm-4 col-xs-4 text-right user_header">
				<ul>
						<?php 
							if($_SESSION['usuario_logado']['sigeUserNivel']=='a'){
						?>
							<li>
								<a href="<?= base_url('home');?>">Início</a>
							</li>					
							<li>
								<a href="<?= base_url('portalaluno');?>">Notas e Faltas</a>
							</li>					
							<li>
								<a href="<?= base_url('horarioAula');?>">Horário</a>
							</li>					
							<li>
								<a href="#">Avisos</a>
							</li>
						
						<?php
							}elseif($_SESSION['usuario_logado']['sigeUserNivel']=='d'){
								echo'
							<li>
								<a href="'.base_url("home").'">Início</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/professores").'">Professores</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/turmas").'">Turmas</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/alunos").'">Alunos</a>
							</li>						
							<li>
								<a href="'.base_url("gerenciar/horarios").'">Horários</a>
							</li>';

							}elseif($_SESSION['usuario_logado']['sigeUserNivel']=='p'){
								echo'
							<li>
								<a href="'.base_url("home").'">Início</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/notasefaltas").'">Notas e Faltas</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/quadroHorario").'">Horário de Aula</a>
							</li>';				
							}elseif($_SESSION['usuario_logado']['sigeUserNivel']=='s'){
							echo'
							<li>
								<a href="'.base_url("home").'">Início</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/escolas").'">Escolas</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/diretores").'">Diretores</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/professores").'">Professores</a>
							</li>						
							<li>
								<a href="'.base_url("gerenciar/alunos").'">Alunos</a>
							</li>';
						}
						?>
					</ul>

			<nav class="buttom-sair">
						<h6 class="hidden-xs"><span>Olá</span> <?php
						echo $nomeUser['0']; ?></h6>
						<form class="col-md-2 col-xs-10 form-horizontal" action="<?php echo base_url("login/logout");?>" method="post" accept-charset="utf-8">
						<input type="submit" value="SAIR"/>
						</form>	
					</nav>
			</nav>
		</div><!-- ROW -->
		<script type="text/javascript">
				function scrollx() {

					var windowWidth = window.innerWidth;
					var screenWidth = screen.width;

					var headerMenu = document.querySelector('.user_header');
					var headerMenuCollapsed = document.querySelector('.menu-mobile');

					var botao_sair = document.querySelector('.buttom-sair');

					if (windowWidth < 1025) {
						headerMenu.style.display = "none";
						headerMenu.style.transition = "all .6s ease-in";
						/******************/
						headerMenuCollapsed.style.display = "block";

						botao_sair.style.display = "none";

					}else{
						headerMenu.style.display =  "flex";
						headerMenuCollapsed.style.display = "none";
						botao_sair.style.display = "flex";	
					}
					}

			window.addEventListener('load', scrollx);
			window.addEventListener('resize', scrollx);
			function menuAction(status){
				var menu_items = document.querySelector('.menu-items');
				var action = document.getElementById('actionMenu');

				if(status == '1'){
					menu_items.style.display =  "block";
					action.setAttribute('onclick', 'menuAction(0)');
				}else{
					menu_items.style.display =  "none";

					action.setAttribute('onclick', 'menuAction(1)');
				}

			}
		</script>
		<div class="menu-mobile">
		<div class="actionMenu"  id="actionMenu" onclick="menuAction(1)">
			<span>Menu</span>
			<img src="<?= base_url('assets/img/icon-white.png');?>" title="icon-menu" alt="icon-menu" width="32">
		</div>
			<nav class="menu-items" id="menu-items">
				<ul>
					<img src="<?= base_url('assets/img/background_triangulo.png');?>" alt="icon_background" />
					<?php 
							if($_SESSION['usuario_logado']['sigeUserNivel']=='a'){
						?>
							<li>
								<a href="<?= base_url('home');?>">Início</a>
							</li>					
							<li>
								<a href="<?= base_url('portalaluno');?>">Notas e Faltas</a>
							</li>					
							<li>
								<a href="<?= base_url('horarioAula');?>">Horário</a>
							</li>					
							<li>
								<a href="#">Avisos</a>
							</li>
						
						<?php
							}elseif($_SESSION['usuario_logado']['sigeUserNivel']=='d'){
								echo'
							<li>
								<a href="'.base_url("home").'">Início</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/professores").'">Professores</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/turmas").'">Turmas</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/alunos").'">Alunos</a>
							</li>						
							<li>
								<a href="'.base_url("gerenciar/horarios").'">Horários</a>
							</li>';

							}elseif($_SESSION['usuario_logado']['sigeUserNivel']=='p'){
								echo'
							<li>
								<a href="'.base_url("home").'">Início</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/notasefaltas").'">Notas e Faltas</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/quadroHorario").'">Horário de Aula</a>
							</li>';				
							}elseif($_SESSION['usuario_logado']['sigeUserNivel']=='s'){
							echo'
							<li>
								<a href="'.base_url("home").'">Início</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/escolas").'">Escolas</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/diretores").'">Diretores</a>
							</li>					
							<li>
								<a href="'.base_url("gerenciar/professores").'">Professores</a>
							</li>						
							<li>
								<a href="'.base_url("gerenciar/alunos").'">Alunos</a>
							</li>';
						}
					?>
						<li>
							<a href="<?=base_url('login/logout');?>">Sair</a>
						</li>					
				</ul>
			</nav>
		</div>



		</header>
