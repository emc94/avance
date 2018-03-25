<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model{
    public function buscaPorLoginSenha($login, $senha,$nivel){
       
        if($nivel == 'aluno'):
            $this->db->where("matricula", $login);
            $this->db->where("senha", $senha);

            $usuario = $this->db->get("aluno")->row_array();
        else:
            
            $this->db->where("login", $login);
            $this->db->where("senha", $senha);

            if($nivel == 'secretario')://secretario
                $nivel = 's';
            elseif($nivel == 'professor')://professor
                $nivel = 'p';
            elseif($nivel == 'diretor')://diretor
                 $nivel = 'd';
            endif;

            $this->db->where("nivel", $nivel);
            $usuario = $this->db->get("usuario")->row_array();
        endif;
        $dados_sessao =array(
            'sigeUserNivel' => $nivel,
            'login' => $login,
            'cookie' => $usuario['cookie'],
            'codigo_user' => $usuario['codigo_user']
        );
        return $dados_sessao;
    }
}