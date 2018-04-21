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
 

		$login = $this->input->post("login");// pega via post o login
		$senha = $this->input->post("senha"); // pega via post a senha
		$nivel = $this->input->post('nivel');//pega via post o nivel de acesso

		if($login!="" && $senha!="" && $nivel!="0")://se há usuaario senha e nivel

			if($nivel == 'aluno'):
				$nivel = 'a';
				$tabela = 'aluno';
			elseif($nivel == 'secretario')://secretario
				$nivel = 's';
				$tabela = 'secretario';
			elseif($nivel == 'professor')://professor
				$nivel = 'p';
				$tabela = 'professor';
			elseif($nivel == 'diretor')://diretor
				$nivel = 'd'; 
				$tabela = 'diretor';
			endif;

           
		$this->load->model("usuario_model");// chama o modelo usuarios_model

		$usuario = $this->usuario_model->buscaPorLoginSenha($login,$senha,$nivel,$tabela); // acessa a função buscaPorEmailSenha do modelo
		//var_dump($usuario);

        if($usuario!=NULL){
            $this->session->set_userdata("logged", $usuario);
			$dados = array("mensagem" => "Logado com sucesso!");
			$dados['titulo'] = 'SIGE | Home';
			$dados['tela'] = 'home'; 
			$dados['nome'] = $usuario['nome'];
			//var_dump($dados);
			//var_dump($_SESSION);
			redirect("home", $dados);
			
        }else{
			$this->session->set_userdata("error", "<b>Usuário</b> ou <b>Senha</b> incorreto(s)!");
			redirect('/login');
		}
		
	else: //caso não haja login, senha ou nivel
		$this->session->set_userdata("error", "Informe o <b>Usuário</b> a <b>Senha</b> e o <br /> <b>Tipo de Acesso</b>!");
		redirect('/login');
	endif;

		
	}
	public function logout(){

		$this->session->sess_destroy();
		$this->session->sess_regenerate([$destroy = TRUE]);//destroi os dados da sessao anterior impedindo o retorno a pagina anterior
		redirect('/');

	}
}

