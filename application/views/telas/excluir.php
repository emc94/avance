<?php
$idUser = $this->uri->segment(3);

if($idUser == NULL) redirect('crud/listar');


$query = $this->crud_model->get_byId($idUser)->row();

echo form_open("crud/excluir/$idUser");

echo validation_errors('<span class="error">','</span>');

echo form_label('Nome','nome');
echo form_input(array('id'=>'nome','name'=>'nome', 'value'=>$query->nome));
echo form_label('CPF','cpf');
echo form_input(array('id'=>'cpf','name'=>'cpf', 'value'=>$query->cpf));

echo form_submit(array('name'=>'excluir'),'Excluir');
echo form_hidden('idUsuario', $query->id);

echo form_close();