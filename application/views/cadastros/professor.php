<?php
   $this->load->view("includes/funcoes.php"); 
     scripts();
?>

<div class="container">
<form id="form_cad" action="<?=base_url('/cadastrar/cadastrarProfessor');?>" method="post" class="form-horizontal form_cad">
	
	<h3>Formulário de Cadastro / Professor</h3>
	<fieldset class="legenda">
		<!-- ERROS DE VALIDAÇÃO -->
		  <div id="erros" class="alert alert-danger campoErros" role="alert">
		  </div>
<!-- *************************** DADOS PESSOAIS *********************************** -->	



<!-- DADOS DA ESCOLA -->

		<div class="row">
			<div class="col-md-6 col-sm-3">
				<div class="">
					<span class="">
						<label for="escola">Escola</label>
					</span>

					<div class="controls">
						<select name="escola" class="form-control selectwidth" id="escola" required>
							<option value="0">Selecione a Escola</option>
							<?php listarEscola(); ?>
						</select>
					</div>

				</div><!-- GRUPO codigo escola -->
			</div>
		</div>

	<legend>Dados Pessoais</legend>
	<!-- DADOS PESSOAIS -->

		<div class="row">

				<div class="col-xs-12 col-md-6">
					<div class="">
						<span class="">
							<label for="nome">Nome</label>
						</span>
							<div class="controls">
								<input type="text" id="nome" name="nome" placeholder="Nome Completo" class="form-control inputwidth" required/>
							</div>
					</div>
				</div>

				<div class="col-xs-12 col-md-6">
					<div class="">
						<span class="">
							<label for="cpf">CPF</label>
						</span>
						<div class="controls">
							<input type="text" id="cpf" name="cpf" placeholder="Número do Cadastro de Pessoa Física" class="form-control inputwidth" onkeypress="mascarar(this,'cpf')" required/>
						</div>
					</div>
				</div>

		</div><!-- row nome cpf -->

		<div class="row">
			<div class="">
				<div class="col-xs-12 col-md-7">
					<div class="">
						<span class="">
							<label class="control-label" for="data_nascimento">Data de Nascimento</label>
						</span>
							<div class="controls">
								<input type="date" id="data_nascimento" name="datanascimento" class="form-control dateinput"/>
							</div>	
					</div>
				</div>

				<div class="row col-xs-12 col-md-3">
					<div class="">
							<div class="">
								<label class="col-md-5 col-xs-12 ">Sexo</label>
								<label class="checkbox"><input type="radio" name="sexo" id="m" value="m">Masculino</label>
								<label class="checkbox"><input type="radio" name="sexo" id="f" value="f">Feminino</label>
							</div>
					</div>
				</div>

			</div><!-- GRUPO email data nascimento sexo -->
		</div><!-- row email data nascimento sexo -->

		<div class="row col-md-10 col-sm-5 col-xs-11">
			<div class="form-group">
				<label for="cor" class="control-label">Cor / Raça</label>
			</div>
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

	<!-- ************************* INFORMACOES DO CONTRATO ************************* -->
	<fieldset class="legenda">

		<legend>Situação Contratual</legend>

		<div class="row">
			<div class="col-md-6 col-xs-12">	
				<div class="">
					<span class="">
						<label for="funcao">Função</label>
					</span>
					<div class="controls">
						<select name="funcao" id="funcao" class="form-control selectwidth" required>
							<option value="0">Função que exerce</option>
							<?php listarContrato_funcoes();?>
						</select>
					</div>
				</div><!-- GRUPO -->
			</div>
		
			<div class="col-md-6 col-xs-12">
				<div class="">
					<span class="">
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

		<div class="row">
			<div class="col-md-10 col-xs-4">	
				<div class="">
					<label class="control-label">Disciplinas Lecionadas</label>
					<div class="checkbox">
						<?php listarDisciplina();?>
					</div>
				</div>
			</div><!-- GRUPO -->
		</div>
	</fieldset>

	<!-- ************************ INFORMACOES DO PROFISSIONAIS ********************** -->
	<fieldset class="legenda">
		<legend >Formação Profissional</legend>

		<div class="row">
			<div class="col-md-4 col-xs-12">
				<div class="">
					<label class="control-label">Curso Superior</label>
							<label class="checkbox-inline">
								<input type="radio" name="cursosuperior" value="sim" onclick="habilitarCampo('areadocurso', this.value)" />  <p class="checkinline">Sim</p></label>
							</label>
							<label class="checkbox-inline">
								<input type="radio" name="cursosuperior" value="não" onclick="habilitarCampo('areadocurso', this.value)" />  <p class="checkinline">Não</p>
							</label>
				</div><!-- GRUPO -->
			</div>
		
		<div class="col-md-8 col-xs-12">
			<div class="">
				<span class="">
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
			<div class="">
				<div class="controls">
					<label class="control-label">Complementação Pedagógica</label>
				</div>
				<div class="controls">
							<label class="checkbox-inline">
								<input type="radio" name="formacaopedagogica" value="sim" />  <p class="checkinline">Sim</p></label>
							</label>
							<label class="checkbox-inline">
								<input type="radio" name="formacaopedagogica" value="nao" />  <p class="checkinline">Não</p></label>
							</div>
			</div><!-- GRUPO -->
		</div>

	</div>
		<div class="row">
			<div class="col-md-4 col-xs-12">
				<div class="">
					<label  class="control-label">Pós-Graduação</label>

						<label class="checkbox-inline">
							<input type="radio" name="posgraduacao" value="sim" onclick="habilitarCampo('tipopos', this.value)" />  <p class="checkinline">Sim</p></label>
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="posgraduacao" value="não" onclick="habilitarCampo('tipopos', this.value)"/>  <p class="checkinline">Não</p></label>
				</div><!-- GRUPO -->
			</div>

		<div class="col-md-8 col-xs-12">
			<div class="">
				<span class="">
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
			<div class="">
				<span class="">
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

	<?php
	 enderecoContatos();
	?>

		 <input type="hidden" id="campos" name="campos" value="<?php camposValidar("professor");?>" />
			<input class="btn btn-success" type="submit" onclick="validarFormulario('professor')" value="Cadastrar Professor" />

</form>
</div>
