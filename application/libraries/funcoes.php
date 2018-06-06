<?php  
    defined('BASEPATH') OR exit('No direct script access allowed');

class Funcoes
{

    private $CI; // Receberá a instância do Codeigniter
  
    public function __construct(){
      $this->CI = &get_instance();
    }


    function move_upload($codigoUser){
        $this->CI->load->library('ftp');
        $validacao = false;

        $modulo = isset($_POST['modulo']) ? htmlspecialchars($_POST['modulo']) : null;
        $categoria = $codigoUser;
        $subcategoria = isset($_POST['subcategoria']) ? htmlspecialchars($_POST['subcategoria']) : null;
        $subcategoria2 = isset($_POST['subcategoria2']) ? htmlspecialchars($_POST['subcategoria2']) : null;
      
        if($modulo != null AND $categoria != null AND $subcategoria != null)
          $validacao = true;
      
        if($validacao != false){
      
          $uploaddir = "uploads/temp/$modulo/$subcategoria/$subcategoria2/";
          if(file_exists($uploaddir)){
             $uploaddir2 = "uploads/$modulo/$categoria/$subcategoria/$subcategoria2/";
          if(!file_exists($uploaddir2))//verifica se o diretório já não existe
            mkdir($uploaddir2,0755, true);

              $uploadfile = $uploaddir2 . basename($_FILES['userfile']['name']);
            
          if($_FILES['userfile']['size'] <= 4096000 AND ($_FILES['userfile']['type'] == "image/png" OR $_FILES['userfile']['type'] == "image/jpeg")){
            //var_dump($_FILES);
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
               array_map('unlink', glob("uploads/temp/$modulo/$subcategoria/$subcategoria2/*"));//remove o arquivo da pasta temp
              return true;
              } else {
                echo "Possível ataque de upload de arquivo!\n";
               
                //$this->CI->ftp->chmod("uploads/$modulo/$categoria/",0755);
                //array_map('unlink', glob("uploads/$modulo/$categoria/*"));//remove o arquivo da pasta temp
                $this->CI->ftp->delete_dir("uploads/$modulo/*");
            }
          }
          $this->CI->ftp->delete_dir("uploads/temp/$modulo/$subcategoria/$subcategoria2/");
          array_map('unlink', glob("uploads/temp/$modulo/$subcategoria/$subcategoria2/*"));//remove o arquivo da pasta temp
      
        }
        else{
          echo "Erro ao receber informações do upload";
          var_dump($categoria);
          return false;
        }
        }
  }//move upload

   function removerMascaras($consulta){//remove os caracateres inseridos pelas mascaras

    $consulta=str_replace("-", "", $consulta);
    $consulta=str_replace(".", "", $consulta);
    $consulta=str_replace("(", "", $consulta);
    $consulta=str_replace(")", "", $consulta);
    $consulta=str_replace("/", "", $consulta);
    $consulta=str_replace(" ", "", $consulta);
     return $consulta;
  }

  function buscarDados($tabela='', $elementos='', $condicao=array()){
    /*Realiza a busca dos dados encontrados na tabela de acordo com a(s)
     condicao(es) e elemento(s) informada(s) no array where*/
    $this->CI->db->select($elementos);
      $this->CI->db->where($condicao);
   return $this->CI->db->get($tabela)->row_array();
  }

  function filtrarDisciplinaProfessor($horario=""){//RECEBE OS DADOS DA TABELA HORARIOS TURMA E OS TRATA

    $dados=isset($horario) ? explode("-", $horario) : null;
    $idprofessor=$dados['0'];
    $iddisciplina=$dados['1'];   
      $consultarHorario= $this->CI->db->query("SELECT * FROM disciplina, professor WHERE disciplina.idDisciplinas='$iddisciplina' AND professor.idProfessor='$idprofessor'")->result_array();
      if($consultarHorario!=NULL){
        foreach ($consultarHorario as $value){
          $nome_p = explode(" ", $value['nome']);
          echo "<td title='".$value['nome_disciplina']."'>"."<span class=\"glyphicon glyphicon-book\" aria-hidden=\"true\" title='Disciplina'></span>"
          .$value['abreviatura']
          ."<br />"
          ."<span class=\"glyphicon glyphicon-education\" aria-hidden=\"true\" title='Professor'></span>".
          $nome_p['0']." ".$nome_p['1']."</td>";
        }
      }else{echo"<td> - </td>";} 
    }

  function gerarCodigo($tamanho){//Gera um codigo de validaçao
    $characters = '0123456789';
    $codigo='';
    $tamanhoDados=strlen($characters);
    for($i=1;$i<=$tamanho; $i++){
      $codigo.=$characters[rand(0,$tamanhoDados-1)];
    }
    return $codigo;
  }

  function validarCodigo($tabela, $tipoCodigo, $tamanho){//verifica se o codigo gerado ja nao esta cadastrado
    //$tipoCodigo nome do campo dentro da tabela $tamanho quantidade de caracteres a serem gerados
      $codigo=$this->gerarCodigo($tamanho);
      $validaCodigo=$this->CI->db->select("$tipoCodigo");
        $resultado = $this->CI->db->get($tabela)->row_array();
      if($resultado!=NULL){
        foreach ($resultado as $dados){
          while($dados == $codigo){
            $codigo=gerarCodigo($tamanho);
          }
        }
       }
     return $codigo;
   }

  function addUser($nivel='', $cpf, $dataNascimento){
    $dataNascimento=explode("-", $dataNascimento);
    $data=$dataNascimento['2'].$dataNascimento['1'].$dataNascimento['0'];
    $codigoUser = $this->validarCodigo('usuario', 'codigo_user', 4);
    $dadosUser = array(
      'codigo_user' =>  $codigoUser,
      'login' => $cpf,
      'senha' => $data,
      'nivel' => $nivel
    );
    $this->CI->load->model('crud_model');
     $this->CI->crud_model->do_insert('usuario', $dadosUser);
      $dadosUser = array(
        'idUsuario'=>$this->CI->db->insert_id(),
        'codigo_user' => $codigoUser
      );
     return  $dadosUser;
  }

  function cadastrarEndereco(){
   /******************************* DADOS DO ENDERECO ******************************************/
   $zonaresidencia = isset($_POST['zonaresidencia']) ? htmlspecialchars($_POST['zonaresidencia']) : null;
   $endereco = isset($_POST['endereco']) ? htmlspecialchars($_POST['endereco']) : null;
   $numero = isset($_POST['numero']) ? htmlspecialchars($_POST['numero']) : null;
   $complemento = isset($_POST['complemento']) ? htmlspecialchars($_POST['complemento']) : null;
   $bairro = isset($_POST['bairro']) ? htmlspecialchars($_POST['bairro']) : null;
   $uf = isset($_POST['uf_endereco']) ? htmlspecialchars($_POST['uf_endereco']) : null;
   $cep = isset($_POST['cep']) ? htmlspecialchars($_POST['cep']) : null;
     $cep=$this->CI->funcoes->removerMascaras($cep);
   $municipio = isset($_POST['municipio']) ? htmlspecialchars($_POST['municipio']) : null;
   /****************************************************************************************/
    

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

  $this->CI->crud_model->do_insert('endereco',$dadosEndereco);
  
  return $this->CI->db->insert_id();//resgata o id do endereco cadastrado        

  }

  function cadastrarContato(){
      
    /*********************************** DADOS CONTATO *******************************************/
    $telefoneresidencial = isset($_POST['fixo']) ? htmlspecialchars($_POST['fixo']) : null; 
    $telefoneresidencial=$this->CI->funcoes->removerMascaras($telefoneresidencial);
    $celular = isset($_POST['cell1']) ? htmlspecialchars($_POST['cell1']) : null;  
    $celular=$this->CI->funcoes->removerMascaras($celular);
    $celular2 = isset($_POST['cell2']) ? htmlspecialchars($_POST['cell2']) : null;  
    $celular2=$this->CI->funcoes->removerMascaras($celular2);
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;

    $dadosContato= array(
      'email' => $email, 
      'celular' => $celular, 
      'celular_2' => $celular2, 
      'telefone_residencial' => $telefoneresidencial
  );

  $this->CI->crud_model->do_insert('contato',$dadosContato);
  return $this->CI->db->insert_id();

  }

  function listarEscolaDiretor(){
   
    $consultarIdDiretor = $this->buscarDados('diretor', 'idDiretor, cpf', 
    $condicao=array(
    'cpf' => $_SESSION['logged']['login']
    ));
  
    $idDiretor = $consultarIdDiretor['idDiretor'];

     $consulta = $this->buscarDados('funcionarios', 'idEscola', 
     $condicao=array(
      'idFuncionario' => $idDiretor
     ));


     if($consulta!=NULL){
      $idEscola = $consulta['idEscola'];
      $consulta = $this->buscarDados('escola', 'idEscola, nome_escola, codigoEscola', 
      $condicao=array(
       'idEscola' => $idEscola
      ));
     if($consulta!=NULL){
       echo '<option value="'.$consulta['codigoEscola'].'">'.$consulta['nome_escola'].' - '.$consulta['codigoEscola'].'</option>';
     }else{
       echo "<option value=\"0\">Dados não econtrados!</option>";
     }
    }else{
      echo "Erro na validação do Usuário!";
      $this->session->sess_destroy();
      $this->session->sess_regenerate([$destroy = TRUE]);//destroi os dados da sessao anterior impedindo o retorno a pagina anterior
      redirect('/login');
    }
  }
 
  function listarModalidade(){
     $consultar = $this->CI->db->get('modalidade_de_ensino')->result_array();
     if($consultar!=NULL):
        foreach($consultar as $consulta):
          echo '<option value="'.$consulta['nome'].'">'.$consulta['nome'].'</option>
         ';
        endforeach;
      else:
       echo '<option value="0">Dados não econtrados!</option>';
     endif;
    }
  
  function listarEtapa(){
    $consultar = $this->CI->db->get('etapas_de_ensino')->result_array();
     if($consultar!=NULL):
        foreach($consultar as $condicao):
          echo '<option value="'.$condicao['tipo'].'">'.$condicao['tipo'].' - '.$condicao['descricao'].'</option>';
        endforeach;
      else:
       echo '<option value="0">Dados não econtrados!</option>';
     endif;
  }

  function listarMediacao(){
     $consultar = $this->CI->db->get('mediacao')->result_array();
     if($consultar!=NULL):
        foreach($consultar as $consulta):
          echo '<option value="'.$consulta['nome'].'">'.$consulta['nome'].'</option>';
        endforeach;
      else:
       echo '<option value="0">Dados não econtrados!</option>';
    endif;
  }


    function listarAnoEnsino(){
       $consultar = $this->CI->db->get('ano_ensino')->result_array();
       if($consultar!=NULL):
         foreach($consultar as $valor):
           echo "<option value=\"$valor[ano_serie]\">$valor[ano_serie] - $valor[etapa_ensino]</option>";
         endforeach;
       else:
         echo "<option value=\"0\">Dados não econtrados!</option>";
       endif;
    }

    function listarOrgaoEmissor(){
      $consultar = $this->CI->db->get('orgao_expedidor')->result_array();
       if($consultar!=NULL){
         foreach($consultar as $dados){
             echo"<option value=\"$dados[codigo_orgao]\">$dados[codigo_orgao] - $dados[descricao]</option>";
         }
         
       }else{
         echo"<option value=\"0\">Dados nao Cadastrados</option>";
       }
    }

    function listarUf(){ 
      $consultar = $this->CI->db->get('estado')->result_array();
      if($consultar!=NULL){
        foreach($consultar as $valor){
          echo "<option value=\"$valor[nome]\">$valor[nome] - $valor[uf]</option>";
        }
      }else{
        echo "<option value=\"0\">Dados não econtrados!</option>";
      }
    }

    function listarMunicipio(){
      $consultar =  $this->CI->db->query('SELECT DISTINCT * FROM cidades order by municipio asc')->result_array();
     // $consultar = $this->CI->db->get('cidades')->result_array();
      if($consultar!=NULL){
        foreach($consultar as $valor){
          echo "<option value=\"$valor[municipio]\">$valor[municipio]</option>";
         }
       }else{
         echo "<option value=\"0\">Dados não econtrados!</option>";
       }
    }

    function listarTurmaEscola(){
      
      $consultarIdDiretor = $this->buscarDados('diretor', 'idDiretor, cpf', 
        $condicao=array(
          'cpf' => $_SESSION['logged']['login']
        ));
    
      $idDiretor = $consultarIdDiretor['idDiretor'];
  
       $consulta = $this->buscarDados('funcionarios', 'idEscola', 
       $condicao=array(
        'idFuncionario' => $idDiretor
       ));

       if($consulta!=NULL){
        $idEscola = $consulta['idEscola'];

        $this->CI->db->select('*');
        $this->CI->db->where(array('idEscola' => $idEscola));
        $consulta = $this->CI->db->get('turma')->result_array();

       if($consulta!=NULL){
         foreach($consulta as $valor){
           echo '<option value="'.$valor['idTurma'].'">';
           echo $valor['nome_turma'].' / '.$valor['ano_ensino'].' '.$valor['etapa'] .' / '. $valor['modalidade'].' - '.$valor['dias_semana'] .' -  das '. date("H:i",strtotime($valor['horario_inicio'])) .' as '.date("H:i",strtotime($valor['horario_termino'])).'</option>';
         }
       }else{
         echo "<option value=\"0\">Turma não encontrada!</option>";
       }
      }else{
        echo "Erro na validação do Usuário!";
        $this->session->sess_destroy();
        $this->session->sess_regenerate([$destroy = TRUE]);//destroi os dados da sessao anterior impedindo o retorno a pagina anterior
        redirect('/login');
      }
    }

    function enderecoContatos(){//insere na pagina os campos para cadastro de endereço e contatos

      echo '
      <fieldset class="legenda">
         <legend>Endereço</legend>
      
          <div class="row">
            <div class="col-md-12">
              <div class="input-group">
                <label for="zonaresidencia" class="control-label groupsmall">Localização / Zona de residência</label>
                <div class="controls groupsmall">
                <label class="checkbox-inline">
                <input type="radio" name="zonaresidencia" value="zona urbana" />  Zona urbana</label>
                <label class="checkbox-inline">
                <input type="radio" name="zonaresidencia" value="zona rural" />  Zona rural</label>
              </div>
             </div><!-- GRUPO zona localizacao -->
            </div>
          </div>
      
          <div class="row">   
            <div class="col-md-6 col-xs-12">
             <div class="input-group">
                <span class="input-group-addon">
                <label for="cep">CEP</label>
                </span>
      
                <input class="form-control" type="text" id="cep" name="cep" onkeypress="mascarar(this,\'cep\')" onfocusout="validarTamanho(this,8)"  placeholder="Código de endereçamento postal" required/> 
              </div>
              </div>
      
              <div class="col-md-6 col-xs-12">
               <div class="input-group">
                  <span class="input-group-addon">
                  <label for="endereco">Endereço</label>
                  </span>
                  <input class="form-control" type="text" id="endereco" name="endereco" placeholder="Nome da rua, avenida, condomínio, residêncial, etc.." required/> 
                </div>
              </div>
          </div>
      
         <div class="row">   
         <div class="col-md-3 col-xs-12">
           <div class="input-group">
            <span class="input-group-addon">
            <label for="numero">Número</label>
            </span>
            <input class="form-control" type="text" id="numero" name="numero" placeholder="Número da residência
      " required/>
           </div>
         </div>
         
          <div class="col-md-3 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon">
              <label for="bairro">Bairro</label> 
              </span>
              <input class="form-control" type="text" id="bairro" name="bairro" placeholder="Bairro do endereço"  required/>
            </div>
          </div>   
         
         <div class="col-md-6 col-xs-12">
           <div class="input-group">
            <span class="input-group-addon">
            <label for="complemento">Complemento</label>
            </span>
            <input class="form-control" type="text" id="complemento" name="complemento" placeholder="Complemento do endereço (Ex: casa 1; Bloco A, Box. 100)" required/>
           </div>
          </div>
         </div>   
         
        <div class="row">   
         <div class="col-md-4 col-xs-12">
           <div class="input-group">
            <span class="input-group-addon">
            <label for="uf_endereco">UF</label>
            </span>
            <div class="controls">
            <select class="form-control selectwidth" name="uf_endereco" id="uf_endereco" onchange="carregarCidadesEstado(this.value,\'municipio\')" required>
            <option value="0">Selecione o Estado</option>
            ';
            $this->listarUf();
            echo'
            </select>
            </div>
          </div>
        </div>
         
        <div class="col-md-6 col-xs-12">
         <div class="input-group">
          <span class="input-group-addon">
          <label for="municipio">Município</label>
          </span>
          <div class="controls">
          <select class="form-control selectwidth" name="municipio" id="municipio" required>
          <option value="0">Município do endereco</option>
          </select>
          </div>
        </div>
      
      </div>
      </fieldset>
      
      <fieldset class="legenda">
         <legend>Contatos</legend>
      
         <div class="row">
         <div class="col-xs-12 col-md-6">
       <div class="input-group">
        <span class="input-group-addon">
        <label class="control-label" for="emailescola">@ E-mail</label>
        </span>
        <div class="controls">
        <input class="form-control" type="email" id="email" name="email" placeholder="Correio eletrônico da escola" required/>
        </div>
       </div><!-- GRUPO Email -->
         </div>
      
         <div class="col-xs-12 col-md-6">
       <div class="input-group">
        <span class="input-group-addon">
        <label class="control-label" for="fixo">Telefone Fixo</label>
        </span>
        <div class="controls">
        <input class="form-control" type="tel" id="fixo" name="fixo" placeholder="Número de telefone residêncial" onkeypress="mascarar(this,\'telefone\')" required/>
        </div>
       </div><!-- GRUPO-->
         </div>
         </div>
      
      <div class="row">
         <div class="col-xs-12 col-md-6">
       <div class="input-group">
        <span class="input-group-addon">
        <label class="control-label" for="cell1">Celular</label>
        </span>
        <div class="controls">
        <input class="form-control" type="telephone" id="cell1" name="cell1" placeholder="Número de celular" onkeypress="mascarar(this,\'celular\')" required/>
        </div>
       </div><!-- GRUPO celular1 -->
         </div>
      
         <div class="col-xs-12 col-md-6">
       <div class="input-group">
        <span class="input-group-addon">
        <label class="control-label" for="cell2">Celular 2</label>
        </span>
        <div class="controls">
        <input class="form-control" type="telephone" id="cell2" name="cell2" placeholder="Número de celular alternativo" onkeypress="mascarar(this,\'celular\')" required/>
        </div>
       </div><!-- GRUPO Celular 2-->
         </div>
         </div>
      
      </fieldset>
      
      ';
      
      }

      function gerarMatricula($tamanho){//Gera um codigo de validaçao
        $numeros='0123456789';
        $codigo=date('Y');//PEGA O ANO ATUAL DA MATRICULA DO ALUNO
        $tamanhoDados=strlen($numeros);
  
        for($i=1;$i<=$tamanho-4; $i++){//-4 pra descontar os caracteres do ano que seram incluidos
          $codigo.=$numeros[rand(0,$tamanhoDados-1)];
        }
        return $codigo;
    }
    function validarMatricula($tamanho){//verifica se o codigo gerado ja nao esta cadastrado
        $codigo=$this->gerarMatricula($tamanho);
        $this->CI->db->select("matricula");
            foreach ($this->CI->db->get("aluno")->result_array() as $dados):
                while($dados['matricula'] == $codigo){
                    $codigo=gerarMatricula($tamanho);
                }
            endforeach;
        return $codigo;
    }
      function validarVagas($idTurma){//verifica se vagas na turma

        $turma = $this->CI->db->query("SELECT DISTINCT vagas_restantes, maximo_vagas FROM turma WHERE idTurma = '$idTurma'")->result_array();

        if($turma!=NULL){
          foreach($turma as $valores){
            if($valores['vagas_restantes']<=$valores['maximo_vagas'] AND $valores['vagas_restantes']!='0'){
              return true;
            }else{
              return false;
            }
          }
      
          }else{
            echo'Turma não encontrada!';
            exit();
            return false;
          }
      
      }

      function atualizarVagasTurma($idTurma){//atualiza o numero de vagas da turma

        $vagas= $this->CI->db->query("SELECT  vagas_restantes FROM turma WHERE idTurma = '$idTurma'")->result_array();

          if($vagas['0']['vagas_restantes']>0){
            $attVagas = $vagas['0']['vagas_restantes']-1;

            $this->CI->db->set('vagas_restantes',$attVagas);
            $this->CI->db->where('idTurma', $idTurma);
            $this->CI->db->update('turma');
            return true;
           }else{
            echo'Erro ao atualizar as vagas da turma!';
            exit();
            return false;
           }

      }//Atualizar Vagas da Turma

      function listarTurma(){
        $consulta=$this->CI->db->query("SELECT idTurma, ano_ensino, dias_semana, etapa, modalidade, nome_turma, dias_semana, horario_inicio, horario_termino  FROM turma")->result_array();      
          if(count($consulta)>0){
            foreach($consulta as $valor){
              echo "<option value=\"$valor[idTurma]\">$valor[ano_ensino] $valor[etapa] / $valor[modalidade] - $valor[nome_turma] - $valor[dias_semana] - das ".date("H:i",strtotime($valor['horario_inicio'])) ." as ".date("H:i",strtotime($valor['horario_termino']))."</option>";
            }
          }else{
            echo "<option value=\"0\">Dados não econtrados!</option>";
          }
      }

      function listarDisciplinas(){
           $consulta=$this->CI->db->query("SELECT idDisciplinas, nome_disciplina FROM disciplina")->result_array();
           if(count($consulta)>0){
            foreach($consulta as $dados){
              echo"
                <option value=\"$dados[idDisciplinas]\">$dados[nome_disciplina]</option>
              ";
            }
         }else{
           echo "<span class=\"error\">Disciplinas nao Cadastradas!</spa>";
        }
      }

   /******************  JAVA SCRIPT *************************/ 
  function scripts(){
    echo'
    <script type="text/javascript">
  
    function carregarCidades(estado) {//CARREGA A LISTA DE NOTAS DO ALUNO ESCOLHID0
        if (estado == "0") { 
         document.getElementById("municipio").innerHTML ="Erro ao Selecionar Estado!";
         return;
        } else {
         var xmlhttp = new XMLHttpRequest();
         xmlhttp.onreadystatechange = function() {
          document.getElementById("municipio").innerHTML = this.responseText;
         };
         var tipo="estado";
         xmlhttp.open("GET","http://localhost/xampp/avance/assets/inc/carregarBuscas.php?modulo="+tipo+"&buscar="+estado, true);
         xmlhttp.send();
        }
    }
    function carregarCidadesEstado(estado, campo) {
        if (estado == "0") { 
         document.getElementById(campo).innerHTML ="Erro ao Selecionar Estado!";
         return;
        } else {
         var xmlhttp = new XMLHttpRequest();
         xmlhttp.onreadystatechange = function() {
          document.getElementById(campo).innerHTML = this.responseText;
         };
         var tipo="estado";
         xmlhttp.open("GET","http://localhost/xampp/avance/assets/inc/carregarBuscas.php?modulo="+tipo+"&buscar="+estado, true);
         xmlhttp.send();
        }
    }
    function habilitarCampo(campo, consulta){
      if(consulta == "sim"){
        document.getElementById(campo).disabled = 0;
      }else{
      document.getElementById(campo).disabled = 1;
      }
    }
    </script>
    ';
  }

}