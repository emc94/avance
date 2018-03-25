<?php
echo form_open('crud/cadastrar');

echo validation_errors('<span class="error">','</span>');
if($this->session->flashdata('cadastrook')):
    echo '<p>'.$this->session->flashdata('cadastrook').'</p>'; 
endif;


echo form_label('Nome Completo','nome');
echo form_input(array('id'=>'nome','name'=>'nome', set_value('nome'), 'autofocus'));
echo form_label('CPF','cpf');
echo form_input(array('id'=>'cpf','name'=>'cpf', set_value('cpf')));
echo form_label('Senha','senha');
echo form_password(array('id'=>'senha','name'=>'senha'));
echo form_label('Repita a Senha','senha2');
echo form_password(array('id'=>'senha2','name'=>'senha2'));
echo form_submit(array('cadastrar'),'Cadastrar');

echo form_close();