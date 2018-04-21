<?php
//require_once("Conexao.php");
//require_once("cadastro/cadastrar.php");

function connect_db(){
	try{
		
		$pdo = new PDO("mysql:host=localhost;dbname=sige","root","",array(PDO::ATTR_PERSISTENT => true,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    		PDO::ATTR_EMULATE_PREPARES => false));

		$pdo->exec("set names utf8");
			
		return $pdo;

	}catch(PDOException $e){
			echo $e->getMessage();
			echo"Erro de conexao com o data base!";
	}
}


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
  function habilitarCampo(campo, valor){
    if(valor == "sim"){
      document.getElementById(campo).disabled = 0;
    }else{
    document.getElementById(campo).disabled = 1;
    }
  }
  </script>
  ';
}


/****************************   MARCAR CAMPO    ***********************************************/

function marcarCampo($valor, $campo){//função usada pra selecionar o elemento radio
    if($valor==$campo)
      echo"checked=true";
}


/**************************** FUNCAO FILTRAR DISCIPLINAS HORARIOS ****************************/

function filtrarDisciplinaProfessor($horario=""){//RECEBE OS DADOS DA TABELA HORARIOS TURMA E OS TRATA

$dados=isset($horario) ? explode("-", $horario) : null;
$idprofessor=$dados['0'];
$iddisciplina=$dados['1'];

$pdo=connect_db();
  $consultar=$pdo->query("SELECT disciplina.abreviatura, disciplina.nome_disciplina, professor.nome FROM disciplina, professor WHERE idDisciplinas='$iddisciplina' AND idProfessor='$idprofessor'");
  $resultado=$consultar->fetchAll(PDO::FETCH_ASSOC);
  if($consultar->rowCount()>0){
    foreach ($resultado as $value){
      $nome_p = explode(" ", $value['nome']);
      echo "<td title='".$value['nome_disciplina']."'>"."<span class=\"glyphicon glyphicon-book\" aria-hidden=\"true\" title='Disciplina'></span>"
      .$value['abreviatura']
      ."<br />"
      ."<span class=\"glyphicon glyphicon-education\" aria-hidden=\"true\" title='Professor'></span>".
      $nome_p['0']." ".$nome_p['1']."</td>";
    }
  }else{echo"<td> - </td>";} 
}


/***************************** FUNCAO GERAR CODIGO RANDOMICO ********************************/

function gerarCodigo($tamanho){//Gera um codigo de validaçao
  $characters = '0123456789';
  $codigo='';
  $tamanhoDados=strlen($characters);
  for($i=1;$i<=$tamanho; $i++){
    $codigo.=$characters[rand(0,$tamanhoDados-1)];
  }
  return $codigo;
}

function validarCodigo($pdo,$tabela, $tipoCodigo, $tamanho){//verifica se o codigo gerado ja nao esta cadastrado
  //$tipoCodigo nome do campo dentro da tabela $tamanho quantidade de caracteres a serem gerados

  $codigo=gerarCodigo($tamanho);

  $validaCodigo=$pdo->query("SELECT $tipoCodigo FROM $tabela");

  if($validaCodigo->rowCount()>0){
   $valores=$validaCodigo->fetchAll(PDO::FETCH_ASSOC);
    foreach ($valores as $dados){
     while($dados[$tipoCodigo] == $codigo){
      $codigo=gerarCodigo($tamanho);
     }
   }
  }
   return $codigo;
 }

function validarVagas($pdo,$idTurma){//verifica se vagas na turma

  $turma=$pdo->query("SELECT vagas_restantes, maximo_vagas FROM turma WHERE idTurma='$idTurma'");

  if($turma->rowCount()>'0' AND $turma->rowCount()=='1'){
    $dados=$turma->fetchAll(PDO::FETCH_ASSOC);
    foreach($dados as $valores){
      if($valores['vagas_restantes']<=$valores['maximo_vagas'] AND $valores['vagas_restantes']!='0'){
        return true;
      }else{
        return false;
      }
    }

    }else{
      notificacao('Turma não encontrada!','erro','form_cad_turma');
      exit();
      return false;
    }

}

function atualizarVagasTurma($pdo,$idTurma){//atualiza o numero de vagas da turma

  $chegarVagas=$pdo->query("SELECT vagas_restantes FROM turma WHERE idTurma='$idTurma'");

  $vagas=$chegarVagas->fetchAll(PDO::FETCH_ASSOC);

  foreach($vagas as $valores){
    $attVagas=$valores['vagas_restantes']-1;

     $updateVagas=$pdo->prepare("UPDATE turma SET  vagas_restantes=:vagas_restantes");
     $updateVagas->bindParam(':vagas_restantes',$attVagas);

     if($updateVagas->execute()){
      return true;
     }else{
      notificacao('Erro ao atualizar as vagas da turma!','erro','form_cad_aluno');
      exit();
      return false;
     }
  }
}

/*************************** FUNCOES DE LISTAGEM DE DADOS ********************************/
function listarUf(){ 
  $pdo=connect_db();
  $consulta=$pdo->query("SELECT * FROM estado");
  $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    if($consulta->rowCount()>0){
      foreach($resultado as $valor){
      echo "<option value=\"$valor[nome]\">$valor[nome] - $valor[uf]</option>";
      }
    }else{
  echo "<option value=\"0\">Dados não econtrados!</option>";
  }
}

function listarAnoLetivo(){ 
  $pdo=connect_db();
  $consulta=$pdo->query("SELECT DISTINCT ano_letivo FROM turma");
  $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    if($consulta->rowCount()>0){
      foreach($resultado as $valor){
      echo "<option value=\"$valor[ano_letivo]\">$valor[ano_letivo]</option>";
      }
    }else{
  echo "<option>Dados não econtrados!</option>";
  }
}

function listarMunicipio(){
  $pdo=connect_db();
   $consulta=$pdo->query("SELECT * FROM cidades");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
     foreach($resultado as $valor){
     echo "<option value=\"$valor[municipio]\">$valor[municipio]</option>";
     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
}

function listarOrgaoEmissor(){
  $pdo=connect_db();
     $consulta = $pdo->query("SELECT * FROM orgao_expedidor");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
   if($consulta->rowCount()>0){
     foreach($resultado as $dados){
         echo"<option value=\"$dados[codigo_orgao]\">$dados[codigo_orgao] - $dados[descricao]</option>";
     }
     
   }else{
     echo"<option value=\"0\">Dados nao Cadastrados</option>";
   }
}

function listarEscola(){
  $pdo=connect_db();
   $consulta=$pdo->query("SELECT codigoEscola, nome_escola FROM escola");
   if($consulta->rowCount()>0){
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
     foreach($resultado as $valor){
     echo "<option value=\"$valor[codigoEscola]\">$valor[nome_escola] - $valor[codigoEscola]</option>";
     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
  }

function listarEscolaCadDiretor(){
  $pdo=connect_db();
   $consulta=$pdo->query("SELECT codigoEscola, nome_escola FROM escola WHERE  idDiretor is null");
   if($consulta->rowCount()>0){
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
     foreach($resultado as $valor){
     echo "<option value=\"$valor[codigoEscola]\">$valor[nome_escola] - $valor[codigoEscola]</option>";
     }
   }else{
     echo "<option value=\"0\">Não há escolas sem diretor cadastradas!</option>";
   }
  }
function listarEscolaDiretor(){
  $pdo=connect_db();
  $consultarIdDiretor = $pdo->query("SELECT idDiretor, cpf from diretor where cpf = '$_SESSION[usuario]'");
  $resultadoId=$consultarIdDiretor->fetch(PDO::FETCH_ASSOC);

  $idDiretor = $resultadoId['idDiretor'];

   $consulta=$pdo->query("SELECT idEscola FROM funcionarios WHERE idFuncionario = '$idDiretor'");

   if($consulta->rowCount()>0){
    $resultado=$consulta->fetch(PDO::FETCH_ASSOC);

    $idEscola=$resultado['idEscola'];
   
    $consulta=$pdo->query("SELECT idEscola, nome_escola, codigoEscola FROM escola WHERE idEscola = '$idEscola'");

   if($consulta->rowCount()>0){
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
     foreach($resultado as $valor){
     echo "<option value=\"$valor[codigoEscola]\">$valor[nome_escola] - $valor[codigoEscola]</option>";
     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
  }else{
    echo "Erro na validação do Usuário!";
    session_destroy($_SESSION['usuario']);
    session_destroy($_SESSION['User']);
    session_destroy($_SESSION['cUser']);

    header("refresh:3;url=../_pages/login.php");
  }
}

function listarTurmaEscola(){
  $pdo=connect_db();
   $consultarFuncionario=$pdo->query("SELECT idDiretor, cpf FROM diretor WHERE cpf = '$_SESSION[usuario]'");

   if($consultarFuncionario->rowCount()>0){
    $r_Funcionario=$consultarFuncionario->fetch(PDO::FETCH_ASSOC);

    $idFuncionario = $r_Funcionario['idDiretor'];
   
    $consultarEscola = $pdo->query("SELECT idEscola FROM funcionarios WHERE idFuncionario = '$idFuncionario'");

    $resultadoEscola=$consultarEscola->fetch(PDO::FETCH_ASSOC);
    
    $idEscola = $resultadoEscola['idEscola'];

    $consulta=$pdo->query("SELECT * FROM turma WHERE idEscola = '$idEscola'");

   if($consulta->rowCount()>0){
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
     foreach($resultado as $valor){

     echo "<option value=\"$valor[idTurma]\">$valor[ano_ensino] $valor[etapa] / $valor[modalidade] - $valor[nome_turma] - $valor[dias_semana] - das ".date("H:i",strtotime($valor['horario_inicio'])) ." as ".date("H:i",strtotime($valor['horario_termino']))."</option>";
     
     }
   }else{
     echo "<option value=\"0\">Turma não encontrada!</option>";
   }
  }else{
    echo "Erro na validação do Usuário!";
    session_destroy($_SESSION['usuario']);
    session_destroy($_SESSION['User']);
    session_destroy($_SESSION['cUser']);

    header("refresh:3;url=../_pages/login.php");
  }
}

function listarTurma(){
  $pdo=connect_db();

  $consulta=$pdo->query("SELECT idTurma, ano_ensino, dias_semana, etapa, modalidade, nome_turma, dias_semana, horario_inicio, horario_termino  FROM turma");
  $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    if($consulta->rowCount()>0){
      foreach($resultado as $valor){
        echo "<option value=\"$valor[idTurma]\">$valor[ano_ensino] $valor[etapa] / $valor[modalidade] - $valor[nome_turma] - $valor[dias_semana] - das ".date("H:i",strtotime($valor['horario_inicio'])) ." as ".date("H:i",strtotime($valor['horario_termino']))."</option>";
      }
    }else{
      echo "<option value=\"0\">Dados não econtrados!</option>";
    }
}

function listarTurmaProfessor(){//COMLETAR FUNCAO VALIDANDO LOGIN DO ROFESSOR
$pdo=connect_db();

$professor=$_SESSION['usuario'];

$buscarProfessor=$pdo->query("SELECT idProfessor, disciplinas FROM professor WHERE cpf='$professor'");
$idProfessor=0;
$validarProfessor=false;
$count=0;

if($buscarProfessor->rowCount()>0){

$resultado = $buscarProfessor->fetchAll(PDO::FETCH_ASSOC);

foreach($resultado as $valor){
$idProfessor=$valor['idProfessor'];
$disciplinas=explode("\\",$valor['disciplinas']);
$numeroDisciplinas=count($disciplinas);//conta quantas disciplinas o professor leciona
$n = 0;

while($n < $numeroDisciplinas){

$buscarDisciplina=$pdo->query("SELECT * FROM disciplina WHERE nome_disciplina='$disciplinas[$n]'");

if($buscarDisciplina->rowCount()>0){

  foreach ($buscarDisciplina as $valueDisciplina){

  $disciplina=$valueDisciplina['idDisciplinas'];

  $aula=$idProfessor."-".$disciplina;//monta o id do professor e o id da disciplina

  $consultaHorario=$pdo->query("SELECT * FROM horario_turma WHERE segunda='$aula' OR terca='$aula' OR quarta='$aula' OR quinta='$aula' OR sexta=$aula OR sabado='$aula' OR domingo='$aula'");

  if($consultaHorario->rowCount()>0){
    $resultadoHorario = $consultaHorario->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultadoHorario as $dadosTurma){
      if($dadosTurma['segunda']!=null){
        echo 

         "<option  value=\"$dadosTurma[idTurma]-$valueDisciplina[nome_disciplina]-$dadosTurma[idHorarioTurma]\">$dadosTurma[horario_inicio_aula] - $dadosTurma[horario_termino_aula] - $valueDisciplina[nome_disciplina] - Segunda</option>";

      }elseif($dadosTurma['terca']!=null){
        echo 
         "<option  value=\"$dadosTurma[idTurma]-$valueDisciplina[nome_disciplina]-$dadosTurma[idHorarioTurma]\">$dadosTurma[horario_inicio_aula] - $dadosTurma[horario_termino_aula] - $valueDisciplina[nome_disciplina] - Terça</option>";

      }elseif($dadosTurma['quarta']!=null){
        echo 
         "<option  value=\"$dadosTurma[idTurma]-$valueDisciplina[nome_disciplina]-$dadosTurma[idHorarioTurma]\">$dadosTurma[horario_inicio_aula] - $dadosTurma[horario_termino_aula] - $valueDisciplina[nome_disciplina] - Quarta</option>";
      }elseif($dadosTurma['quinta']!=null){
        echo 
         "<option  value=\"$dadosTurma[idTurma]-$valueDisciplina[nome_disciplina]-$dadosTurma[idHorarioTurma]\">$dadosTurma[horario_inicio_aula] - $dadosTurma[horario_termino_aula] - $valueDisciplina[nome_disciplina] - Quinta</option>";

      }elseif($dadosTurma['sexta']!=null){
        echo 
         "<option  value=\"$dadosTurma[idTurma]-$valueDisciplina[nome_disciplina]-$dadosTurma[idHorarioTurma]\">$dadosTurma[horario_inicio_aula] - $dadosTurma[horario_termino_aula] - $valueDisciplina[nome_disciplina] - Sexta</option>";

      }elseif($dadosTurma['sabado']!=null){
        echo 
         "<option  value=\"$dadosTurma[idTurma]-$valueDisciplina[nome_disciplina]-$dadosTurma[idHorarioTurma]\">$dadosTurma[horario_inicio_aula] - $dadosTurma[horario_termino_aula] - $valueDisciplina[nome_disciplina]- Sábado</option>";
      }elseif($dadosTurma['domingo']!=null){
        echo 
         "<option  value=\"$dadosTurma[idTurma]-$valueDisciplina[nome_disciplina]-$dadosTurma[idHorarioTurma]\">$dadosTurma[horario_inicio_aula] - $dadosTurma[horario_termino_aula] - $valueDisciplina[nome_disciplina] - Domingo</option>";
      }
    

     }
    }

  }
}

$n++;

}

}

}else{
echo "<option value=\"0\">Dados não econtrados!</option>";
}

}



function listarAnoEnsino(){
  $pdo=connect_db();
   $consulta=$pdo->query("SELECT * FROM ano_ensino");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
     foreach($resultado as $valor){
     echo "<option value=\"$valor[ano_serie]\">$valor[ano_serie] - $valor[etapa_ensino]</option>";
     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
}

function listarDisciplina(){
  $pdo=connect_db();
     $consulta=$pdo->query("SELECT nome_disciplina FROM disciplina");
     
     if($consulta->rowCount()>0){
     while($dados=$consulta->fetch(PDO::FETCH_ASSOC)){
   echo"
   <label for=\"$dados[nome_disciplina]\" class=\"checkbox\">
     <input  type=\"checkbox\" id=\"$dados[nome_disciplina]\" name=\"disciplinas[]\" value=\"\\$dados[nome_disciplina]\" />$dados[nome_disciplina]</label>
   ";
     }
   }else{
     echo "<span class=\"error\">Disciplinas nao Cadastradas!</span>";
          }
}

function listarDisciplinaLista(){
  $pdo=connect_db();
     $consulta=$pdo->query("SELECT * FROM disciplina");
     
     if($consulta->rowCount()>0){
     while($dados=$consulta->fetch(PDO::FETCH_ASSOC)){
   echo"
     <option value=\"$dados[idDisciplinas]\">$dados[nome_disciplina]</option>
   ";
     }
   }else{
     echo "<span class=\"error\">Disciplinas nao Cadastradas!</spa>";
          }
}

function carregarDisciplinasProfessor(){
  $pdo=connect_db();
    $consulta=$pdo->query("SELECT disciplinas FROM professor WHERE cpf='$_SESSION[usuario]'");
      if($consulta->rowCount()>0){
          $resultado=$consulta->fetchAll(PDO::FETCH_ASSOC);
            $disciplina=explode("\\", $resultado['0']['disciplinas']);
            $tamanho=count($disciplina);//conta a quantidade de valores da disciplina
          for($i=1;$i<$tamanho;$i++){
            echo'<option value="'.$disciplina[$i].'">'.$disciplina[$i].'</option>';
          }
      }
}

function listarMediacao(){
  $pdo=connect_db();
   $consulta=$pdo->query("SELECT * FROM mediacao");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
     foreach($resultado as $valor){
     echo "<option value=\"$valor[nome]\">$valor[nome]</option>";
     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
  }


function listarModalidade(){
  $pdo=connect_db();
   $consulta=$pdo->query("SELECT * FROM modalidade_de_ensino");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
     foreach($resultado as $valor){
     echo "<option value=\"$valor[nome]\">$valor[nome]</option>";
     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
  }

function listarEtapa(){

  $pdo=connect_db();
   $consulta=$pdo->query("SELECT * FROM etapas_de_ensino");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
     foreach($resultado as $valor){
     echo "<option value=\"$valor[tipo]\">$valor[tipo] - $valor[descricao]</option>  ";

     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
}

function listarContrato_funcoes(){

  $pdo=connect_db();
   $consulta=$pdo->query("SELECT * FROM contrato_funcao");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
     foreach($resultado as $valor){
     echo "<option value=\"$valor[nome]\">$valor[nome] - $valor[descricao]</option>  ";

     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
}

function listarContrato_vinculo(){

  $pdo=connect_db();
   $consulta=$pdo->query("SELECT * FROM contrato_vinculo");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
     foreach($resultado as $valor){
     echo "<option value=\"$valor[nome]\">$valor[nome]</option>  ";

     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
}

function listarAreaCurso(){

  $pdo=connect_db();
   $consulta=$pdo->query("SELECT * FROM formacao_area_curso");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
     foreach($resultado as $valor){
     echo "<option value=\"$valor[nome_area]\">$valor[nome_area]</option>  ";

     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
}

function listarTipoPos(){

  $pdo=connect_db();
   $consulta=$pdo->query("SELECT * FROM formacao_pos_tipo");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
     foreach($resultado as $valor){
     echo "<option value=\"$valor[nome]\">$valor[nome]</option>  ";

     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
}


function listarOutrosCursos(){

  $pdo=connect_db();
   $consulta=$pdo->query("SELECT * FROM formacao_outros_cursos");
   $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
     foreach($resultado as $valor){
     echo "<option value=\"$valor[nome]\">$valor[nome]</option>  ";

     }
   }else{
     echo "<option value=\"0\">Dados não econtrados!</option>";
   }
}


/********************************* FUNÇÕES DE CADASTRO *************************************/
function cadastrarUsuario($pdo, $codigoUser,$cpf,$nivel, $datanascimento){

  $dataNascimento=explode("-", $datanascimento);
  $data=$dataNascimento['2'].$dataNascimento['1'].$dataNascimento['0'];//organizar ordem desses index talves seja 0 1 2

  $cadUser = $pdo->prepare("INSERT INTO usuario(codigo_user, login,  senha, nivel)VALUES(:codigoUser, :login, :senha, :nivel)");

  $cadUser->bindParam(':login',$cpf);
  $cadUser->bindParam(':senha',$data);
  $cadUser->bindParam(':nivel',$nivel);
  $cadUser->bindParam(':codigoUser',$codigoUser);

  if($cadUser->execute()){
    return $pdo->lastInsertId();
  }else{
    //notificacao('Erro ao cadastrar Usuário!','erro','home');
    return false;
  }

}
function adicionarDiretorEscola($pdo,$codigoEscola,$idDiretor){

  $updateDiretorEscola=$pdo->prepare("UPDATE escola SET idDiretor='$idDiretor' WHERE codigoEscola='$codigoEscola'");
  
  if($updateDiretorEscola->execute()){
    return true;
  }else{
    return false;
  }

}
function cadastrarEndereco($pdo){//função pra atualizar endereco

  /******************************* DADOS DO ENDERECO ******************************************/
  $zonaresidencia = isset($_POST['zonaresidencia']) ? htmlspecialchars($_POST['zonaresidencia']) : null;
  $endereco = isset($_POST['endereco']) ? htmlspecialchars($_POST['endereco']) : null;
  $numero = isset($_POST['numero']) ? htmlspecialchars($_POST['numero']) : null;
  $complemento = isset($_POST['complemento']) ? htmlspecialchars($_POST['complemento']) : null;
  $bairro = isset($_POST['bairro']) ? htmlspecialchars($_POST['bairro']) : null;
  $uf = isset($_POST['uf_endereco']) ? htmlspecialchars($_POST['uf_endereco']) : null;
  $cep = isset($_POST['cep']) ? htmlspecialchars($_POST['cep']) : null;
    $cep=removerMascaras($cep);
  $municipio = isset($_POST['municipio']) ? htmlspecialchars($_POST['municipio']) : null;
  /****************************************************************************************/
  
  $cadastrarEndereco=$pdo->prepare("INSERT INTO endereco(cep, endereco, bairro, numero, complemento, zona_residencial, cidade, estado) VALUES(:cep, :endereco, :bairro, :numero, :complemento, :zonaresidencia, :municipio, :uf)");

  $cadastrarEndereco->bindParam(':zonaresidencia',$zonaresidencia);
  $cadastrarEndereco->bindParam(':endereco',$endereco);
  $cadastrarEndereco->bindParam(':numero',$numero);
  $cadastrarEndereco->bindParam(':complemento',$complemento);
  $cadastrarEndereco->bindParam(':bairro',$bairro);
  $cadastrarEndereco->bindParam(':uf',$uf);
  $cadastrarEndereco->bindParam(':cep',$cep);
  $cadastrarEndereco->bindParam(':municipio',$municipio);

   if($cadastrarEndereco->execute()){
    return $pdo->lastInsertId();//resgata o id do endereco cadastrado
  }else{//caso algum erro ocorra
    return false;
  }

}//fim cadastrar endereco


function cadastrarContato($pdo){// funcao pra atualizar contatos

  /*********************************** DADOS CONTATO *******************************************/
  $telefoneresidencial = isset($_POST['fixo']) ? htmlspecialchars($_POST['fixo']) : null; 
    $telefoneresidencial=removerMascaras($telefoneresidencial);
  $celular = isset($_POST['cell1']) ? htmlspecialchars($_POST['cell1']) : null;  
    $celular=removerMascaras($celular);
  $celular2 = isset($_POST['cell2']) ? htmlspecialchars($_POST['cell2']) : null;  
    $celular2=removerMascaras($celular2);
  $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
  /*********************************** *********** *******************************************/
  
  $cadastrarContato=$pdo->prepare("INSERT INTO contato(email, celular, celular_2, telefone_residencial) VALUES(:email, :celular, :celular2, :telefone_fixo)");

  $cadastrarContato ->bindParam(':email',$email); 
  $cadastrarContato ->bindParam(':telefone_fixo',$telefoneresidencial); 
  $cadastrarContato ->bindParam(':celular',$celular); 
  $cadastrarContato ->bindParam(':celular2',$celular2);

  if($cadastrarContato->execute()){
    return  $pdo->lastInsertId();//resgata o id do contato cadastrado
  }else{//caso algum erro ocorra
    return false;
  }

}//fim cadastrar contatos


/********************************* FUNÇÕES DE UPDATE *************************************/
function updateEndereco($idEndereco, $zonaresidencia, $endereco, $numero, $complemento, $bairro, $uf, $cep, $municipio){//função pra atualizar endereco
$pdo=connect_db();
 $updateEndereco = $pdo->prepare("UPDATE endereco SET cep=:cep, endereco=:endereco, bairro=:bairro, numero=:numero, complemento=:complemento, zona_residencial=:zonaresidencia, cidade=:municipio, estado=:uf WHERE idEndereco = :idEndereco");
  
   $updateEndereco->bindParam(':idEndereco',$idEndereco);
   $updateEndereco->bindParam(':zonaresidencia',$zonaresidencia);
   $updateEndereco->bindParam(':endereco',$endereco);
   $updateEndereco->bindParam(':numero',$numero);
   $updateEndereco->bindParam(':complemento',$complemento);
   $updateEndereco->bindParam(':bairro',$bairro);
   $updateEndereco->bindParam(':uf',$uf);
   $updateEndereco->bindParam(':cep',$cep);
   $updateEndereco->bindParam(':municipio',$municipio);

   if($updateEndereco->execute()){
    echo"Endereçoa atualizado com sucesso!";
    return true;
   }else{
    echo"Erro ao atualizar endereço!";
    var_dump($updateEndereco);
    exit();
    return false;
   }
}//fim atualizar endereco

function updateContato($codigoContato, $email, $telefoneresidencial, $celular, $celular2){// funcao pra atualizar contatos

$pdo=connect_db();

  $updateContato=$pdo->prepare("UPDATE contato SET email=:email, celular=:celular, celular_2=:celular2, telefone_residencial=:telefone_fixo WHERE codigoContato=:codigoContato");

  $updateContato ->bindParam(':codigoContato',$codigoContato); 
  $updateContato ->bindParam(':email',$email); 
  $updateContato ->bindParam(':telefone_fixo',$telefoneresidencial); 
  $updateContato ->bindParam(':celular',$celular); 
  $updateContato ->bindParam(':celular2',$celular2);

  if($updateContato->execute()){
    echo"Contatos atualizados com sucesso!";
    return true;
  }else{
    echo "Erro ao atualizar contatos!";
    var_dump($updateContato);
    exit();
    return false;
  }

}//fim atualizar contatos


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
       <div class="">
          <span class="">
          <label for="cep">CEP</label>
          </span>

          <input class="form-control" type="text" id="cep" name="cep" onkeypress="mascarar(this,\'cep\')" onfocusout="validarTamanho(this,8)"  placeholder="Código de endereçamento postal" required/> 
        </div>
        </div>

        <div class="col-md-6 col-xs-12">
         <div class="">
            <span class="">
            <label for="endereco">Endereço</label>
            </span>
            <input class="form-control" type="text" id="endereco" name="endereco" placeholder="Nome da rua, avenida, condomínio, residêncial, etc.." required/> 
          </div>
        </div>
    </div>

   <div class="row">   
   <div class="col-md-3 col-xs-12">
     <div class="">
      <span class="">
      <label for="numero">Número</label>
      </span>
      <input class="form-control" type="text" id="numero" name="numero" placeholder="Número da residência
" required/>
     </div>
   </div>
   
    <div class="col-md-3 col-xs-12">
      <div class="">
        <span class="">
        <label for="bairro">Bairro</label> 
        </span>
        <input class="form-control" type="text" id="bairro" name="bairro" placeholder="Bairro do endereço"  required/>
      </div>
    </div>   
   
   <div class="col-md-6 col-xs-12">
     <div class="">
      <span class="">
      <label for="complemento">Complemento</label>
      </span>
      <input class="form-control" type="text" id="complemento" name="complemento" placeholder="Complemento do endereço (Ex: casa 1; Bloco A, Box. 100)" required/>
     </div>
    </div>
   </div>   
   
  <div class="row">   
   <div class="col-md-4 col-xs-12">
     <div class="">
      <span class="">
      <label for="uf_endereco">UF</label>
      </span>
      <div class="controls">
      <select class="form-control selectwidth" name="uf_endereco" id="uf_endereco" onchange="carregarCidadesEstado(this.value,\'municipio\')" required>
      <option value="0">Selecione o Estado</option>
      ';
      listarUf();
      echo'
      </select>
      </div>
    </div>
  </div>
   
  <div class="col-md-6 col-xs-12">
   <div class="">
    <span class="">
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
 <div class="">
  <span class="">
  <label class="control-label" for="emailescola">@ E-mail</label>
  </span>
  <div class="controls">
  <input class="form-control" type="email" id="email" name="email" placeholder="Correio eletrônico da escola" required/>
  </div>
 </div><!-- GRUPO Email -->
   </div>

   <div class="col-xs-12 col-md-6">
 <div class="">
  <span class="">
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
 <div class="">
  <span class="">
  <label class="control-label" for="cell1">Celular</label>
  </span>
  <div class="controls">
  <input class="form-control" type="telephone" id="cell1" name="cell1" placeholder="Número de celular" onkeypress="mascarar(this,\'celular\')" required/>
  </div>
 </div><!-- GRUPO celular1 -->
   </div>

   <div class="col-xs-12 col-md-6">
 <div class="">
  <span class="">
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

function enderecoContatosUpdate($endereco,$contato){//insere na pagina os campos para cadastro de endereço e contatos
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

          <input class="form-control" type="text" id="cep" name="cep" onkeypress="mascarar(this,\'cep\')" value="'.$endereco['cep'].'" placeholder="Código de endereçamento postal" required/> 
        </div>
        </div>

        <div class="col-md-6 col-xs-12">
         <div class="input-group">
            <span class="input-group-addon">
            <label for="endereco">Endereço</label>
            </span>
            <input class="form-control" type="text" id="endereco" name="endereco" placeholder="Nome da rua, avenida, condomínio, residêncial, etc.." value="'.$endereco['endereco'].'" required/> 
          </div>
        </div>
    </div>

   <div class="row">   
   <div class="col-md-3 col-xs-12">
     <div class="input-group">
      <span class="input-group-addon">
      <label for="numero">Número</label>
      </span>
      <input class="form-control" type="text" id="numero" name="numero" value="'.$endereco['numero'].'" placeholder="Número da residência
" required/>
     </div>
   </div>
   
    <div class="col-md-3 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon">
        <label for="bairro">Bairro</label> 
        </span>
        <input class="form-control" type="text" id="bairro" name="bairro" placeholder="Bairro do endereço" value="'.$endereco['bairro'].'"  required/>
      </div>
    </div>   
   
   <div class="col-md-6 col-xs-12">
     <div class="input-group">
      <span class="input-group-addon">
      <label for="complemento">Complemento</label>
      </span>
      <input class="form-control" type="text" id="complemento" name="complemento" placeholder="Complemento do endereço (Ex: casa 1; Bloco A, Box. 100)" value="'.$endereco['complemento'].'" required/>
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
      <option  value="'.$endereco['estado'].'">'.$endereco['estado'].'</option>
      ';
      listarUf();
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
    <option  value="'.$endereco['cidade'].'">'.$endereco['cidade'].'</option>
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
  <input class="form-control" type="email" id="email" name="email" placeholder="Correio eletrônico da escola" value="'.$contato['email'].'" required/>
  </div>
 </div><!-- GRUPO Email -->
   </div>

   <div class="col-xs-12 col-md-6">
 <div class="input-group">
  <span class="input-group-addon">
  <label class="control-label" for="fixo">Telefone Fixo</label>
  </span>
  <div class="controls">
  <input class="form-control" type="tel" id="fixo" name="fixo" placeholder="Número de telefone residêncial" onkeypress="mascarar(this,\'telefone\')" value="'.$contato['telefone_residencial'].'" required/>
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
  <input class="form-control" type="telephone" id="cell1" name="cell1" placeholder="Número de celular" onkeypress="mascarar(this,\'celular\')" value="'.$contato['celular'].'" required/>
  </div>
 </div><!-- GRUPO celular1 -->
   </div>

   <div class="col-xs-12 col-md-6">
 <div class="input-group">
  <span class="input-group-addon">
  <label class="control-label" for="cell2">Celular 2</label>
  </span>
  <div class="controls">
  <input class="form-control" type="telephone" id="cell2" name="cell2" placeholder="Número de celular alternativo" onkeypress="mascarar(this,\'celular\')" value="'.$contato['celular_2'].'" required/>
  </div>
 </div><!-- GRUPO Celular 2-->
   </div>
   </div>

</fieldset>

';
}



function camposValidar($nomeFormulario=""){

  $pdo=connect_db();

  $buscarCampos = $pdo->query("SELECT type_input,type_radio,type_select FROM validacao_formularios WHERE nome_formulario = '$nomeFormulario'");
  
  if($buscarCampos->rowCount()>0){
    $resultado = $buscarCampos->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $campos){
      $idOrNomeInput=explode('-', $campos['type_input']);
       $idOrNomeRadio=explode('-', $campos['type_radio']);
       $idOrNomeSelect=explode('-', $campos['type_select']);
      for($i=0;$i<count($idOrNomeInput);$i++){
        echo ' '.$idOrNomeInput[$i];
      } 
      for($i=0;$i<count($idOrNomeRadio);$i++){
        echo ' '.$idOrNomeRadio[$i];
      } 
      for($i=0;$i<count($idOrNomeSelect);$i++){
        echo ' '.$idOrNomeSelect[$i];
      }

    }
  }

}

function removerMascaras($valor){//remove os caracateres inseridos pelas mascaras

  $valor=str_replace("-", "", $valor);
  $valor=str_replace(".", "", $valor);
  $valor=str_replace("(", "", $valor);
  $valor=str_replace(")", "", $valor);
  $valor=str_replace("/", "", $valor);
  $valor=str_replace(" ", "", $valor);

  return $valor;
}

function notificacao($mensagem,$tipo,$url){
  session_start();
  $_SESSION['notificacao']=$mensagem;
    header("location:".SIGE."/_pages/mensagens.php?alert=$tipo&url=$url");
}

function getCodigoEscolaDiretor($modulo){//resgata o codigo da escola do diretor ou professor
  $pdo=connect_db();
  $cpf=$_SESSION['usuario'];

  $getIdDiretor = $pdo->query("SELECT idDiretor FROM diretor WHERE cpf='$cpf'");
  $r_idDiretor = $getIdDiretor -> fetch(PDO::FETCH_ASSOC);
    $idDiretor = $r_idDiretor['idDiretor'];

  $getFuncionario = $pdo->query("SELECT idFuncionario FROM funcionarios WHERE idFuncionario='$idDiretor'");

  $r_funcionario = $getFuncionario -> fetch(PDO::FETCH_ASSOC);
  $idFuncionario = $r_funcionario['idFuncionario'];

  $getEscola = $pdo->query("SELECT escola.idEscola,  codigoEscola, nome_escola FROM escola inner join funcionarios on funcionarios.id='$idFuncionario'");

  $r_escola = $getEscola->fetch(PDO::FETCH_ASSOC);

  if($getEscola->rowCount()>0){
    return $r_escola;
  }else{
    return false;
  }
}##

function getInfoFuncionarios($tabela){//resgata os dados dos funcionarios
  $pdo=connect_db();

  $getEscola = $pdo->query("SELECT nome, funcionarios.id, escola.idEscola, codigoEscola, nome_escola FROM escola, $tabela, funcionarios");
  $r_escola = $getEscola->fetchAll(PDO::FETCH_ASSOC);

foreach ($r_escola as $value){
  
  echo $value['id']."<br>";
}
    var_dump($r_escola);
  if($getEscola->rowCount()>0){
    return $r_escola;
  }else{
    return false;
  }
}##


function vAcessoPagina($nivel=array()){
  $acessoPermitido = false;
  foreach ($nivel as $value) {
    if($_SESSION['sigeUserNivel'] == $value)
      $acessoPermitido = true;
  }

  if($acessoPermitido != true){
    echo"
    <div class=\"error_center\">
     <div class=\"row col-md-9 col-xs-12\">
      <div class=\"alert alert-danger\" role=\"alert\">
         <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
       <span class=\"sr-only\">Você não tem autorização para acessar esta página!</span>
       </div>
     </div>
    </div>";
    exit();
    return false;
  }
}

function getIdUser(){
  $_SESSION['User'];//codigo do usuário
  $pdo = connection_db();

  $consulta = $pdo->query("SELECT idUsuario FROM usuario where codigo_user = '$_SESSION[User]'");

  $r = $consulta -> fetch(PDO::FETCH_ASSOC);

  return $r['idUsuario'];
}

function formularioUpload($modulo, $subcategoria, $subcategoria2){
    echo'<input type="hidden" name="modulo" value="'.$modulo.'" />
    <input type="hidden" name="subcategoria" value="'.$subcategoria.'" />
    <input type="hidden" name="subcategoria2" value="'.$subcategoria2.'" />';

  include_once('page_upload.php');
}

function upload(){
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
    if(file_exists($uploaddir))
      echo 'sim';
    else
    echo 'nao';
    if(!file_exists($uploaddir))//verifica se o diretório já não existe
      mkdir($uploaddir,0777, true);

    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

    if($_FILES['userfile']['size'] <= 4096000 AND ($_FILES['userfile']['type'] == "image/png" OR $_FILES['userfile']['type'] == "image/jpeg")){
      if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
         return true;
      } else {
          echo "Possível ataque de upload de arquivo!\n";
      }
    }

    array_map('unlink', glob($url."/temp/*"));//remove o arquivo da pasta temp

  }
  else{
    echo "Erro ao receber informações do upload";
    var_dump($categoria);
    return false;
  }
}
?>