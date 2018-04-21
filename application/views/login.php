<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SIGE - Sistema de Gestão Educacional</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="icon" href="<?php echo base_url();?>assets/img/favicon.ico" />
	<link rel="stylesheet" href="<?= base_url("assets/css/login.css");?>">
	<link href="<?= base_url("assets/css/bootstrap.min.css");?>" rel="stylesheet">

<script type="text/javascript">

	function issetError(){ 

		 var erro = document.getElementById("error");
		if(typeof erro !=='undefined'){
			var error=document.querySelector('.erro');
			error.style.display = 'none';
			error.style.transition = "all .6s ease-in";
		}
	}
</script>

</head>
<body>
	<div class="container-fluid">

		<div class="container">
			<section class="left">
				<article>
					<!--LOGO-->
					<figure class="logos">
						<img src="assets/img/logo-s-j-p.jpg" title="" alt="" />
						<span class="separator"></span>
						<figcaption>Logo Avance | Logo São João dos Patos</figcaption>
						<img src="assets/img/logo_login.png" title="" alt="" />
					</figure>
					<!--FORMULÁRIO DE LOGIN-->
					<h1>Bem-vindo, <span>identifique-se!</span></h1>
					<?php 
						if(isset($_SESSION['error'])) : 
							echo'
							<div class="alert alert-danger col-md-10" role="alert">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								<span class="sr-only">Error:</span>
							 	'.$_SESSION['error'].'
							</div>';
							$this->session->sess_destroy();
						endif; 
					?>
					<form class="horizontal-form" action="login/autenticar" method="post" accept-charset="utf-8">
						<!--SELECT ACESSO-->						
						<div class="form-group">
							<select name="nivel" class="form-control">
								<option value="0">Escolha seu Acesso</option>
								<option value="aluno">Aluno</option>
								<option value="diretor">Diretor</option>
								<option value="professor">Professor</option>
								<option value="secretario">Secretario</option>
							</select>
						</div>
						<!--LOGIN | SENHA-->						
						<div class="form-group">
							<label class="login" for="login">
								<span class="icon-login"></span>
								<input type="text" name="login" class="form-control" id="login" placeholder="Usuário" />
							</label>

							<label class="senha" for="senha">
								<span class="icon-senha"></span>
								<input name="senha" type="password" class="form-control" id="senha" placeholder="Senha" />
							</label>
						</div>
						<!--BOTÃO-->
						<div class="form-group">
							<input type="submit" value="ENTRAR" />
						</div>
						<div class="form-group">
							
						</div>
						<!--OPÇÕES-->
						<div class="form-group" id="opcoes">
							<label for="salvar-dados">
								<input id="salvar-dados" type="checkbox" name="salvar_login">
								<span class="opcoes">Salvar dados</span>
							</label>
							<a href="#" title="Recuperar Senha">Esqueceu a senha?</a>
						</div>


					</form>

				</article>
			</section>
			<!--SECTION DIREITA-->
			<section class="right">
				<h1>PORTAL EDUCACIONAL</h1>
				<h3>Ajuda você a acompanhar seu desempenho</h3>
				<figure>
					<img src="assets/img/icon-boletim.png" title="Boletim Online" alt="Boletim Online" />
					<img src="assets/img/icon-controle-facil.png" title="Controle Facil de suas notas e atividades" alt="Controle Facil de suas notas e atividades" />
					<img src="assets/img/icon-intergracao-social.png" title="Integração Social" alt="Integração Social" />
					<figcaption>Icones portal</figcaption>
				</figure>
			</section>
		</div><!--CONTAINNER-->


	</div><!--CONTAINER FLUID-->
</body>
</html>