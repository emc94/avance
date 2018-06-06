<?php
   $this->funcoes->scripts();
?>

<form  id="form_cad" class="form-horizontal form_cad" action="<?= base_url('cadastrar/cadastrarAluno');?>" method="post" accept-charset="utf-8">

<h3>Formulário de Cadastro / Aluno</h3>

<fieldset class="legenda">
	<legend>Dados Escolares</legend>
	<!-- DADOS DA ESCOLA -->
		<div class="row">
			<div class="col-md-6 col-sm-3">
				<div class="">
					<span class="">
						<label for="escola">Escola</label>
					</span>

					<div class="controls">
						<select name="escola" class="form-control selectwidth" id="escola" readonly>
							 <?php   $this->funcoes->listarEscolaDiretor();  ?>
						</select>
					</div>
				</div><!-- GRUPO CÓDIGO ESCOLA -->
			</div><!--ROW-->

		<div class="col-md-6 col-xs-12">
			<div class="">
				<span class="">
					<label for="turma">Turma</label>
				</span>
				<div class="controls">
					<select class="form-control selectwidth" id="turma" name="turma" required>
						<option value="">Selecione a turma</option>
						<?php $this->funcoes->listarTurmaEscola();?>
					</select>
				</div>
		</div>
	</div>
</div>

</fieldset>
<fieldset class="legenda">

	<!-- ERROS DE VALIDAÇÃO -->
	<div id="erros" class="alert alert-danger campoErros" role="alert">
	</div>	

	<legend>Dados Pessoais</legend>

	<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="">
					<span class="">
						<label for="cpf">CPF</label>
					</span>
					<div class="controls">
						<input class="form-control" type="text" name="cpf" id="cpf" placeholder="Número do Cadastro de Pessoa Física" onkeypress="mascarar(this,'cpf')" />
					</div>
				</div>
			</div><!-- GRUPO CPF -->

			<div class="col-xs-12 col-md-6">
				<div class="">
					<span class="">
						<label for="identidade">Identidade</label>
					</span>
					<div class="controls">
						<input class="form-control" type="text" id="identidade" name="identidade" placeholder="Número do registro geral" onkeypress="mascarar(this,'rg')" />
					</div>
				</div><!-- GRUPO IDENTIDADE -->
			</div>
	</div>

	<div class="row">
			<div class="col-xs-12 col-md-4">
				<div class="">
					<span class="">
						<label for="orgao">Emissor</label>
					</span>
					<div class="controls">
						<select class="form-control selectwidth" id="orgao" name="orgaoex">
						<option value="">Orgão emissor identidade</option>
						<?php $this->funcoes->listarOrgaoEmissor();?>
						</select>
					</div>
				</div><!--GRUPO ORGAO EXPEDIDOR -->
			</div>

			<div class="col-xs-12 col-md-4">
				<div class="">
					<span class="">
						<label for="uf_identidade">UF Identidade</label>
					</span>
					 <div class="controls">
						<select class="form-control selectwidth" id="uf_identidade" name="uf_identidade">
							<option value="">Unidade Federativa</option>
						<?php $this->funcoes->listarUf();?>

					  	</select>
					 </div>
				</div>
			</div>

			<div class="col-xs-12 col-md-4">
				<div class="">
					<span class="">
						<label for="data_expedicao">Expedição</label>
					</span>
					 <div class="controls">
						<input class="form-control dateinput" type="date" name="data_expedicao" id="data_expedicao" />
					</div>
				</div><!-- GRUPOORGAO UF DA EXPEDIÇÃO -->
			</div>
	</div>

	<div class="row">
			<div class="col-xs-12 col-md-7">
				<div class="">
					<span class="">
						<label for="nome">Nome</label>
					</span>

					 <div class="controls">
						<input class="form-control" type="text" name="nome" id="nome" placeholder="Nome do aluno" required/>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-md-5">
				<div class="">
					<span class="">
						<label for="data_nascimento">Data Nascimento</label>
					</span>
					<div class="controls">
						<input class="form-control dateinput" type="date" id="data_nascimento" name="datanascimento" required/>
					</div>
				</div><!-- GRUPO NOME DATA NASCIMENTO -->
			</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-md-6">
				<div class="">
					<span class="">
						<label for="nome_pai">Nome do Pai</label>
					</span>
						<div class="controls">
							<input class="form-control" type="text" id="nome_pai" name="nome_pai" placeholder="Nome do pai do aluno" />
						</div>
				</div><!-- GRUPO NOME DO PAI -->
		</div>

		<div class="col-xs-12 col-md-6">
				<div class="">
					<span class="">
						<label for="nome_mae">Nome da Mãe</label>
					</span>
						<div class="controls">
							<input class="form-control" type="text" id="nome_mae" name="nome_mae" placeholder="Nome da mãe" />
					</div>
				</div><!-- GRUPO NOME DA MÃE -->
		</div>
	</div>

	<div class="row">
			<div class="col-xs-12 col-md-7">
				<div class="">
					<span class="">
						<label for="nome_responsavel">Responsável</label>
					</span>
						<div class="controls">
							<input class="form-control inputwidth" type="text" id="nome_responsavel" name="nome_responsavel" placeholder="Nome do responsável pelo aluno " required/>
						</div>
				</div><!-- GRUPO NOME RESPONSÁVEL -->
			</div>
	</div>

	<div class="row">
			<div class="col-xs-12 col-md-7">
				<div class="grupo">
						<label class="control-label" for="ignorado">Declarado Ignorado
							<input class="checkbox-inline" type="checkbox" name="ignorado" id="ignorado" value="s" />
						</label>
				</div>
			</div><!-- GRUPO ignorado -->
	</div>

	<div class="row">
		<div class="col-md-6 col-xs-12">
				<label class="control-label">Sexo</label>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-xs-12">
			<label class="checkbox-inline"><input type="radio" name="sexo" id="m" value="m">Masculino</label>
			<label class="checkbox-inline"><input type="radio" name="sexo" id="f" value="f">Feminino</label>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-xs-5">
			<label for="cor">Cor / Raça</label>
		</div>
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
	</div> <!-- row cor raça -->

	<div class="row">
		<div class="grupo">
			<label class="col-md-12 col-xs-12 control-label">Nacionalidade</label>				
		</div>
	</div>
	<div class="row">
			<label class="checkbox-inline" for="brasileira"><input type="radio" id="brasileira" name="nacionalidade" value="brasileira"/>
			Brasileira</label>
			<label class="checkbox-inline" for="estrangeira"><input type="radio" id="estrangeira" name="nacionalidade"  value="estrangeira"/>
			Estrangeira</label>
	</div>
	
	<div class="row">
			<div class="">
				<label class="col-md-12 col-xs-12 control-label" for="deficiencia">
					Aluno portador de deficiência física ou mental &nbsp; <input class="checkbox-inline" type="checkbox" name="deficiencia" id="deficiencia" value="s" />
				</label>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-xs-12">
			<div class="">
				<span class="">
					<label for="uf_nascimento">UF de Nascimento</label>
				</span>
					<select class="form-control selectwidth" name="ufnascimento" id="uf_nascimento"  onchange="carregarCidadesEstado(this.value,'municipionascimento')" required>
						<option value="">UF de nascimento</option>
						<?php $this->funcoes->listarUf();?>
					</select>
			</div><!-- GRUPO uf nascimento -->
		</div>

		<div class="col-md-6 col-xs-12">
			<div class="">
				<span class="">
					<label for="municipio">Município de Nascimento</label> 
				</span>		
				<select class="form-control selectwidth" name="municipionascimento" id="municipionascimento" required>
					<option value="">Selecione a cidade</option>
					<?php $this->funcoes->listarMunicipio();?>
				</select>
			</div><!-- GRUPO município nascimento -->
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-xs-12">
			<div class="">
				<span class="">
					<label for="n_certidao_nascimento">Nº Certidão de Nascimento</label>
				</span>
					<input class="form-control" type="text" name="ncertidao" id="n_certidao_nascimento" placeholder="Número da certidão de nascimento" required/>
				
			</div>
		</div>
	
		<div class="col-md-3 col-xs-12">
			<div class="">
				<span class="">
					<label for="n_termo">Nº Termo</label> 
				</span>
					<input class="form-control" type="text" name="n_termo" id="n_termo" placeholder="Número do termo da certidão" required/>
	
			</div>
		</div>
		<div class="col-md-3 col-xs-12">
			<div class="">
				<span class="">
					<label for="n_folha">Nº Folha</label> 
				</span>
				<input class="form-control" type="text" id="n_folha" name="n_folha" placeholder="Número da folha da certidão" required/>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3 col-xs-12">
			<div class="">
				<span class="">
					<label for="livro">Livro</label>
				</span>
				<input class="form-control" type="text" id="livro" name="livro" placeholder="Livro da certidão" required/> 
			</div>
		</div>

		<div class="col-md-4 col-xs-12">
			<div class="">
				<span class="">
					<label for="data_emissao">Data de Emissão</label>
				</span>
				<input class="form-control dateinput" type="date" id="data_emissao" name="data_emissao" placeholder="Data da emissão da certidão" required/> 
			</div>
		</div>

		<div class="col-md-5 col-xs-12">
			<div class="">
				<span class="">
					<label for="uf_cartorio">UF do Cartório</label>
				</span>
				<select class="form-control selectwidth" name="uf_cartorio" id="uf_cartorio" onchange="carregarCidadesEstado(this.value,'municipio_cartorio')" required>
					<option value="">UF do cartório</option>
					<?php $this->funcoes->listarUf();	?>
				</select>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-xs-12">
			<div class="">
				<span class="">
					<label for="municipio_cartorio">Município do Cartório</label>
				</span>
				<select class="form-control selectwidth" name="municipio_cartorio" id="municipio_cartorio" placeholder="Cidade do cartório" required>
					<option value="">Cidade do cartório</option>
					<?php $this->funcoes->listarMunicipio();?>
				</select>
			</div>
		</div>

		
		<div class="col-md-6 col-xs-12">
			<div class="">
				<span class="">
					<label for="nome_cartorio">Nome do Cartório</label>
				</span>
				<input class="form-control" type="text" type="text" id="nome_cartorio" name="nome_cartorio" placeholder="Nome do cartório" required/> 
			</div>
		</div>
	</div>

</fieldset>

<?php $this->funcoes->enderecoContatos();?>

		 <input type="hidden" id="campos" name="campos" value="<?php //camposValidar("aluno");?>" />
		<input class="btn btn-success" type="submit" onclick="validarFormulario('aluno')" value="Matricular Aluno" />

	</form>