<?php
   $this->load->view("includes/funcoes.php"); 
     scripts();
?>

<div class="container">
<form id="form_cad" action="<?= base_url('cadastrar/cadastrarEscola');?>" method="post" class="form-horizontal form_cad" enctype="multipart/form-data">
<h3>Formulário de Cadastro / Escola</h3>
<!-- *************************** DADOS PESSOAIS *********************************** -->   

<fieldset class="legenda">
   <legend class="sublegend">Dados da Escola</legend>

<!-- ERROS DE VALIDAÇÃO -->

  <div id="erros" class="alert alert-danger campoErros" role="alert">

  </div>

   <!-- DADOS DA ESCOLA -->

<div class="row">

 <div class="col-xs-12 col-md-6 b-right">
  <div class="">
  <span class="">
  <label for="nome">Nome da Escola</label>
  </span>
  <div class="controls">
   <input type="text" id="nome" name="e_nome" placeholder="Nome registrado da escola" class="form-control inputwidth" required/>
  </div>
  </div>
 </div>

   <div class="col-xs-12 col-md-6">
   <div class="">
   <span class="">
 <label for="situacao_funcionamento">Situação de Funcionamento</label>
   </span>
   <div class="controls">
 <select class="form-control selectwidth" name="situacao" id="situacao_funcionamento" required>
  <option value="0">Situação atual da escola</option>
  <option value="Em atividade">Em atividade - A escola está em funcionamento e realizando atividades escolares.</option>
  <option value="Paralisada">Paralisada - A escola está com as atividades escolares temporariamente suspensas</option>
  <option value="Extinta">Extinta - A escola está com as atividades escolares definitivamente encerradas.</option>
 </select>
   </div>
   </div>
   </div>

</div><!-- row nome cpf -->


<div class="row">

 <div class="col-xs-12 col-md-6 b-right">
  <div class="">
  <span class="">
  <label for="anoletivo">Início do Ano Letivo</label>
  </span>
  <div class="controls">
   <input type="date" id="anoletivo" name="anoletivo" class="form-control dateinput" required/>
  </div>
  </div>
 </div>

 <div class="col-xs-12 col-md-6">
  <div class="">
  <span class="">
  <label for="anoletivot">Término do Ano Letivo</label>
  </span>
  <div class="controls">
   <input type="date" id="anoletivot" name="anoletivot" class="form-control dateinput" required/>
  </div>
  </div>
 </div>
</div>
<div class="row">
   <div class="col-xs-12 col-md-12">
   <div class="">
   <span class="">
 <label for="ocupacao">Forma de Ocupação do Prédio</label>
   </span>
   <div class="controls">
 <select class="form-control selectwidth" name="ocupacao" id="ocupacao" required>
  <option value="0">Situação atual da ocupação da escola</option>
  <option value="Próprio">Próprio - O local de funcionamento é de propriedade da escola.</option>
  <option value="Alugado">Alugado - O local de funcionamento é utilizado pela escola por meio de um contrato de locação com pagamento determinado.</option>
 <option value="Cedido">Cedido - O prédio é utilizado sem ônus para a escola.</option>
 </select>
   </div>
   </div>
   </div>
</div><!-- row ano letivo-->

<div class="row">
 <div class="col-xs-12 col-md-6 ">
  <div class="">
  <span class="">
  <label for="nsalas">Nº Salas de Aula</label>
  </span>
  <div class="controls">
   <input type="number" id="nsalas" name="nsalas" placeholder="Número de salas de aula" class="form-control inputwidth" required/>
  </div>
  </div>
 </div>

 <div class="col-xs-12 col-md-6">
  <div class="">
  <span class="">
  <label for="nsalasfora">Nº Salas Fora</label>
  </span>
  <div class="controls">
   <input type="number" id="nsalasfora" name="nsalasfora" placeholder="Número de salas de aula fora do prédio" class="form-control inputwidth" />
  </div>
  </div>
 </div>
</div><!-- row numero sala de aulas-->

</fieldset>

<?php enderecoContatos();?>
  <fieldset class="legenda">
    <legend>Foto da Escola</legend>

    <?php 
      formularioUpload('escola', 'imagens', 'thumb');
    ?>
  </fieldset>

  <input type="hidden" id="campos" name="campos" value="<?php //camposValidar("escola");?>" />
  <input class="btn btn-success" type="submit" value="Cadastrar Escola" onclick="validarFormulario('escola')" />

</form>
</div>
