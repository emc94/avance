<?php  
    defined('BASEPATH') OR exit('No direct script access allowed');

class ValidacoesHorario
{

    private $CI; // Receberá a instância do Codeigniter

    public function __construct(){
        $this->CI = &get_instance();
        $this->CI->load->library('funcoes'); //biblioteca de funcoes personalizadas
        $this->CI->load->model('crud_model');
    }

    public function cadastrarHorarioNovo($horarioI, $horarioT, $turma){//cadastra o horario
        $cadHorario=FALSE;
        $cpf = $_SESSION['logged']['login'];
        $buscar_funcionario=$this->CI->db->query("SELECT funcionarios.id FROM funcionarios, diretor WHERE diretor.cpf='$cpf' AND funcionarios.idFuncionario=diretor.idDiretor")->row_array();
        $buscarEscola = $this->CI->db->query("SELECT idEscola FROM funcionarios WHERE id='$buscar_funcionario[id]'")->row_array();
        if($buscarEscola!=NULL){
           $dadosHorario = array(
                'idTurma'=>$turma, 
                'idEscola'=>$buscarEscola['idEscola'], 
                'horario_inicio_aula'=>$horarioI, 
                'horario_termino_aula'=>$horarioT
            );
            //cadastra o Horário da Turma
            $this->CI->crud_model->do_insert('horario_turma', $dadosHorario);
            //confirma se a transação foi bem sucedida
            if ($this->CI->db->trans_status() === FALSE){
                $cadHorario = FALSE;
            }
            else{
                $cadHorario = $this->CI->db->insert_id();
            }
        }
        return $cadHorario;
    }

    public function validarDisponibilidade($professor, $horarioI, $horarioT, $dia, $turma){//valida se o professor esta disponivel
        $validarProfessor=TRUE;//Horario Valido
        $buscarHoarioTurma=$this->CI->db->query("SELECT * FROM horario_turma WHERE $dia is not null AND (horario_inicio_aula BETWEEN '$horarioI' AND '$horarioT')")->result_array ();
        if($buscarHoarioTurma!=NULL){//verifica se houve algum resultado
            foreach($buscarHoarioTurma as $values){
                $idProfessorDia = explode("-", $values[$dia]);
                if($idProfessorDia['0']==$professor){//se o professor ja estiver em sala
                        $validarProfessor=FALSE;
                        redirect('/notificacoes/error/1030/cadastrar-horario');
                    break; 
                    exit();       
                }
            }
        }else{//CASO NAO RETORNE RESULTADOS
            $buscarHorarioVago = $this->CI->db->query("SELECT * FROM horario_turma WHERE idTurma='$turma' AND(horario_inicio_aula BETWEEN '$horarioI' AND '$horarioT')")->row_array();
            if($buscarHorarioVago==NULL){//SE O HORARIO INFORMADO NAO ESTA NO INTERVALO ENTAO ELE E UM HORARIO NOVO
               if($this->cadastrarHorarioNovo($horarioI, $horarioT, $turma)==FALSE){
                    $validarProfessor = FALSE; 
               }
            }
        }
     return $validarProfessor;
    }//final funcao validarDisponibilida dos professores

    function validarNotas($idTurma,$disciplina,$idProfessor){//valida se o aluno ja possui cadastrada para essa disciplina

        $validar=FALSE;
          $consultar=$this->CI->db->query("SELECT codigoNota FROM notas WHERE idTurma='$idTurma' AND idProfessor='$idProfessor' AND disciplina='$disciplina'")->row_array();
          if($consultar!=NULL){
            //insert na tabela de notas para todos os alunos da turma
             $consultar = $this->CI->db->query("SELECT idAluno FROM aluno WHERE idTurma='$idTurma'")->result_array();
             $consultarEscola = $this->CI->db->query("SELECT idEscola FROM turma WHERE idTurma='$idTurma'")->row_array();
             $idEscola = $consultarEscola['idEscola'];
             if($consultar!=NULL){
                foreach($consultar as $aluno){
                    $idAluno=$aluno['idAluno'];
                    $dadosNotas = array(
                        'idAluno'=>$idAluno, 
                        'idEscola'=>$idEscola, 
                        'idTurma'=>$idTurma, 
                        'idProfessor'=>$idProfessor, 
                        'disciplina'=>$disciplina
                    );
                    //cadastra Notas dos Alunos
                    $this->CI->crud_model->do_insert('notas', $dadosAluno);
                    if($this->db->trans_status() !== FALSE){
                    $validar = TRUE;
                    }
                }//fim foreach
             }//se nao enctonrar alunos ele continua
            }else{
            //caso ja tenha algo na tabela de notas
            $validar = TRUE;
          }
        return $validar;
    }//Fim da funçao validarNotasAlunoDisciplina

}
