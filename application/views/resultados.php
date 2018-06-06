<?php
$this->load->library('funcoes'); //biblioteca de funcoes personalizadas    

    if($modulo == 'professor'){//mostra a lista de professores
        if($idProfessor!=null){
            echo"<option value=\"0\">Selecione o professor</option>";
            echo"<option value=\"$idProfessor\">$nome</option>";
        }
        else{
            echo "<option value=\"0\">Não há professor para essa disciplina</option>";
        }
    }
    elseif($modulo == 'quadro_horario_turma'){//carrega o print do quadro de horario
        $url = base_url('excluirHorarioTurma/');

        if($dados!=NULL){//verifica se foi encontrato algum horario cadastrado na turma          
                echo "            
                    <caption id=\"nomeTurma\">Quadro de Horário da Turma</caption>
                    <tr class=\"quadroHorario\">
                    <th>Horário da Aula</th>
                    <th>Segunda</th> 
                    <th>Terça</th>              
                    <th>Quarta</th> 
                    <th>Quinta</th>
                    <th>Sexta</th>
                    <th>Sábado</th>
                    <th>Domingo</th>
                    </tr>";
            foreach($dados as $value){ 
                echo"<tr class=\"disciplina\">";
                echo"
                     <td>";
                    if($_SESSION['logged']['sigeUserNivel']=='d'){
                        echo"
                        <a href=\"$url".$value['horario_inicio_aula']."/".$value['horario_termino_aula']."/".$value['idTurma']."\"> 
                        <span class=\"glyphicon glyphicon-trash\" title=\"Remover este horario\"></span></a>
                        ";
                    }
                         echo"
                        ".substr($value['horario_inicio_aula'], 0, 5) ." - ". substr($value['horario_termino_aula'], 0, 5)."</td>";
                        $this->funcoes->filtrarDisciplinaProfessor($value['segunda']);
                        $this->funcoes->filtrarDisciplinaProfessor($value['terca']);
                        $this->funcoes->filtrarDisciplinaProfessor($value['quarta']);
                        $this->funcoes->filtrarDisciplinaProfessor($value['quinta']);
                        $this->funcoes->filtrarDisciplinaProfessor($value['sexta']);
                        $this->funcoes->filtrarDisciplinaProfessor($value['sabado']);
                        $this->funcoes->filtrarDisciplinaProfessor($value['domingo']);
                echo"</tr>";
            }//foreach
                
        }else{
            echo "<tr class=\"disciplina\">Horário da Turma não construído!</tr>";
        }
    }//if horarioturma