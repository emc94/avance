<?php  
    defined('BASEPATH') OR exit('No direct script access allowed');

class Auth
{

    private $CI; // Receberá a instância do Codeigniter
    private $permissaoView = 'nao_autorizado'; // Recebe o nome da view correspondente à página informativa de usuário sem permissão de acesso
    private $loginView = 'login'; // Recebe o nome da view correspondente à tela de login
    public function __construct(){
      /*
       * Criamos uma instância do CodeIgniter na variável $CI
       */
      $this->CI = &get_instance();
    }
    function CheckAuth($classe,$metodo)
    {
      /*
       * Pesquisa a classe e o método passados como parâmetro em CheckAuth
       */
      $array = array('classe' => $classe, 'metodo' => $metodo);
      $qryMetodos = $this->CI->db->where($array)->get('metodos');
      $resultMetodos = $qryMetodos->result();
      /*
       * Caso o método passado ainda não conste na tabela "metodos"
       * ele é inserido através de $this->CI->db->insert('metodos', $data);
       */
      if(count($resultMetodos)==0){
        $data = array(
          'classe' => $classe ,
          'metodo' => $metodo ,
          'identificacao' => $classe .  '/' . $metodo,
          'privado' => 1
        );
        $this->CI->db->insert('metodos', $data);
        redirect(base_url($classe . '/' . $metodo), 'refresh');
      }
      else{
        /*
         * Se o método ja existir na tabela, então recupera se ele é público ou privado
         * O método sendo público (0), então não verifica o login e libera o acesso
         * Mas se for privado (1) então é verificado o login e a permissão do usuário
         */
        if($resultMetodos[0]->privado==0){
          return false;
        }
        else{
          $id_metodo = $resultMetodos[0]->id;
          /*
           * Se o usuário estiver logado faz a verificação da permissão
           * caso contrário redireciona para uma tela de login
           */
          if(isset($_SESSION['logged']) && $_SESSION['logged']!=""){
            $array = array('id_metodo' => $id_metodo, 'nivel_acesso' => $_SESSION['logged']['sigeUserNivel']);
     
            $this->CI->db->select('nivel_acesso');
            $this->CI->db->where('id_metodo',$id_metodo);
            $__nivel=$this->CI->db->get('permissoes')->row_array();
            $resultPermissoes = 0;    
            if($__nivel!=NULL): 
              $nivel = explode(',',$__nivel['nivel_acesso']);
              foreach( $nivel as $value):
                if($value == $_SESSION['logged']['sigeUserNivel']):
                  $resultPermissoes++;
                endif;
              endforeach;
            else:
              return false;
            endif;

           // $this->CI->db->like($_SESSION['logged']['sigeUserNivel']);
            //$qryPermissoes = $this->CI->db->$this->CI->db->like($array,'%')->get('permissoes');
            //$resultPermissoes = $qryPermissoes->row_array();
            /*
             * Se o usuário não tiver a permissão para acessar o método,
             * ou seja, não estiver relacionado na tabela "permissoes",
             * ele deve ser redirecionado para uma tela informando que
             * não tem permissão de acesso;
             * caso contrário o acesso é liberado
             */
            if($resultPermissoes==0){
              //redirect($this->permissaoView, 'refresh');
             redirect($this->permissaoView,'refresh');
            }
            else{
              return true;
            }
          }
          else{
            redirect($this->loginView, 'refresh');
          }
        }
      }
    }
  

}