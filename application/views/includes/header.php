<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SIGE - Sistema de Gestão Educacional</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/estilo.css">
	<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<header>
		<div class="row">
			<nav class="col-md-3 col-xs-5 logo_sige">
				<a href="home">
					<img class="media-object" src="<?php echo base_url('assets/img/logo_avance.png');?>" alt="Logo Avance" title="Avance | Gestão Educacional" />
					</a>
			</nav>

<?php 
	//$nomeUser=explode(' ',$_SESSION['sigeUser']);
?>
		<nav class="col-md-9 col-sm-4 col-xs-4 text-right user_header">
			
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
			</nav>
		</div>

		</header>
