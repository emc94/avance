
<div class="col-md-11 col-xs-12  banner">
	<article class="banner-img">
		<figure>
			<img src="<?=base_url('assets/img/banner-bg.png');?>" class="banner_img" alt="portal do aluno" />
			<figcaption>SEJA BEM-VINDO<br /> 
			AO SEU PORTAL<br />
			<?php
				if($_SESSION['usuario_logado']['sigeUserNivel']=='d' OR $_SESSION['usuario_logado']['sigeUserNivel']=='s'){
					echo "DO GESTOR";
				}elseif($_SESSION['usuario_logado']['sigeUserNivel']=='p'){
					echo "DO PROFESSOR";
				}elseif($_SESSION['usuario_logado']['sigeUserNivel']=='a'){
					echo "DO ALUNO";
				}
			?> 
			</figcaption>
		</figure>
	</article>
</div><!--BANNER-->
