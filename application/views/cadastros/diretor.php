<?php
   $this->load->view("includes/funcoes.php"); 
     scripts();
?>

<div class="container">
	<form id="form_cad" action="<?= base_url('cadastrar/cadastrarDiretor');?>" method="post" class="form-horizontal form_cad" enctype="multipart/form-data">

		<h3>Formulário de Cadastro / Diretor</h3>
		<fieldset class="legenda">
		<!-- ERROS DE VALIDAÇÃO -->
		<div id="erros" class="alert alert-danger campoErros" role="alert">
		</div>

		<!-- DADOS DA ESCOLA -->

		<div class="row">
			<div class="col-md-6 col-sm-3">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="escola">Escola</label>
					</span>
				<div class="controls">
					<select name="escola" class="form-control selectwidth" id="escola" required>
						<option value="0">Selecione a Escola</option>
						<?php listarEscolaCadDiretor(); ?>
					</select>
				</div>
				</div><!-- GRUPO codigo escola -->
			</div>
		</div>
		
		<!-- *************************** DADOS PESSOAIS *********************************** -->
		<legend>Dados Pessoais</legend>
		<!-- DADOS PESSOAIS -->

		<div class="row">

		<div class="col-xs-12 col-md-6">
		<div class="input-group">
		<span class="input-group-addon">
		<label for="nome">Nome</label>
		</span>
		<div class="controls">
			<input type="text" id="nome" name="nome" placeholder="Nome completo do profissional escolar" class="form-control inputwidth"  required/>
		</div>
		</div>
		</div>

		<div class="col-xs-12 col-md-6">
		<div class="input-group">
		<span class="input-group-addon">
		<label for="cpf">CPF</label>
		</span>
		<div class="controls">
		<input type="text" id="cpf" name="cpf" placeholder="Número do Cadastro de Pessoa Física" class="form-control inputwidth" onkeypress="mascarar(this,'cpf')" required/>
		</div>
		</div>
		</div>

		</div><!-- row nome cpf -->

		<div class="row">
		<div class="col-xs-12 col-md-5">
		<div class="input-group">
		<span class="input-group-addon">
		<label class="control-label" for="data_nascimento">Data de Nascimento</label>
		</span>
		<div class="controls">
			<input type="date" id="data_nascimento" name="datanascimento" class="form-control dateinput" required/>
		</div>
		</div>
		</div>

		<div class="col-xs-12 col-md-3">
		<div class="input-group">
		<div class="controls groupsmall">
			<label class="col-md-2 col-xs-12 control-label">Sexo</label>
			<label class="checkbox-inline"><input type="radio" name="sexo" id="m" value="m">Masculino</label>
			<label class="checkbox-inline"><input type="radio" name="sexo" id="f" value="f">Feminino</label>
		</div>
		</div>
		</div>
		</div><!-- row email data nascimento sexo -->

		<div class="row col-md-10 col-sm-5 col-xs-11">
		<label for="cor" class="control-label">Cor / Raça</label>
		<div class="row">
		<div class="checkbox col-md-12 col-xs-7">
		<label>
		<input type="radio" id="br" name="cor" value="branca" /> Branca</label>
		<label>
		<input type="radio" id="pr" name="cor" value="preta" /> Preta</label>
		<label>
		<input type="radio" id="par" name="cor" value="parda" /> Parda</label>
		<label>
		<input type="radio" id="a" name="cor" value="amarela" /> Amarela</label>
		<label>
		<input type="radio" id="i" name="cor" value="indígena" /> Indígena</label>
		<label>
		<input type="radio" id="nd" name="cor" value="não declarada" /> Não declarada</label>
		</div>
		</div>
		</div> <!-- row cor raça -->

		</fieldset>

		<fieldset class="legenda">

		<legend>Situação Contratual</legend>

		<div class="row">
		<div class="col-md-6 col-xs-12">
		<div class="input-group">
		<span class="input-group-addon">
		<label for="situacao">Vínculo</label>
		</span>
		<div class="controls">
		<select name="situacaocontrato" id="situacao" class="form-control selectwidth" required>
		<option value="0">Tipo de Vínculo</option>
		<?php listarContrato_vinculo();?>
		</select>
		</div>
		</div><!-- GRUPO -->
		</div>
		</div>
		</fieldset>

		<!-- ************************ INFORMACOES DO PROFISSIONAIS ********************** -->
		<fieldset class="legenda">
		<legend >Formação Profissional</legend>

		<div class="row">
		<div class="col-md-4 col-xs-12">
		<div class="input-group">
		<label class="control-label">Curso Superior</label>
		<label class="checkbox-inline">
			<input type="radio" name="cursosuperior" value="sim" onclick="habilitarCampo('areadocurso',this.value)"/>  <p class="checkinline">Sim</p></label>
		</label>
		<label class="checkbox-inline">
			<input type="radio" name="cursosuperior" value="não" onclick="habilitarCampo('areadocurso',this.value)" />  <p class="checkinline">Não</p>
		</label>
		</div><!-- GRUPO -->
		</div>
		
		<div class="col-md-8 col-xs-12">
		<div class="input-group">
		<span class="input-group-addon">
		<label for="areadocurso">Área do Curso</label>
		</span>
		<div class="controls">
		<select name="areadocurso" id="areadocurso" class="form-control selectwidth" disabled>
		<option value="0">Área do Curso Superior</option>
		<?php listarAreaCurso();?>
		</select>
		</div>
		</div><!-- GRUPO -->
		</div>
		</div><!-- row curso superior area de curso -->

		<div class="row">
		<div class="col-md-12 col-xs-12">
		<div class="input-group">
		<div class="controls">
		<label class="control-label">Complementação Pedagógica</label>
		</div>
		<div class="controls">
		<label class="checkbox-inline">
			<input type="radio" name="formacaopedagogica" value="sim" />  <p class="checkinline">Sim</p></label>
		</label>
		<label class="checkbox-inline">
			<input type="radio" name="formacaopedagogica" value="não" />  <p class="checkinline">Não</p></label>
		</div>
		</div><!-- GRUPO -->
		</div>

		</div>


		<div class="row">
		<div class="col-md-4 col-xs-12">
		<div class="input-group">
		<label  class="control-label">Pós-Graduação</label>

		<label class="checkbox-inline">
		<input type="radio" name="posgraduacao" value="sim" onclick="habilitarCampo('tipopos',this.value)"/>  <p class="checkinline">Sim</p></label>
		</label>
		<label class="checkbox-inline">
		<input type="radio" name="posgraduacao" value="não" onclick="habilitarCampo('tipopos',this.value)"/>  <p class="checkinline">Não</p></label>
		</div><!-- GRUPO -->
		</div>

		<div class="col-md-8 col-xs-12">
		<div class="input-group">
		<span class="input-group-addon">
		<label for="tipopos">Tipo Pós</label>
		</span>
		<div class="controls">
		<select name="tipopos" id="tipopos" class="form-control selectwidth" disabled>
		<option value="0">Tipo de Pós Graduação</option>
		<?php listarTipoPos();?>
		</select>
		</div>
		</div><!-- GRUPO -->
		</div>
		</div>

		<div class="row">
		<div class="col-md-6 col-xs-12">
		<div class="input-group">
		<span class="input-group-addon">
		<label for="outroscursos">Outros Cursos</label>
		</span>
		<div class="controls">
		<select name="outroscursos" id="outroscursos" class="form-control selectwidth">
		<option value="0">Outros Cursos</option>
		<?php listarOutrosCursos();?>
		</select>
		</div>
		</div><!-- GRUPO -->
		</div>
		</div><!-- outros cursos  -->
		</fieldset>

		<?php enderecoContatos();?>
		<fieldset class="legenda">
		<legend>Foto do Diretor</legend>

		<?php //inclue o formulário de upload
		formularioUpload('diretor', 'imagens', 'thumb');
		?>
		</fieldset>
		<input type="hidden" id="campos" name="campos" value="<?php camposValidar("diretor");?>" />
		<input class="btn btn-success" type="submit" value="Cadastrar Diretor" onclick="validarFormulario('diretor')" />
		
	</form>
</div>
