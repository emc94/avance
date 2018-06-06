<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buscar extends CI_Controller{

    public function __construct(){
            parent::__construct();
            $this->load->library('funcoes'); //biblioteca de funcoes personalizadas
    }

    //recebe o id da disciplina e localiza o professor para essa disciplina
    function professorPorDisciplina($idDisciplina){
        $buscar_disciplina=$this->funcoes->buscarDados('disciplina', 'nome_disciplina', array('idDisciplinas'=>$idDisciplina));//recebe o id da disciplina
        $disciplina = $buscar_disciplina['nome_disciplina'];//atualiza o valor pelo nome da disciplina
        /************ BUSCA O PROFESSOR QUE LECIONA A DISCIPLINA ************/
        $consulta_professores_discplina = $this->db->query("SELECT idProfessor, nome, disciplinas FROM professor WHERE disciplinas like '%$disciplina%'")->row_array();
        $dados = array(
            'modulo'=>'professor',
            'idProfessor'=>$consulta_professores_discplina['idProfessor'], 
            'nome'=>$consulta_professores_discplina['nome']
        );
        $this->load->view("resultados",$dados);
    }//professor por disciplina

    public function quadroHorarioTurma($turma=""){
        $consultar_horario_turma=$this->db->query("SELECT * FROM horario_turma WHERE idTurma = '$turma' ORDER BY horario_inicio_aula ASC")->result('array');
            $dados=array(
                'modulo'=>'quadro_horario_turma', 
                'dados'=>$consultar_horario_turma
            );
       //$consultar_horario_turma->free_result(); 
        $this->load->view("resultados",$dados);    
    }

}
