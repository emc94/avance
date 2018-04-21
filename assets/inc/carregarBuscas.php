<?php
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

 if(isset($_GET['modulo']) AND $_GET['modulo']=="turma"){//CARREGA OS ALUNOS DA TURMA ESCOLHIDA

  if(isset($_GET['buscar']) AND $_GET['buscar']!=""){
     $dados=explode("-",$_GET['buscar']);
     $disciplina=$dados['1'];
     $buscar=$dados['0'];

     $pdo=connect_db();
  $consulta=$pdo->query("SELECT nome, matricula, idAluno FROM aluno WHERE idTurma='$buscar'");

  $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

   if($consulta->rowCount()>0){
    echo "<option value=\"0\">Selecione o aluno para editar suas notas</option>";
    foreach($resultado as $valor){
    echo "<option value=\"$valor[idAluno]-$disciplina\">$valor[nome] - $valor[matricula]</option>";
    }
   }else{
    echo "<option value=\"0\">Dados não econtrados!</option>";
   }
   }

/************************************* NOTAS *****************************************/

}elseif(isset($_GET['modulo']) AND $_GET['modulo']=="notas"){
 //carrega as notas do aluno escolhido
$dadosBusca=explode("-",$_GET['buscar']);
$disciplina=$dadosBusca['1'];
$buscar=$dadosBusca['0'];
  $pdo=connect_db();
  session_start();

  $buscarDisciplina=$pdo->query("SELECT idDisciplinas FROM disciplina where nome_disciplina='$disciplina'");
  $Disciplina=$buscarDisciplina->fetch(PDO::FETCH_ASSOC);
  $idDisciplina=$Disciplina['idDisciplinas'];

  $consultarProfessor=$pdo->query("SELECT idProfessor FROM professor WHERE cpf='$_SESSION[usuario]'");
  $Professor=$consultarProfessor->fetch(PDO::FETCH_ASSOC);
  $idProfessor=$Professor['idProfessor'];

  $consulta=$pdo->query("SELECT * FROM notas, aluno WHERE notas.idAluno='$buscar' AND aluno.idAluno='$buscar' AND notas.idProfessor='$idProfessor' AND notas.disciplina='$idDisciplina'");
   

  if($consulta->rowCount()>0){
     $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $cont=0;

      foreach($resultado as $valor){

        echo "<fieldset class=\"legenda\">
            <legend>$valor[nome]</legend>";

        for($cont=1;$cont<=4;$cont++){
           if($valor['nota'.$cont] == null){

            echo"
            <div class=\"row\"> 
              <div class=\"col-xs-12 col-md-3\">
            <div class=\"input-group\">
                <span class=\"input-group-addon\">
                    <label for=\"nota".$cont."\">".$cont."ª Nota</label>
                </span>
                <div class=\"controls\">
                    <input class=\"form-control\" type=\"number\" id=\"nota".$cont."\" name=\"nota".$cont."\" />
                </div>
            </div>
              </div><!-- GRUPO nome aluno-->

              <div class=\"col-xs-12 col-md-6\">
            <div class=\"input-group\">
                <span class=\"input-group-addon\">
                    <label for=\"descn".$cont."\">Descrição da nota</label>
                </span>
                <div class=\"controls\">
                 <select class=\"form-control select-width\" id=\"descricaonota".$cont."\" name=\"descricaonota".$cont."\">
                  <option value=\"0\">Selecione o tipo de nota</option>
                   <option value=\"Prova escrita\">Prova escrita</option>
                   <option value=\"Avaliação contianada\">Avaliação contianada</option>
                   <option value=\"Trabalho individual\">Trabalho individual</option>
                   <option value=\"Trabalho em grupo\">Trabalho em grupo</option>
                   <option value=\"Conselho de classe\">Conselho de classe</option>
                 </select>
                </div>
            </div>
              </div><!-- GRUPO decricao nota".$cont."-->
            </div><!-- ROW NOTA ALUNO-->
            ";
           //Mostragem das notas do aluno

           }else{
             //MOSTRA NOTAS SOMENTE VIZUALIZAR
            echo"
            <div class=\"row\"> 
             <div class=\"col-xs-12 col-md-3\">
            <div class=\"input-group\">
                <span class=\"input-group-addon\">
                    <label for=\"nota".$cont."\">".$cont."ª Nota</label>
                </span>
                <div class=\"controls\">
                    <input class=\"form-control\" type=\"number\" id=\"nota".$cont."\" name=\"nota".$cont."\" value=\"".$valor['nota'.$cont]."\" readonly=\"readonly\"/>
                </div>
            </div>
             </div><!-- GRUPO nome aluno-->

             <div class=\"col-xs-12 col-md-6\">
            <div class=\"input-group\">
                <span class=\"input-group-addon\">
                    <label for=\"descn".$cont."\">Descrição da nota</label>
                </span>
                <div class=\"controls\">
                 <select class=\"form-control select-width\" id=\"descricaonota".$cont."\" name=\"descricaonota".$cont."\" readonly=\"readonly\">
                   <option value=\"".$valor['descricao'.$cont]."\">".$valor['descricao'.$cont]."</option>
                 </select>
                </div>
            </div>
             </div><!-- GRUPO decricao nota".$cont."-->
            </div><!-- ROW NOTA ALUNO-->
            ";
           }

        }//termina mostragem de notas
         echo"<input type=\"hidden\" id=\"codigoNota\" name=\"codigoNota\" value=\"$valor[codigoNota]\"/>";
        echo "</fieldset>";
  }
 }else{
  echo "Dados não econtrados!";
}

}//FIM MODULO NOTAS
/******************************* EDITAR NOTAS ***********************************************/
elseif(isset($_GET['modulo']) AND $_GET['modulo']=="notasEdit"){
 //carrega as notas do aluno escolhido
$dadosBusca=explode("-",$_GET['buscar']);
$disciplina=$dadosBusca['1'];
$buscar=$dadosBusca['0'];

$pdo=connect_db();
session_start();
  
  $buscarDisciplina=$pdo->query("SELECT idDisciplinas FROM disciplina where nome_disciplina='$disciplina'");
  $Disciplina=$buscarDisciplina->fetch(PDO::FETCH_ASSOC);
  $idDisciplina=$Disciplina['idDisciplinas'];

  $consultarProfessor=$pdo->query("SELECT idProfessor FROM professor WHERE cpf='$_SESSION[usuario]'");
  $Professor=$consultarProfessor->fetch(PDO::FETCH_ASSOC);
  $idProfessor=$Professor['idProfessor'];

$consulta=$pdo->query("SELECT * FROM notas, aluno WHERE notas.idAluno='$buscar' AND aluno.idAluno='$buscar' AND notas.idProfessor= '$idProfessor' AND notas.disciplina='$idDisciplina'");
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

  if($consulta->rowCount()>0){

      foreach($resultado as $valor){

echo "<fieldset class=\"legenda\">
    <legend>$valor[nome]</legend>";

for($cont=1;$cont<=4;$cont++){
 if($valor['nota'.$cont]!=null AND $valor['descricao'.$cont] != 0 OR $valor['descricao'.$cont]!=NULL){

   //MOSTRA NOTAS SOMENTE VIZUALIZAR
  echo"
  <div class=\"row\"> 
   <div class=\"col-xs-12 col-md-3\">
  <div class=\"input-group\">
      <span class=\"input-group-addon\">
          <label for=\"nota".$cont."\">".$cont."ª Nota</label>
      </span>
      <div class=\"controls\">
          <input class=\"form-control\" type=\"number\" id=\"nota".$cont."\" name=\"nota".$cont."\" value=\"".$valor['nota'.$cont]."\" />
      </div>
  </div>
   </div><!-- GRUPO nome aluno-->

   <div class=\"col-xs-12 col-md-6\">
  <div class=\"input-group\">
      <span class=\"input-group-addon\">
          <label for=\"descn".$cont."\">Descrição da nota</label>
      </span>
      <div class=\"controls\">
       <select class=\"form-control select-width\" id=\"descricaonota".$cont."\" name=\"descricaonota".$cont."\">
         <option value=\"".$valor['descricao'.$cont]."\">".$valor['descricao'.$cont]."</option>
         <option value=\"0\">Selecione o tipo de nota</option>
         <option value=\"Prova escrita\">Prova escrita</option>
         <option value=\"Avaliação contianada\">Avaliação contianada</option>
         <option value=\"Trabalho individual\">Trabalho individual</option>
         <option value=\"Trabalho em grupo\">Trabalho em grupo</option>
         <option value=\"Conselho de classe\">Conselho de classe</option>
       </select>
      </div>
  </div>
   </div><!-- GRUPO decricao nota".$cont."-->

  </div><!-- ROW NOTA ALUNO-->
  ";
  
 }

}//termina mostragem de notas

echo"<input type=\"hidden\" name=\"codigoNota\" value=\"".$valor['codigoNota']."\"/>";
echo "</fieldset>";
  }
 }else{
  echo "Dados não econtrados!";
}

}//FIM MODULO NOTAS

/******************************* LISTAR NOTAS ***********************************************/
    elseif(isset($_GET['modulo']) AND $_GET['modulo']=="listarNotas"){
 //carrega as notas do aluno escolhido

$buscar=$_GET['buscar'];
     $pdo=connect_db();
    $consulta=$pdo->query("SELECT * FROM notas WHERE codigoNota='$buscar'");
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

           if($consulta->rowCount()>0){
            foreach($resultado as $valor){
            echo 
            "<td class=\"disciplina\">$valor[disciplina]</td>
    <td>$valor[nota1]</td>
    <td>$valor[nota2]</td>
    <td>$valor[nota3]</td>
    <td>$valor[nota4]</td>
    <td>$valor[recuperacao]</td>";
            }
           }else{
            echo "<option value=\"0\">Dados não econtrados!</option>";
           }
/******************************** LISTAR ESTADOS ********************************************/

}elseif(isset($_GET['modulo']) AND $_GET['modulo']=="estado"){
//CARREGA OS DADOS DO ESTADO

      $buscar=$_GET['buscar'];
      $pdo=connect_db();
    $consulta=$pdo->query("SELECT * FROM cidades WHERE nome_uf='$buscar'");
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

           if($consulta->rowCount()>0){
            foreach($resultado as $valor){
            echo "<option value=\"$valor[municipio]\">$valor[municipio]</option>";
            }
           }else{
            echo "<option value=\"0\">Dados não econtrados!</option>";
           }

/***************************** LISTAR PROFESSOR DISCIPLINA **********************************/ 

}elseif(isset($_GET['modulo']) AND $_GET['modulo']=="disciplinaProfessor"){

$pdo=connect_db();
     $disciplina=$_GET['buscar'];//recebe o id da disciplina

     $consultaDisciplina=$pdo->query("SELECT nome_disciplina FROM disciplina WHERE idDisciplinas='$disciplina'");
       $resultado=$consultaDisciplina->fetch(PDO::FETCH_ASSOC);
        $disciplina=$resultado['nome_disciplina'];//atualiza o valor pelo nome da disciplina

/********************** BUSCA O PROFESSOR QUE LECIONA A DISCIPLINA **************************/

     $consulta=$pdo->query("SELECT disciplinas  FROM professor");
     $resultado=$consulta->fetchAll(PDO::FETCH_ASSOC);
      
   $disciplinaProfessor="";

    foreach($resultado as $valor){
    //COMPARA AS DISCIPLINAS ENCONTRADAS NO CADASTRO DO PROFESSOR COM A ESCOLHIDA
     $comparar=explode("-", $valor['disciplinas']);
     if($comparar=$disciplina){
     $disciplinaProfessor = $comparar;
   }
   }  
     $consulta=$pdo->query("SELECT idProfessor, nome, disciplinas FROM professor WHERE disciplinas like '%$disciplinaProfessor%'");
      $resultado=$consulta->fetchAll(PDO::FETCH_ASSOC);

     if($consulta->rowCount()>0){
      echo"<option value=\"0\">Selecione o professor</option>";
     foreach($resultado as $dados){

   echo"
     <option value=\"$dados[idProfessor]\">$dados[nome]</option>
   ";
     }
   }else{
     echo "<option value=\"0\">Não há professor para essa disciplina</option>";
    }
/************************** fim funçao busca professor disciplina *******************************/

/************************** CARREGA O HORARIO DA TURMA *******************************/ 
}elseif(isset($_GET['modulo']) AND $_GET['modulo']=="quadroHorarioTurma"){

$buscar=$_GET['turma'];
     $pdo=connect_db();
    $consulta=$pdo->query("SELECT * FROM horario_turma, turma WHERE horario_turma.idTurma='$buscar' AND turma.idTurma='$buscar' ORDER BY horario_turma.horario_inicio_aula ASC");

 $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

  if($consulta->rowCount()>0 AND $resultado[0]['horario_inicio_aula']!=null){//verifica se foi encontrato algum horario cadastrado na turma
    
            echo "            
            <caption id=\"nomeTurma\">Quadro de Horário da Turma</caption>
             <tr class=\"quadroHorario\">
               <th>Horário da Aula</th>
               <th>Segunda</th> 
               <th>Terça</th>              
               <th>Quarta</th> 
               <th>Quinta</th>
               <th>Sexta</th>
               <th>Sábado</th>
               <th>Domingo</th>
             </tr>";

  foreach ($resultado as $key=>$horario){

    echo"<tr class=\"disciplina\">";
    echo"
    <td>
     <a href=\"_funcoes/excluirHorarioTurma.php?horario=".$horario['horario_inicio_aula']."-".$horario['horario_termino_aula']."&turma=".$horario['idTurma']."\"> 
      <span class=\"glyphicon glyphicon-trash\" title=\"Remover este horario\">
       
      </span></a>
      ".substr($horario['horario_inicio_aula'], 0, 5) ." - ". substr($horario['horario_termino_aula'], 0, 5)."</td>";
        filtrarDisciplinaProfessor($horario['segunda']);
        filtrarDisciplinaProfessor($horario['terca']);
        filtrarDisciplinaProfessor($horario['quarta']);
        filtrarDisciplinaProfessor($horario['quinta']);
        filtrarDisciplinaProfessor($horario['sexta']);
        filtrarDisciplinaProfessor($horario['sabado']);
        filtrarDisciplinaProfessor($horario['domingo']);
    echo"</tr>";
  }


   }else{
    echo "<tr class=\"disciplina\">Horário da Turma não construído!</tr>";
    }


}else{
 echo "<option value=\"0\">Erro ao buscar dados!</option>";
}


?>