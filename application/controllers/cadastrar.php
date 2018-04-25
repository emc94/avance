<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastrar extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url'); //carrega o helper para urls
        $this->load->helper('form');
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('funcoes'); //biblioteca de funcoes personalizadas
        $this->load->model('crud_model');
    }

    public function escola(){//formulario de cadastro escola
        $this->template->load('template','cadastros/escola');
    }
    public function diretor(){//formulario de cadastro diretor
        $this->template->load('template','cadastros/diretor');
    }

    public function professor(){//formulario de cadastro professor
        $this->template->load('template','cadastros/professor');
    }

    public function aluno(){//formulario de cadastro aluno
        $this->template->load('template','cadastros/aluno');
    }

    public function turma(){//formulario de cadastro turma
        $this->template->load('template','cadastros/turma');
    }

    public function horario(){//formulario de cadastro horario
        $this->template->load('template','cadastros/horario');
    }

    public function nota(){//formulario de cadastro notas
        $this->template->load('template','cadastros/nota');
    }

    public function falta(){//formulario de cadastro faltas
        $this->template->load('template','cadastros/faltas');
    }

    public function cadastrarEscola(){

        //Validação dos campos do formulário de cadastro da escola
        $this->form_validation->set_rules('e_nome','Nome', 'trim|required|min_length[5]|max_length[200]');
        $this->form_validation->set_rules('situacao','Situacao', 'required');

        $e_nome = isset($_POST['e_nome']) ? htmlspecialchars($_POST['e_nome']) : null;
        $situacao = isset($_POST['situacao']) ? htmlspecialchars($_POST['situacao']) : null;
        $anoletivo = isset($_POST['anoletivo']) ? htmlspecialchars($_POST['anoletivo']) : null;
        $anoletivot = isset($_POST['anoletivot']) ? htmlspecialchars($_POST['anoletivot']) : null;
        $ocupacao = isset($_POST['ocupacao']) ? htmlspecialchars($_POST['ocupacao']) : null;        
        $nsalas = isset($_POST['nsalas']) ? htmlspecialchars($_POST['nsalas']) : null;      
        $nsalasfora = isset($_POST['nsalasfora']) ? htmlspecialchars($_POST['nsalasfora']) : null;
        /********************* ENDERECO **************************/
        $zonaresidencia = isset($_POST['zonaresidencia']) ? htmlspecialchars($_POST['zonaresidencia']) : null;
        $endereco = isset($_POST['endereco']) ? htmlspecialchars($_POST['endereco']) : null;
        $numero = isset($_POST['numero']) ? htmlspecialchars($_POST['numero']) : null;
        $complemento = isset($_POST['complemento']) ? htmlspecialchars($_POST['complemento']) : null;
        $bairro = isset($_POST['bairro']) ? htmlspecialchars($_POST['bairro']) : null;
        $uf = isset($_POST['uf_endereco']) ? htmlspecialchars($_POST['uf_endereco']) : null;
        $cep = isset($_POST['cep']) ? htmlspecialchars($_POST['cep']) : null;
            //$cep=removerMascaras($cep);//remove as mascaras
        $municipio = isset($_POST['municipio']) ? htmlspecialchars($_POST['municipio']) : null;
        /***************** CONTATOS DA ESCOLA ******************/
        $emailescola = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
        $fixo = isset($_POST['fixo']) ? htmlspecialchars($_POST['fixo']) : null;
            //$fixo=removerMascaras($fixo);
        $cell1 = isset($_POST['cell1']) ? htmlspecialchars($_POST['cell1']) : null;
            //$cell1=removerMascaras($cell1);
        $cell2 = isset($_POST['cell2']) ? htmlspecialchars($_POST['cell2']) : null;
            //$cell2=removerMascaras($cell2);
        //Consulta Escola pra ver se existe no banco de dados
            //$dados = elements(array('nome','cpf','senha'),$this->input->post());
            
            $tamanho = 5;
            $characters = '0123456789';
            $codigo='';
            $tamanhoDados=strlen($characters);
            for($i=1;$i<=$tamanho; $i++){
              $codigo.=$characters[rand(0,$tamanhoDados-1)];
            }


        $dadosEndereco = array(
            'cep' => $cep, 
            'endereco' => $endereco, 
            'bairro' => $bairro, 
            'numero' =>  $numero, 
            'complemento' => $complemento, 
            'zona_residencial' => $zonaresidencia, 
            'cidade' => $municipio, 
            'estado' => $uf
        );

        if($this->funcoes->move_upload($codigo) == true):

            $this->db->trans_begin();

                $this->crud_model->do_insert('endereco',$dadosEndereco);

                $idEndereco = $this->db->insert_id();//resgata o id do endereco cadastrado        
                
                $dadosEscola= array(
                    'codigoEscola' => $codigo,
                    'idEndereco' => $idEndereco, 
                    'nome_escola' => $e_nome, 
                    'situacao_funcionamento' => $situacao, 
                    'inicio_ano_letivo' => $anoletivo, 
                    'termino_ano_letivo' => $anoletivot, 
                    'ocupacao_predio' => $ocupacao, 
                    'numero_salas_aula' => $nsalas, 
                    'numero_salas_aula_fora' => $nsalasfora, 
                    'email_escola' => $emailescola, 
                    'telefone' => $fixo, 
                    'celular' => $cell1, 
                    'celular2'=> $cell2,
                    'thumb' => basename($_FILES['userfile']['name'])
                );

             $this->crud_model->do_insert('escola',$dadosEscola);

        if ($this->db->trans_status() === FALSE)
            {
                 $this->db->trans_rollback();
            }
        else
            {
                $this->db->trans_commit();
                $pagina = 'gerenciar/escolas';
                redirect(base_url($pagina));
                //redireciona para a pagina escolhida
            }
        else://caso o upload falhe
            return false;
        endif;

    }//cadastrar escola

    public function cadastrarDiretor(){
        
        $validacao = false;

        /********************* DADOS PESSOAIS **************************/
        $escola = isset($_POST['escola']) ? htmlspecialchars($_POST['escola']) : null;
        $d_nome = isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : null;
        $cpf = isset($_POST['cpf']) ? htmlspecialchars($_POST['cpf']) : null;
            $cpf=$this->funcoes->removerMascaras($cpf);
        $datanascimento = isset($_POST['datanascimento']) ? htmlspecialchars($_POST['datanascimento']) : null;
        $sexo = isset($_POST['sexo']) ? htmlspecialchars($_POST['sexo']) : null;
        $cor = isset($_POST['cor']) ? htmlspecialchars($_POST['cor']) : null;
        /********************* DADOS DO CONTRATO ************************/
        $situacao_contratual = isset($_POST['situacaocontrato']) ? htmlspecialchars($_POST['situacaocontrato']) : null;
        $curso_superior = isset($_POST['cursosuperior']) ? htmlspecialchars($_POST['cursosuperior']) : null;
        $area_curso_superior = isset($_POST['areadocurso']) ? htmlspecialchars($_POST['areadocurso']) : null;
        $complementacao_pedagogica = isset($_POST['formacaopedagogica']) ? htmlspecialchars($_POST['formacaopedagogica']) : null; 
        $pos_graduacao = isset($_POST['posgraduacao']) ? htmlspecialchars($_POST['posgraduacao']) : null;
        $tipopos = isset($_POST['tipopos']) ? htmlspecialchars($_POST['tipopos']) : null;
        $outros_cursos = isset($_POST['outroscursos']) ? htmlspecialchars($_POST['outroscursos']) : null;
       /********************* DADOS DO ENDERECO ************************/
        $zonaresidencia = isset($_POST['zonaresidencia']) ? htmlspecialchars($_POST['zonaresidencia']) : null;
        $endereco = isset($_POST['endereco']) ? htmlspecialchars($_POST['endereco']) : null;
        $numero = isset($_POST['numero']) ? htmlspecialchars($_POST['numero']) : null;
        $complemento = isset($_POST['complemento']) ? htmlspecialchars($_POST['complemento']) : null;
        $bairro = isset($_POST['bairro']) ? htmlspecialchars($_POST['bairro']) : null;
        $uf = isset($_POST['uf_endereco']) ? htmlspecialchars($_POST['uf_endereco']) : null;
        $cep = isset($_POST['cep']) ? htmlspecialchars($_POST['cep']) : null;
          $cep=$this->funcoes->removerMascaras($cep);
        $municipio = isset($_POST['municipio']) ? htmlspecialchars($_POST['municipio']) : null;
          /******************************** DADOS CONTATO *************/
        $telefoneresidencial = isset($_POST['fixo']) ? htmlspecialchars($_POST['fixo']) : null; 
            $telefoneresidencial=$this->funcoes->removerMascaras($telefoneresidencial);
        $celular = isset($_POST['cell1']) ? htmlspecialchars($_POST['cell1']) : null;  
            $celular=$this->funcoes->removerMascaras($celular);
        $celular2 = isset($_POST['cell2']) ? htmlspecialchars($_POST['cell2']) : null;  
            $celular2=$this->funcoes->removerMascaras($celular2);
        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;

        //Consultar se a escola já possui um diretor
        $escola = $this->funcoes->buscarDados('escola', 'idEscola', array('codigoEscola' => $escola));

        $funcionario =$this->funcoes->buscarDados('funcionarios', 'idEscola', 
            $condicao=array(
            'idEscola' => $escola['idEscola'],
            'cargo' => 'diretor',
            'cargo' => 'professor',
            'status' => 'ativo'));

        if($funcionario==NULL){//se a escola nao tiver diretor
            $this->db->trans_begin();
                //cadastra o usuario
                $usuario = $this->funcoes->addUser('d', $cpf, $datanascimento);
                 
                $idEndereco = $this->funcoes->cadastrarEndereco();//resgata o id do endereco cadastrado        
                $codigoContato = $this->funcoes->cadastrarContato();

                $dadosDiretor = array(
                    'idUsuario' => $usuario['idUsuario'],
                    'idEndereco' => $idEndereco,
                    'codigoContato' => $codigoContato,
                    'nome' => $d_nome,
                    'cpf' => $cpf,
                    'datanascimento' => $datanascimento,
                    'sexo' => $sexo,
                    'cor' => $cor,
                    'situacao_contratual' => $situacao_contratual,
                    'curso_superior' => $curso_superior,
                    'area_curso_superior' => $area_curso_superior,
                    'complementacao_pedagogica' => $complementacao_pedagogica,
                    'pos_graduacao' => $pos_graduacao,
                    'tipopos' => $tipopos,
                    'outros_cursos' =>$outros_cursos,
                    'thumb' => basename($_FILES['userfile']['name']) 
                );

                //cadastra o diretor
                $this->crud_model->do_insert('diretor', $dadosDiretor);

                $dadosFuncionario=array(
                    'idFuncionario'=>$this->db->insert_id(),
                    'idEscola' => $escola['idEscola'],
                    'cpf' => $cpf,
                    'cargo' => 'diretor',
                    'status' => 'ativo'
                );

                //cadastra o funcionario
                $this->crud_model->do_insert('funcionarios', $dadosFuncionario);

            if ($this->db->trans_status() === FALSE OR $this->funcoes->move_upload($usuario['codigo_user']) == FALSE)
            {
                 $this->db->trans_rollback();
                 echo 'Erro ao realizar cadastro!';
            }
        else
            {
                $this->db->trans_commit();
                $pagina = 'gerenciar/diretores';
                redirect(base_url($pagina));
                //redireciona para a pagina escolhida
            }
        }//cadastrar diretor

    }//class cadastrar

    public function cadastrarProfessor(){
        $validacao = false;
        /************* DADOS PESSOAIS****************/
        $escola = isset($_POST['escola']) ? htmlspecialchars($_POST['escola']) : null;
        $nome = isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : null;
        $cpf = isset($_POST['cpf']) ? htmlspecialchars($_POST['cpf']) : null;
            $cpf=$this->funcoes->removerMascaras($cpf);
        $datanascimento = isset($_POST['datanascimento']) ? htmlspecialchars($_POST['datanascimento']) : null;
        $sexo = isset($_POST['sexo']) ? htmlspecialchars($_POST['sexo']) : null;
        $cor = isset($_POST['cor']) ? htmlspecialchars($_POST['cor']) : null;
        /*************SITUACAO CONTRATUAL ****************/
        $funcao = isset($_POST['funcao']) ? htmlspecialchars($_POST['funcao']) : null;
        $situacaocontrato = isset($_POST['situacaocontrato']) ? htmlspecialchars($_POST['situacaocontrato']) : null;
        $disciplina = isset($_POST['disciplinas']) ? $_POST['disciplinas'] : null;
        /********** FORMACAO ACADEMICA *******************/
        $cursosuperior = isset($_POST['cursosuperior']) ? htmlspecialchars($_POST['cursosuperior']) : null;
        $areadocurso = isset($_POST['areadocurso']) ? htmlspecialchars($_POST['areadocurso']) : null;
        $formacaopedagogica = isset($_POST['formacaopedagogica']) ? htmlspecialchars($_POST['formacaopedagogica']) : null;
        $posgraduacao = isset($_POST['posgraduacao']) ? htmlspecialchars($_POST['posgraduacao']) : null;
        $tipopos = isset($_POST['tipopos']) ? htmlspecialchars($_POST['tipopos']) : null;
        $outroscursos = isset($_POST['outroscursos']) ? htmlspecialchars($_POST['outroscursos']) : null;

        //Consultar se a escola já possui um diretor
        $escola = $this->funcoes->buscarDados('escola', 'idEscola', array('codigoEscola' => $escola));

        //valida se o professor já e funcionario
        $professor =$this->funcoes->buscarDados('funcionarios', 'idFuncionario', 
            $condicao=array('cpf' => $cpf));

        $disciplinas="";
        foreach($disciplina as $value){
            $disciplinas = $value.$disciplinas;
        }

        if($professor == NULL){//se o professor nao estiver cadastrado
            $this->db->trans_begin();
            $usuario = $this->funcoes->addUser('p', $cpf, $datanascimento);
            
            $idEndereco = $this->funcoes->cadastrarEndereco();
            $codigoContato = $this->funcoes->cadastrarContato();

            $dadosProfessor = array(
                'idUsuario' => $usuario['idUsuario'],
                'idEndereco' => $idEndereco,
                'codigoContato' => $codigoContato,
                'nome' => $nome,
                'cpf' => $cpf,
                'datanascimento' => $datanascimento,
                'sexo' => $sexo,
                'cor' => $cor,
                'situacaocontrato' => $situacaocontrato,
                'disciplinas' => $disciplinas,
                'cursosuperior' => $cursosuperior,
                'areadocurso' => $areadocurso,
                'formacaopedagogica' => $formacaopedagogica,
                'posgraduacao' => $posgraduacao,
                'tipopos' => $tipopos,
                'outroscursos' =>$outroscursos,
                //'thumb' => basename($_FILES['userfile']['name']) 
            );

            //cadastra o Professor
            $this->crud_model->do_insert('professor', $dadosProfessor);
                           
            $dadosFuncionario=array(
                'idFuncionario'=>$this->db->insert_id(),
                'idEscola' => $escola['idEscola'],
                'cpf' => $cpf,
                'cargo' => 'professor',
                'status' => 'ativo'
            );
            
            //cadastra o funcionario
            $this->crud_model->do_insert('funcionarios', $dadosFuncionario);
            
            if ($this->db->trans_status() === FALSE /*OR $this->funcoes->move_upload($usuario['codigo_user']) == FALSE*/)
            {
               $this->db->trans_rollback();
                echo 'Erro ao realizar cadastro!';
            }
            else
            {
                $this->db->trans_commit();
                $pagina = 'gerenciar/professores';
                redirect(base_url($pagina));
                //redireciona para a pagina escolhida
            }
        }
    }//cadastrarProfessor



}//class controller cadastrar