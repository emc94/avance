<?php
   $this->funcoes->scripts();
?>

<script type="text/javascript" charset="utf-8">

function carregarProfessorPorDisciplina(disciplina) {
//CARREGA A LISTA DE PROFESSORES PARA CADA DISCIPLINA
    if (disciplina == "") { 
        document.getElementById('professor').innerHTML = "<option value=\"0\">Selecione a disciplina</option>";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
			//if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById('professor').innerHTML = this.responseText;
			//}
		};
		var base_url = "<?php echo base_url(); ?>"+"buscar/professorPorDisciplina/"+disciplina;
		
        xmlhttp.open("GET", base_url, true);
        xmlhttp.send();
    }
}

function carregarHorario(turma) {
//CADASTRA O HORARIO MONTADO

    if (turma == "") { 
        document.getElementById('professor').innerHTML = "<option value=\"0\">Selecione a disciplina</option>";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
                document.getElementById('carregarHorario').innerHTML = this.responseText;
        };
        var tipo="quadroHorarioTurma";
		var base_url = "<?php echo base_url(); ?>"+"buscar/quadroHorarioTurma/"+turma;
		
        xmlhttp.open("GET", base_url, true);
        xmlhttp.send();
    }
}

</script>

<form name="form_cad_turma" id="form_cad" class="form-horizontal form_cad" action="<?=base_url('cadastrar/horarioturma');?>" method="post"/>

	<fieldset class="legenda">
		<legend>Montagem de Horário - Turma</legend>
		
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="input-group">
					<span class="input-group-addon">
						<label class="control-label" for="turma">Nome da turma </label>
					</span>
				<div class="controls">
					<select class="form-control selectwidth" name="turma" id="turma" onchange="carregarHorario(this.value)">
					<option value="">Selecione a turma</option>
					<?php $this->funcoes->listarTurma();?>
					</select>
				</div>
				</div><!--GRUPO nome turma -->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-5">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="dias">Dia da semana</label>
					</span>
					<div class="controls">
						<select class="form-control selectwidth" id="dias" name="dias">
							<option value="">Selecione o dia da semana</option>
							<option value="segunda">Segunda feira</option>
							<option value="terca">Terça feira</option>
							<option value="quarta">Quarta feira</option>
							<option value="quinta">Quinta feira</option>
							<option value="sexta">Sexta feira</option>
							<option value="sabado">Sábado</option>
							<option value="domingo">Domingo</option>
						</select>
					</div>
				</div><!--GRUPO dias da semana -->
			</div>

			<div class="col-xs-12 col-md-3">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="horario_inicio">Horário / Início</label>
					</span>
					<div class="controls">
						<input class="form-control" type="time" id="horario_inicio" name="horario_inicio" />	
					</div>
				</div><!--GRUPO horario funcionamento -->
			</div>

			<div class="col-xs-12 col-md-3">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="horario_termino">Horário / Término</label>
					</span>
					<div class="controls">
						<input class="form-control" type="time" id="horario_termino" name="horario_termino" />	
					</div>
				</div><!--GRUPO horario funcionamento -->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-5">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="disciplina">
						Disciplina 
						</label>
					</span>
					<div class="controls">
						<select class="form-control selectwidth" type="text" id="disciplina" name="disciplina" onchange="carregarProfessorPorDisciplina(this.value)">
							<option value="">Selecione a disciplina</option>
							<?php $this->funcoes->listarDisciplinas();?>
						</select>

					</div>
				</div><!--GRUPO mediacao didatico pedagogica-->
			</div>

			<div class="col-xs-12 col-md-7">
				<div class="input-group">
					<span class="input-group-addon">
						<label for="professor">Professor</label>
						</span>
					<div class="controls"> 
						<select class="form-control selectwidth" id="professor" name="professor">
							<option value="">Selecione o professor</option>
						</select>
					</div>
				</div><!--GRUPO modalidade -->
			</div>
		</div>

<input type="submit" class="btn btn-success" name="cadTurma" id="cad_horaio" value="Adicionar ao Quadro de Horário" onclick="reload()" />

	</fieldset>

	<fieldset class="legenda">
		<legend>Quadro de Horário</legend>

		<div class="row" id="notas_aluno">
			<article class="col-md-11 quadroHorarioTurma">
				<table id="carregarHorario">
					<caption id="nomeTurma">Quadro de Horário da Turma</caption>
					<tr class="quadroHorario">
					<th>Horário da Aula</th>
					<th>Segunda</th> 
					<th>Terça</th>						   
					<th>Quarta</th> 
					<th>Quinta</th>
					<th>Sexta</th>
					<th>Sábado</th>
					<th>Domingo</th>
					</tr>
					<!-- CARREGA O QUADRO DE HORARIO -->			
				</table>
			</article>
		</div><!-- ROW DIV ALUNO -->

	</fieldset>

</form>