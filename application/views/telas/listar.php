<?php

echo '<h2>Lista de Usuários</h2>';

if($this->session->flashdata('excluidook')):
    echo '<p>'.$this->session->flashdata('excluidook').'</p>'; 
endif;

$this->table->set_heading('Nome','CPF','Operações');
foreach($usuarios as $linha):
    $this->table->add_row($linha->nome,$linha->cpf,anchor("crud/atualizar/$linha->id",'Editar').' '.anchor("crud/excluir/$linha->id",'Excluir'));
endforeach;

echo $this->table->generate();