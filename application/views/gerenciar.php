
<div class="col-md-9 col-xs-12 modulos">

<?php

	if(isset($modulo) AND $modulo == 'alunos'){
    //MÓDULO DE GESTÃO DE ALUNOS
?>

	<ul>
	<?php
        if($_SESSION['logged']['sigeUserNivel'] == 'd'){//VERIFICA SE O NIVEL E O DE DIRETOR
	?>
    <li>
        <a href="<?= base_url('/cadastrar/aluno');?>">
            <article>
            <figure>
                <img src="../assets/img/icone.cadastrarProfessor.png" alt="">
                <figcaption>Editar Lançar Notas Aluno</figcaption>
            </figure>
            <h6>Matricular Aluno</h6>
            </article>	
    	</a>
    </li>
    <li>
    	<a href="index.php?page=listar&modulo=aluno">
            <article>
            <figure>
                <img src="../assets/img/icone.cadastrarProfessor.png" alt="">
                <figcaption>Listar Aluno</figcaption>
            </figure>
            <h6>Listar Alunos</h6>
            </article>	
    	</a>
    </li>
    <li>
    	<a href="index.php?page=buscar&modulo=alunos">
            <article>
            <figure>
                <img src="../assets/img/buscar.png" alt="">
                <figcaption>Buscar Aluno</figcaption>
            </figure>
            <h6>Buscar Aluno</h6>
            </article>	
    	</a>
    </li>
	<?php
	}else{//caso seja secretario
	?>
	<li>
        <a href="index.php?page=listar&modulo=aluno">
        <article>
            <figure>
                <img src="../assets/img/icone.cadastrarProfessor.png" alt="">
                <figcaption>Editar Lançar Notas Aluno</figcaption>
            </figure>

        	<h6>Listar Alunos</h6>

        </article>	
        </a>
	</li>
	<li>
        <a href="index.php?page=buscar&modulo=alunos">
            <article>
                <figure>
                    <img src="../assets/img/icone.cadastrarProfessor.png" alt="">
                    <figcaption>Editar Lançar Notas Aluno</figcaption>
                </figure>

            	<h6>Buscar Aluno</h6>

            </article>	
        </a>
	</li>
	<?php	
    }
	?>
	</ul>    
<?php
	}elseif($modulo == 'diretores'){
	//MÓDULO DE GESTÃO DE DIRETORES
?>

<ul>        	
    <li>
    <a href="<?= base_url('/cadastrar/diretor');?>">
        <article>
        <figure>
            <img src="../assets/img/icone.cadastrarProfessor.png" alt="">
            <figcaption>Cadastrar Diretor</figcaption>
        </figure>
        	<h6>Cadastrar Diretor</h6>
        </article>	
    	</a>
    </li>
    <li>
    	<a href="index.php?page=listar&modulo=diretor">
        <article>
        <figure>
            <img src="../assets/img/icone.cadastrarProfessor.png" alt="">
            <figcaption>Listar Diretores</figcaption>
        </figure>

        	<h6>Listar Diretores</h6>	

        </article>
    	</a>
    </li>
    <li>
        <a href="index.php?page=buscar&modulo=diretor">
            <article>
            <figure>
                <img src="../assets/img/buscar.png" alt="">
                <figcaption>Buscar Diretor</figcaption>
            </figure>

            <h6>Buscar Diretor</h6>

            </article>  
        </a>
    </li>

</ul>

<?php
	}elseif($modulo == 'professores'){
//MÓDULO DE GESTÃO DE PROFESSORES
?>

<ul>
    <?php
      if($_SESSION['logged']['sigeUserNivel'] == 's'){//VERIFICA SE O NIVEL E O DE GESTOR
    ?>
	<li>
        <a href="<?= base_url('/cadastrar/professor');?>">
        <article>
        <figure>
            <img src="../assets/img/icone.cadastrarProfessor.png" alt="">
            <figcaption>Cadastrar Professor</figcaption>
        </figure>

        	<h6>Cadastrar Professor</h6>

        </article>
        </a>
	</li>
    <?php
      }
    ?>
	<li>
        <a href="index.php?page=listar&modulo=professor">
        <article>
        <figure>
            <img src="../assets/img/icone.listarProfessor.png" alt="">
            <figcaption>Icone Listar Professores</figcaption>
        </figure>

        	<h6>Listar Professores</h6>

        </article>
        </a>
	</li>
    <li>
        <a href="index.php?page=buscar&modulo=professor">
            <article>
            <figure>
                <img src="../assets/img/buscar.png" alt="">
                <figcaption>Buscar Professor</figcaption>
            </figure>

            <h6>Buscar Professor</h6>

            </article>  
        </a>
    </li>


</ul>

<?php
	}elseif($modulo == 'turmas'){
	//MÓDULO DE GESTÃO DE TURMAS
?>

<ul>        	
    <li>
    	<a href="<?= base_url('/cadastrar/turma');?>">
        <article>
        <figure>
            <img src="../assets/img/icone.cadastrarProfessor.png" alt="">
            <figcaption>Editar Lançar Notas Aluno</figcaption>
        </figure>

        	<h6>Cadastrar Turma</h6>

        </article>	
    	</a>
    </li>
    <li>
    	<a href="index.php?page=listar&modulo=turma">
        <article>
        <figure>
            <img src="../assets/img/icone.cadastrarProfessor.png" alt="">
            <figcaption>Editar Lançar Notas Aluno</figcaption>
        </figure>

        	<h6>Listar Turmas</h6>

        </article>	
    	</a>
    </li>
    <li>
        <a href="index.php?page=buscar&modulo=turma">
            <article>
            <figure>
                <img src="../assets/img/buscar.png" alt="">
                <figcaption>Buscar Turma</figcaption>
            </figure>

            <h6>Buscar turma</h6>

            </article>  
        </a>
    </li>
</ul>

<?php
	}elseif($modulo == 'escolas'){
	//MÓDULO DE GESTÃO DE ESCOLAS
?>

<ul>        	
    <li>
    	<a href="<?= base_url('/cadastrar/escola');?>">
        <article>
        <figure>
            <img src="../assets/img/icone.cadastrarEscola.png" alt="">
            <figcaption>Editar Lançar Notas Aluno</figcaption>
        </figure>

        	<h6>Cadastrar Escolas</h6>

        </article>	
    	</a>
    </li>
    <li>
    	<a href="index.php?page=listar&modulo=escola">
        <article>
        <figure>
            <img src="../assets/img/icone.listarEscola.png" alt="">
            <figcaption>Listar Escolas</figcaption>
        </figure>

        	<h6>Listar Escolas</h6>	

        </article>
    	</a>
    </li>
    <li>
        <a href="index.php?page=buscar&modulo=escola">
            <article>
            <figure>
                <img src="../assets/img/buscar.png" alt="">
                <figcaption>Buscar Escola</figcaption>
            </figure>

            <h6>Buscar Escola</h6>

            </article>  
        </a>
    </li>

</ul>


<?php
	}elseif($modulo == 'horarios'){
	//MÓDULO DE GESTÃO DE HORÁRIOS
?>

<ul>        	
    <li>
    	<a href="<?= base_url('cadastrar/horario');?>">
        <article>
        <figure>
            <img src="../assets/img/icone.quadroHorario.png" alt="">
            <figcaption>Editar Lançar Notas Aluno</figcaption>
        </figure>

        	<h6>Montar Horário da Turma</h6>	

        </article>
    	</a>
    </li>
</ul>

<?php

}elseif($modulo == 'notasefaltas'){
	//MÓDULO DE GESTÃO DE NOTAS E FALTAS
?>
<ul>        	
    <li>
    	<a href="index.php?page=form_cad_notas">

        <article>
        <figure>
            <img src="../assets/img/icone.lançarnotas.png" alt="">
            <figcaption>Icone Lançar Notas Aluno</figcaption>
        </figure>

         <h6>Lançar Notas</h6>

        </article>	
    	</a>
    </li>
    <li>
    	<a href="index.php?page=form_edicao_notas">
        <article>
        <figure>
            <img src="../assets/img/icone.editarnotas.png" alt="">
            <figcaption>Editar Lançar Notas Aluno</figcaption>
        </figure>

        	<h6>Editar Notas</h6>

        </article>
    	</a>
    </li>
    <li>

    	<a href="index.php?page=form_cad_faltas">
        <article>
        <figure>
            <img src="../assets/img/icone.lançarfrequencia.png" alt="">
            <figcaption>Icone Lançar Frequencia Aluno</figcaption>
        </figure>

        	<h6>Lançar Frequência</h6>	

        </article>

    	</a>
    </li>
    <li>

        <a href="index.php?page=gerenciarFrequencia">
        <article>
        <figure>
            <img src="../assets/img/icone.gerenciarfrequencia.png" alt="">
            <figcaption>Icone Gerenciar Frequencia Aluno</figcaption>
        </figure>

            <h6>Gerênciar Frequências</h6> 

        </article>
        </a>
    </li> 
    <!--   
    <li>
        <a href="index.php?page=form_remocao_falta" title="Aqui é possível remover as faltas de um aluno">
        <article>
        <figure>
            <img src="../assets/img/icone.removerfaltas.png" alt="">
            <figcaption>Icone Remover Faltas</figcaption>
        </figure>

            <h6>Remover Faltas</h6> 
        </article>
        </a>
    </li>
-->

</ul>

<?php
}else{
    echo"Módulo de gestão não encontrado!";
    echo"<pre>";
        var_dump($_GET);
    echo"</pre>";
        //header("refresh:5;url=index.php?page=home");
	}
?>
</div>