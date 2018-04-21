<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acesso extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }

    public function negado(){
        $this->template->load('template','nao_autorizado');
    }
    public function pg_nao_encontrado(){
        $this->template->load('template','404');
    }


}