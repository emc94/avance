<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gerenciar extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');

    }

    public function escolas(){
        $this->auth->CheckAuth($this->router->fetch_class(), $this->router->fetch_method());
        $dados = array('modulo'=>'escolas');
        $this->template->load('template', 'gerenciar',$dados);
    }

    public function diretores(){
        $this->auth->CheckAuth($this->router->fetch_class(), $this->router->fetch_method());
        $dados = array('modulo'=>'diretores');
        $this->template->load('template', 'gerenciar',$dados);
    }

    public function alunos(){
        $this->auth->CheckAuth($this->router->fetch_class(), $this->router->fetch_method());
        $dados = array('modulo'=>'alunos');
        $this->template->load('template', 'gerenciar',$dados);
    }

    public function turmas(){
        $this->auth->CheckAuth($this->router->fetch_class(), $this->router->fetch_method());
        $dados = array('modulo'=>'turmas');
        $this->template->load('template', 'gerenciar',$dados);
    }

    public function professores(){
        $this->auth->CheckAuth($this->router->fetch_class(), $this->router->fetch_method());
        $dados = array('modulo'=>'professores');
        $this->template->load('template', 'gerenciar',$dados);
    }

    public function horarios(){
        $this->auth->CheckAuth($this->router->fetch_class(), $this->router->fetch_method());
        $dados = array('modulo'=>'horarios');
        $this->template->load('template', 'gerenciar',$dados);
    }

}