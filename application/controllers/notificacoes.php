<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacoes extends CI_Controller{
    
    public function sucesso($codigo,$redirect){
        $mensagens = array(
            '1001'=>'Disciplina adicionada ao Quadro de Horário da Turma'
        );
        $dados = array(
            'status'=>'sucesso',
            'mensagem'=>$mensagens[$codigo],
            'pagina'=>$redirect
        );
        $this->template->load('template','notificacoes',$dados);
    }
    
    public function error($codigo,$redirect){
        $mensagens = array(
            '1030'=>'O professor não está disponível no horário informado!',
            '1050'=>'Erro ao atualizar horário da turma!',
            '1042'=>'Informe todos os valores!',
            '1010'=>'Verifique os horários, disciplinas e professores, já cadastrados no quadro de horário!'   
         );
        $dados = array(
            'status'=>'error',
            'mensagem'=>$mensagens[$codigo],
            'pagina'=>$redirect
        );
       $this->template->load('template','notificacoes',$dados); 
    }

}