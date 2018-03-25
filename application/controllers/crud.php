<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Controller{

   public function __construct(){
       parent::__construct();
    $this->load->helper('url'); //carrega o helper para urls
    $this->load->helper('form');
    $this->load->helper('array');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('table');


    $this->load->model('crud_model');//faz o include do model

   }

    public function index(){
        
        $dados=array(
            'titulo' => 'CRUD com CodeIgniter',
            'tela'   => '',
        );

        $this->load->view('crud',$dados);
    }
    public function cadastrar(){
        //regras de validação dos campos
        //set_rules(name do campo, nome que ira se mostrado, regras)
        //ucwords capitaliza as palavras
        $this->form_validation->set_rules('nome','Nome','required|max_length[50]|ucwords|is_unique[teste.nome]');//Nome
        $this->form_validation->set_rules('cpf','CPF','required|max_length[14]|is_unique[teste.cpf]');//cpf
        //$this->form_validation->set_rules('email','E-mail','required|max_length[254]|strtolower|valid_email');//email
        $this->form_validation->set_message('matches','O campo %s está diferente do campo %s.');
        $this->form_validation->set_rules('senha','Senha','required|max_length[28]');
        $this->form_validation->set_rules('senha2','Senha','required|max_length[28]|matches[senha]');//cpf
        
        
        if($this->form_validation->run() == TRUE):
            $dados = elements(array('nome','cpf','senha'),$this->input->post());
 
            $dados['senha'] = md5($dados['senha']);
            $this->crud_model->do_insert($dados);//usa funcao do model

        endif;

        $dados=array(
            'titulo' => 'CRUD &raquo; Cadastrar',
            'tela'   => 'cadastrar',
        );
        $this->load->view('crud',$dados); 
    }

    public function listar(){
        $dados = array(
            'titulo' => 'CRUD &raquo; Listar',
            'tela'   => 'listar',
            'usuarios' => $this->crud_model->get_all()->result(),//retorna em forma de objeto o resultado da funcao get_all
        );
        $this->load->view('crud',$dados);
    }

    public function atualizar(){
        //regras de validação dos campos
        //set_rules(name do campo, nome que ira se mostrado, regras)
        //ucwords capitaliza as palavras
        $this->form_validation->set_rules('nome','Nome','required|max_length[50]|ucwords|is_unique[teste.nome]');//Nome
        //$this->form_validation->set_rules('email','E-mail','required|max_length[254]|strtolower|valid_email');//email
        
        if($this->form_validation->run() == TRUE):
            $dados = elements(array('nome','cpf'),$this->input->post());//resgata os dados do formulario via post
 
            //$dados['senha'] = md5($dados['senha']);
            $this->crud_model->do_update($dados,array('id' => $this->input->post('idUsuario')));//usa funcao do model

        endif;


        $dados = array(
            'titulo' => 'CRUD &raquo; Editar',
            'tela'   => 'atualizar',
        );
        $this->load->view('crud',$dados);
    }

    public function excluir(){
        if($this->input->post('iUsuario') > 0) : 
            $this->crud_model->do_excluir(array('id' => $this->input->post('idUsuario')));//usa funcao do model
        endif;
        $dados = array(
            'titulo' => 'CRUD &raquo; Excluir',
            'tela'   => 'excluir',
        );
        $this->load->view('crud',$dados);
    }


}
