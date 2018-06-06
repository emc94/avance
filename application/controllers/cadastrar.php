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

        $funcionario = $this->funcoes->buscarDados('funcionarios', 'idEscola', 
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
    }//cadastrar Professor


    public function cadastrarTurma(){

		$nome = isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : null;
        $ano_letivo = isset($_POST['ano_letivo']) ? htmlspecialchars($_POST['ano_letivo']) : null;
        $mediacao  = isset($_POST['mediacao']) ? htmlspecialchars($_POST['mediacao']) : null;	
        $turno	= isset($_POST['turno']) ? htmlspecialchars($_POST['turno']) : null;
        $horario_inicio =  isset($_POST['horario_inicio']) ? htmlspecialchars($_POST['horario_inicio']) : null;
		$horario_termino = isset($_POST['horario_termino']) ? htmlspecialchars($_POST['horario_termino']) : null;
		$dias =  isset($_POST['dias']) ? $_POST['dias'] : null;
		$modalidade  = isset($_POST['modalidade']) ? htmlspecialchars($_POST['modalidade']) : null;	
		$anoensino = isset($_POST['anoensino']) ? htmlspecialchars($_POST['anoensino']) : null;
		$etapa	= isset($_POST['etapa']) ? htmlspecialchars($_POST['etapa']) : null;
		$maximo_vagas	= isset($_POST['total_vagas']) ? htmlspecialchars($_POST['total_vagas']) : null;

        $escola =  $this->funcoes->buscarDados('funcionarios', 'idEscola', $condicao=array('cpf' => $_SESSION['logged']['login']));
        $dias_semana = NULL;

        foreach($dias as $value):
            $dias_semana =  $value."/".$dias_semana;
        endforeach;

    $this->db->trans_begin();

        $dadosTurma=array(
            'idEscola' => $escola['idEscola'],
            'nome_turma' => $nome,
            'mediacao' => $mediacao,
            'horario_inicio' =>  $horario_inicio,
            'horario_termino' =>$horario_termino,
            'dias_semana' => $dias_semana,
            'modalidade' => $modalidade,
            'etapa' => $etapa,
            'ano_ensino' => $anoensino,
            'maximo_vagas' => $maximo_vagas,
            'vagas_restantes' => $maximo_vagas,
            'ano_letivo' => $ano_letivo,
            'turno' =>  $turno

        );
 
        //cadastra o funcionario
        $this->crud_model->do_insert('turma', $dadosTurma);
        
        if ($this->db->trans_status() === FALSE)
          {
           $this->db->trans_rollback();
            echo 'Erro ao realizar cadastro!';
        }
        else
        {
            $this->db->trans_commit();
            $pagina = 'gerenciar/turmas';
            redirect(base_url($pagina));
            //redireciona para a pagina escolhida
        }
    }//cadastrar Turma

     function cadastrarAluno(){
        //Valida se o diretor e escola são válidos
        $consultarIdDiretor = $this->funcoes->buscarDados('diretor', 'idDiretor, cpf',$condicao=array('cpf' => $_SESSION['logged']['login']));
        $idDiretor = $consultarIdDiretor['idDiretor'];
        $consulta = $this->funcoes->buscarDados('funcionarios', 'idEscola', $condicao=array('idFuncionario' => $idDiretor));
        $validarUser = TRUE;
        if($consulta != NULL){//se o diretor for encontrado na tabela funcionários
          $idEscola = $consulta['idEscola'];
          $consulta = $this->funcoes->buscarDados('escola', 'idEscola, nome_escola, codigoEscola', 
          $condicao=array(
           'idEscola' => $idEscola
          ));
         if($consulta!=NULL){//se a escola for encontrada
           $escola = $consulta['codigoEscola'];
         }else{
            $validarUser = FALSE; 
         }
        }else{
            $validarUser = FALSE; 
         }
        if( $validarUser != TRUE){
            $this->session->sess_destroy();
            $this->session->sess_regenerate([$destroy = TRUE]);//destroi os dados da sessao anterior impedindo o retorno a pagina anterior
            redirect('/login');
         }

        /*********************************** DADOS DO ALUNO *******************************************/
        $nome = isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : null;
        $datanascimento = isset($_POST['datanascimento']) ? htmlspecialchars($_POST['datanascimento']) : null;
        $sexo = isset($_POST['sexo']) ? htmlspecialchars($_POST['sexo']) : null;
        $cor = isset($_POST['cor']) ? htmlspecialchars($_POST['cor']) : null;
        $nomemae = isset($_POST['nome_mae']) ? htmlspecialchars($_POST['nome_mae']) : null;
        $nomepai = isset($_POST['nome_pai']) ? htmlspecialchars($_POST['nome_pai']) : null;
        $nomeresponsavel = isset($_POST['nome_responsavel']) ? htmlspecialchars($_POST['nome_responsavel']) : null;
        $declaradoignorado = isset($_POST['ignorado']) ? htmlspecialchars($_POST['ignorado']) : 'n';
        $nacionalidade = isset($_POST['nacionalidade']) ? htmlspecialchars($_POST['nacionalidade']) : null;
        $ufnascimento = isset($_POST['ufnascimento']) ? htmlspecialchars($_POST['ufnascimento']) : null;
        $municipionascimento = isset($_POST['municipionascimento']) ? htmlspecialchars($_POST['municipionascimento']) : null;
        /*********************************** DADOS DO CERTIDAO *******************************************/
        $certidaonascimento = isset($_POST['ncertidao']) ? htmlspecialchars($_POST['ncertidao']) : null;
        $numerotermo = isset($_POST['n_termo']) ? htmlspecialchars($_POST['n_termo']) : null;
        $folha = isset($_POST['n_folha']) ? htmlspecialchars($_POST['n_folha']) : null;
        $livro = isset($_POST['livro']) ? htmlspecialchars($_POST['livro']) : null;
        $dataemissao = isset($_POST['data_emissao']) ? htmlspecialchars($_POST['data_emissao']) : null;
        $ufcartorio = isset($_POST['uf_cartorio']) ? htmlspecialchars($_POST['uf_cartorio']) : null;
        $municipiocartorio = isset($_POST['municipio_cartorio']) ? htmlspecialchars($_POST['municipio_cartorio']) : null; 
        $nomecartorio  = isset($_POST['nome_cartorio']) ? htmlspecialchars($_POST['nome_cartorio']) : null;
        $identidade  = isset($_POST['identidade']) ? htmlspecialchars($_POST['identidade']) : null;
            $identidade = $this->funcoes->removerMascaras($identidade);
        $cpf  = isset($_POST['cpf']) ? htmlspecialchars($_POST['cpf']) : null;
            $cpf = $this->funcoes->removerMascaras($cpf);
        $orgaoexpedidor = isset($_POST['orgaoex']) ? htmlspecialchars($_POST['orgaoex']) : null;
        $ufidentidade = isset($_POST['uf_identidade']) ? htmlspecialchars($_POST['uf_identidade']) : null;
        $dataexpedicao = isset($_POST['data_expedicao']) ? htmlspecialchars($_POST['data_expedicao']) : null;
        $deficiente = isset($_POST['deficiencia']) ? htmlspecialchars($_POST['deficiencia']) : 'n';
        $turma = isset($_POST['turma']) ? htmlspecialchars($_POST['turma']) : null;

        $dataNascimento=explode("-", $datanascimento);
        $data = $dataNascimento['2'].$dataNascimento['1'].$dataNascimento['0'];//organizar ordem desses index talves seja 0 1 2
        $senha = $data;
        

        if($this->funcoes->validarVagas($turma) == TRUE)://se houver vagas na turma
            //Inicia uma trasação no banco de dados
            $this->db->trans_begin();

            $idEndereco = $this->funcoes->cadastrarEndereco();
            $codigoContato = $this->funcoes->cadastrarContato();

            $dadosAluno = array(
                'codigoEscola' => $escola,
                'matricula' => $this->funcoes->validarMatricula(9),
                'idEndereco' => $idEndereco,
                'codigoContato' => $codigoContato,
                'idTurma' => $turma,
                'nome' => $nome,
                'data_nascimento' => $datanascimento,
                'sexo' => $sexo,
                'cor_raca' => $cor,
                'nome_mae' => $nomemae,
                'nome_pai' => $nomepai,
                'nome_responsavel' => $nomeresponsavel,
                'declarado_ignorado' => $declaradoignorado,
                'deficiente' => $deficiente,
                'nacionalidade' => $nacionalidade,
                'uf_nascimento' => $ufnascimento,
                'municipio_nascimento' => $municipionascimento,
                'certidao_nascimento' => $certidaonascimento,
                'numero_termo' => $numerotermo,
                'folha' => $folha,
                'livro' => $livro,
                'data_emissao' => $dataemissao,
                'uf_cartorio' => $ufcartorio,
                'municipio_cartorio' => $municipiocartorio,
                'nome_cartorio' => $nomecartorio,
                'identidade' => $identidade,
                'cpf' => $cpf,
                'orgao_expedidor' => $orgaoexpedidor,
                'uf_identidade' => $ufidentidade,
                'data_expedicao' => $dataexpedicao,
                'senha' => $senha
            );

        //cadastra o Aluno
        $this->crud_model->do_insert('aluno', $dadosAluno);
        //confirma se a transação foi bem sucedida

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            echo 'Erro ao realizar cadastro!';
        }
        else
        {
            //Atualiza as vagas da turma
            if($this->funcoes->atualizarVagasTurma($turma)!=false):
                $this->db->trans_commit();
                $pagina = 'gerenciar/alunos';
                redirect(base_url($pagina));
                //redireciona para a pagina escolhida
            else:
                echo"Erro ao atualizar a quantidade de vagas da turma!";  
            endif;
        }
    else://se não houverem vagas na turma
        //echo"Não há vagas na turma selecionada!";
        $pagina = 'cadastrar/aluno';
        redirect(base_url($pagina));
        //redireciona para a pagina escolhida
    endif;    

    }//cadastrarAluno

    function horarioturma(){//cadastrar horário da turma
        $this->load->library('validacoeshorario');

        if(isset($_POST['turma']) AND $_POST['turma']!=null){

            $this->db->trans_begin();

            $disciplina = isset($_POST['disciplina']) ? htmlspecialchars($_POST['disciplina']) : null;
            $turma = isset($_POST['turma']) ? htmlspecialchars($_POST['turma']) : null;
            $professor = isset($_POST['professor']) ? htmlspecialchars($_POST['professor']) : null;
            $horarioInicio = isset($_POST['horario_inicio']) ? htmlspecialchars($_POST['horario_inicio'].":00") : null;
            $horarioTermino = isset($_POST['horario_termino']) ? htmlspecialchars($_POST['horario_termino'].":00") : null;
            $diaSemana = isset($_POST['dias']) ? htmlspecialchars($_POST['dias']) : null;
    
            $aula= $professor."-".$disciplina;

            $validarHorario = $this->validacoeshorario->validarDisponibilidade($professor, $horarioInicio, $horarioTermino, $diaSemana, $turma);
    
            if($validarHorario == TRUE){
                $this->db->set($diaSemana,$aula);
                $this->db->where("idTurma='$turma' AND horario_inicio_aula='$horarioInicio' AND horario_termino_aula = '$horarioTermino'");                   
                if($this->db->update('horario_turma') != FALSE){
                    $validarNotas = $this->validacoeshorario->validarNotas($turma,$disciplina,$professor);//recebe o id da turma, professor e disciplina
                    if($validarNotas==true){//se o horario for atualizado
                        $this->db->trans_commit();
                        redirect("/notificacoes/sucesso/1001/cadastrar-horario");
                    }else{//caso o horario nao seja atualizado
                        $this->db->trans_rollback();
                        $dados=array(
                        );
                        redirect("/notificacoes/error/1050/cadastrar-horario");
                    }
                }
            }else{//caso os professores ja estejam cadastrado em alguma outra turma
                $this->db->trans_rollback();
                redirect("/notificacoes/error/1010/cadastrar-horario");
            }
        }else{
            redirect("/notificacoes/error/1042/cadastrar-horario");
        }

    }//horario turma


}//class controller cadastrar