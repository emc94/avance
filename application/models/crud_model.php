<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model{

    public function do_insert($dados=NULL){
        if($dados!=NULL) :
            $this->db->insert('teste',$dados);
            $this->session->set_flashdata('cadastrook','cadastro efeituado com sucesso!');
            redirect('crud/cadastrar');//url helper que redireciona
        endif;
    }
    public function do_update($dados=NULL,$condicao=NULL){
        if($dados!=NULL && $condicao!=NULL) :
            $this->db->update('teste',$dados,$condicao);
            $this->session->set_flashdata('edicaook','Cadastro efeituado com sucesso!');
            redirect(current_url());//volta pra url anterior
        endif;
    }
    public function get_all(){
        return $this->db->get('teste');
    }

    public function get_byId($id=NULL){
        if($id!=NULL):
            $this->db->where('id',$id);
            $this->db->limit(1);
            return $this->db->get('teste');
        else: 
            return false;
        endif;
    }

    public function do_excluir($condicao = NULL){
        if($condicao!=NULL):
            $this->db->delete('teste',$condicao);
            $this->session->set_flashdata('excluidook','Excluido com sucesso!');
            redirect('crud/listar');//volta pra url anterior
        endif;
    }
}