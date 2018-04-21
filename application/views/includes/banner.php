
<div class="col-md-11 col-xs-12  banner">
	<article class="banner-img">
		<figure>
			<img src="<?=base_url('assets/img/banner-bg.png');?>" class="banner_img" alt="portal do aluno" />
			<figcaption>SEJA BEM-VINDO<br /> 
			AO SEU PORTAL<br />
			<?php
				if($_SESSION['logged']['sigeUserNivel']=='d' OR $_SESSION['logged']['sigeUserNivel']=='s'){
					echo "DO GESTOR";
				}elseif($_SESSION['logged']['sigeUserNivel']=='p'){
					echo "DO PROFESSOR";
				}elseif($_SESSION['logged']['sigeUserNivel']=='a'){
					echo "DO ALUNO";
				}
			?> 
			</figcaption>
		</figure>
	</article>
</div><!--BANNER-->
