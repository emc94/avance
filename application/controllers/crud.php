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


    public function upload_temp(){//faz o upload para uma pasta temporaria
       
        $file    = basename($_FILES['userfile']['name']);  

        $validacao = false;
        $modulo = isset($_POST['modulo']) ? htmlspecialchars($_POST['modulo']) : null;
        //$categoria = isset($_POST['categoria']) ? htmlspecialchars($_POST['categoria']) : null;
        $subcategoria = isset($_POST['subcategoria']) ? htmlspecialchars($_POST['subcategoria']) : null;
        $subcategoria2 = isset($_POST['subcategoria2']) ? htmlspecialchars($_POST['subcategoria2']) : null;

        if($modulo != null AND $subcategoria != null)
            $validacao = true;

        if($validacao != false){
            
            $uploaddir = "uploads/temp/$modulo/$subcategoria/$subcategoria2/";

            if(!file_exists($uploaddir))://verifica se o diretório existe, caso não ele o cria
               mkdir("uploads/temp/$modulo/$subcategoria/$subcategoria2/",0777,true);
            endif;

            $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

            $configuracao = array(
                'upload_path'   => "./$uploaddir/",
                'allowed_types' => 'jpg',
                'file_name'     => $file,
                'max_size'      => '4096000'
            ); 

            $this->load->library('upload');
            $this->upload->initialize($configuracao);

            if ($this->upload->do_upload('userfile')) :
                echo base_url($uploadfile);
                 else :
                echo $this->upload->display_errors();
             endif;
         }
    }

    function confirm_upload(){

        $validacao = false;
        $modulo = isset($_POST['modulo']) ? htmlspecialchars($_POST['modulo']) : null;
        $categoria = isset($_POST['categoria']) ? htmlspecialchars($_POST['categoria']) : null;
        $subcategoria = isset($_POST['subcategoria']) ? htmlspecialchars($_POST['subcategoria']) : null;
        $subcategoria2 = isset($_POST['subcategoria2']) ? htmlspecialchars($_POST['subcategoria2']) : null;

        if($modulo != null AND $categoria != null AND $subcategoria != null)
            $validacao = true;

        if($validacao != false){
            $url = base_url('assets/uploads');

            $uploaddir = " $url/$modulo/$categoria/$subcategoria/$subcategoria2/";

            if(!file_exists($uploaddir))//verifica se o diretório existe, caso não ele o cria
            mkdir($uploaddir,0777, true);

            $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

            if($_FILES['userfile']['size'] <= 4096000 AND ($_FILES['userfile']['type'] == "image/png" OR $_FILES['userfile']['type'] == "image/jpeg")){
             if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                return true;
             } else {
                echo "Possível ataque de upload de arquivo!\n";
             }
            }

            //array_map('unlink', glob($url."/temp/*"));//remove o arquivo da pasta temp

        }
        else{
            echo "Erro ao receber informações do upload";
            var_dump($categoria);
            return false;
        }
    }

}
