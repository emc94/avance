<?php
	$this->load->library('funcoes'); //biblioteca de funcoes personalizadas
    $this->funcoes->scripts();
?>


<form name="form_cad_turma" id="form_cad"  method="post" action="<?=base_url('cadastrar/cadastrarTurma');?>" class="form-horizontal form_cad" />


	<fieldset class="legenda">
		<legend>Formulário de Cadastro - Turma</legend>

		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="input-group">
					<span class="input-group-addon">
						<label class="control-label" for="nome">
							Nome da Turma 
						</label>
					</span>
				<div class="controls">
					<input class="form-control inputwidth" type="text" id="nome" name="nome" />
				</div>
				</div><!--GRUPO nome turma -->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="input-group">
					<span class="input-group-addon">
						<label class="control-label" for="ano-letivo">
							Ano Létivo 
						</label>
					</span>
				<div class="controls">
					<input class="form-control inputwidth" type="number" min="1900" max="2099" step="1" value="<?php echo date('Y');?>" id="ano-letivo" name="ano_letivo" />
				</div>
				</div><!--GRUPO nome turma -->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="mediacao">
						Mediação didático-pedagógica 
						</label>
					</span>
					<div class="controls">
						<select class="form-control selectwidth" type="text" id="mediacao" name="mediacao">
							<option value="">Selecione a Mediação</option>
							<?php $this->funcoes->listarMediacao();?>
						</select>

					</div>
				</div><!--GRUPO mediacao didatico pedagogica-->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="turno">Turno</label>
					</span>
					<div class="controls">
						<select class="form-control selectwidth" id="turno" name="turno">
							<option value="0">Selecione o Turno das Aulas</option>
							<option value="matutino">Matutino</option>
							<option value="vespertino">Vespertino</option>
							<option value="noturno">Noturno</option>
							<option value="integral">Integral</option>
						</select>					

					</div>
				</div><!--GRUPO Turno de Aula -->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="horario_inicio">
							Horário de Início 
						</label>
					</span>
					<div class="controls">
						<input class="form-control inputwidth" type="time" id="horario_inicio" name="horario_inicio" />	
					</div>
				</div><!--GRUPO horario funcionamento -->
			</div>
		</div>
			<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="horario_termino">
							Horário de Término 
						</label>
					</span>
					<div class="controls">
						<input class="form-control inputwidth" type="time" id="horario_termino" name="horario_termino" onclick="validarFormulario('turma')" />	
					</div>
				</div><!--GRUPO horario funcionamento -->
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="input-group">
					<label>
						Dias da semana
					</label>

					<div class="checkbox">
						<label class="checkbox">
							<input type="checkbox" name="dias[]" value="segunda à sexta" /> Segunda à Sexta 
						</label>
						<label class="checkbox">
							<input type="checkbox" name="dias[]" value="segunda" /> Segunda 
						</label>
						<label class="checkbox">
							<input type="checkbox" name="dias[]" value="terça" /> Terça 
						</label>
						<label class="checkbox">
							<input type="checkbox" name="dias[]" value="quarta" /> Quarta 
						</label>
						<label class="checkbox">
							<input type="checkbox" name="dias[]" value="quinta" /> Quinta 
						</label>
						<label class="checkbox">
							<input type="checkbox" name="dias[]" value="sexta" /> Sexta 
						</label>
						<label class="checkbox">
							<input type="checkbox" name="dias[]" value="sábado" /> Sábado 
						</label>
						<label class="checkbox">
							<input type="checkbox" name="dias[]" value="domingo" /> Domingo 
						</label>

					</div>
				</div><!--GRUPO dias da semana -->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="modalidade">
							Modalidade 
						</label>
						</span>
					<div class="controls"> 
						<select class="form-control selectwidth" id="modalidade" name="modalidade">
						<option value="0000">Selecione a modalidade de ensino</option>
						<?php $this->funcoes->listarModalidade();?>
						</select>
					</div>
				</div><!--GRUPO modalidade -->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="etapa">Etapa</label>
					</span>
					<div class="controls">
						<select class="form-control selectwidth" id="etapa" name="etapa">
							<option value="0">Selecione a Etapa de Ensino</option>
							<?php $this->funcoes->listarEtapa();?>
						</select>					

					</div>
				</div><!--GRUPO etapa -->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="anoensino">Ano de Ensino da Turma</label>
					</span>
					<div class="controls">
						<select class="form-control selectwidth" id="anoensino" name="anoensino">
							<option value="0">Selecione o ano de ensino</option>
							<?php $this->funcoes->listarAnoEnsino();?>
						</select>					

					</div>
				</div><!--GRUPO Ano de ensino -->
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="total_vagas">Total de Vagas</label>
					</span>
					<div class="controls">
						<input class="form-control inputwidth" placeholder="Total de alunos" type="number" id="total_vagas" name="total_vagas" />
					</div>
				</div><!--GRUPO Ano de ensino -->
			</div>
		</div>

	</fieldset>
	<input type="hidden" id="campos" name="campos" value="<?php //camposValidar("turma");?>" />
	<input type="submit" class="btn btn-success" name="cadTurma" id="cad_turma" value="Cadastrar Turma" onclick="validarFormulario('turma')" />


</form>
