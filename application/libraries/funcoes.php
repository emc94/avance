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

   function removerMascaras($valor){//remove os caracateres inseridos pelas mascaras

    $valor=str_replace("-", "", $valor);
    $valor=str_replace(".", "", $valor);
    $valor=str_replace("(", "", $valor);
    $valor=str_replace(")", "", $valor);
    $valor=str_replace("/", "", $valor);
    $valor=str_replace(" ", "", $valor);
     return $valor;
  }

  function buscarDados($tabela='', $elementos='', $condicao=array()){
    /*Realiza a busca dos dados encontrados na tabela de acordo com a(s)
     condicao(es) e elemento(s) informada(s) no array where*/
    $this->CI->db->select($elementos);
      $this->CI->db->where($condicao);
   return $this->CI->db->get($tabela)->row_array();
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

}