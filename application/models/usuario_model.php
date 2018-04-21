<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model{
    public function buscaPorLoginSenha($login, $senha,$nivel,$tabela){

        if($nivel == 'a'):
            $this->db->select('nome','matricula','senha');
            $this->db->where("matricula", $login);
            $this->db->where("senha", $senha);

            $usuario = $this->db->get("aluno")->row_array();//encontra o usuario na tabela do seu nivel de acesso
            //var_dump($usuario);
            if($usuario!=NULL):
                $dados_sessao =array(
                    'sigeUserNivel' => $nivel,
                    'login' => $login,
                    'codigo_user' => $usuario['matricula'],
                    'nome' => $usuario['nome']
                );
            endif;
        else:
            $this->db->where("login", $login);
            $this->db->where("senha", $senha);
            $this->db->where("nivel", $nivel);
            $usuario = $this->db->get("usuario")->row_array();//encontra o idUsuario
            //var_dump($usuario);
            if($usuario!=NULL):
                $this->db->select('nome');
                $this->db->distinct();
                $this->db->where('idUsuario', $usuario['idUsuario']);
            
                $query  =  $this->db->get($tabela)->row_array();//encontra o usuario na tabela do seu nivel de acesso
        
                $dados_sessao =array(
                    'sigeUserNivel' => $nivel,
                    'login' => $login,
                    'codigo_user' => $usuario['codigo_user'],
                    'nome' => $query['nome']
                );
            endif;

        endif;

        return $dados_sessao;
    }
}