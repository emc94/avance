<?php
$idUser = $this->uri->segment(3);

if($idUser == NULL) redirect('crud/listar');


$query = $this->crud_model->get_byId($idUser)->row();

echo form_open("crud/atualizar/$idUser");

echo validation_errors('<span class="error">','</span>');
if($this->session->flashdata('edicaook')):
    echo '<p>'.$this->session->flashdata('edicaook').'</p>'; 
endif;


echo form_label('Nome Completo','nome');
echo form_input(array('id'=>'nome','name'=>'nome', 'value'=>$query->nome, 'autofocus'));
echo form_label('CPF','cpf');
echo form_input(array('id'=>'cpf','name'=>'cpf', 'value'=>$query->cpf));

echo form_submit(array('cadastrar'),'Editar Informações');
echo form_hidden('idUsuario', $query->id);

echo form_close();