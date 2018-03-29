<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		//$this->load->model('usuario_model');//faz o include do model
	}

	public function index()
	{
		$this->load->view('login');
	}
	
    public function autenticar(){
 
        $this->load->model("usuario_model");// chama o modelo usuarios_model
        $login = $this->input->post("login");// pega via post o login
		$senha = $this->input->post("senha"); // pega via post a senha
		$nivel = $this->input->post('nivel');//pega via post o nivel de acesso
		
		$usuario = $this->usuario_model->buscaPorLoginSenha($login,$senha,$nivel); // acessa a função buscaPorEmailSenha do modelo
		//var_dump($usuario);

        if($usuario){
            $this->session->set_userdata("usuario_logado", $usuario);
			$dados = array("mensagem" => "Logado com sucesso!");
			$dados['titulo'] = 'SIGE | Home';
			$dados['tela'] = 'home'; 
			$dados['nome'] = $usuario['nome'];
			//var_dump($dados);

			redirect("home", $dados);
			
        }else{
			$dados = array("error" => "Usuário ou Senha incorreto(s)!");
			$this->load->view("login", $dados);
        }
		
	}
	public function logout(){

		$this->session->sess_destroy();
		$this->session->sess_regenerate([$destroy = TRUE]);//destroi os dados da sessao anterior impedindo o retorno a pagina anterior
		redirect('/');

	}
}

