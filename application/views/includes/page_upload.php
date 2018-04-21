		    <div class="input-group">
		      <div class="col-md-12 col-xs-12">

		        <!-- MAX_FILE_SIZE deve preceder o campo input -->
		        <input type="hidden" name="MAX_FILE_SIZE" value="4096000" />
		        <!-- O Nome do elemento input determina o nome da array $_FILES -->
		        <figure class="box-upload">
		          <figcaption id="titulo">Adicionar Foto</figcaption>
		          <img id="foto" src="<?= base_url('assets/img/camera.png');?>" alt="foto" title="foto" class="img-upload" />
		        </figure>
		         
		      <label class="form-control-file file" for="file">
		        <input type="file" id="file" class="form-control-file" name="userfile" onChange="carregarFoto(this)">
		        <span class="btn-file">Escolha o arquivo</span>
		        <span class="file-descricao" id="descricao">Nenhum arquivo selecionado</span>
		      </label>

		      </div>

		    </div><!--Input group-->

<script type="text/javascript">

  function carregarFoto(foto) {
    var imagem = document.getElementById('foto');

      if (foto.value == "") { 
        imagem.setAttribute("src",'<?= base_url('assets/img/camera.png');?>');
        imagem.style.width = "60px";
        imagem.style.height = "60px";
        titulo.style.display = "initial";
      } else {

        var myForm = document.getElementById('form_cad');
        formData = new FormData(myForm);


       var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function() {
        
        document.getElementById('foto').setAttribute("src",this.responseText);

        var imagem = document.getElementById('foto');
        var titulo = document.getElementById('titulo');
        var descricao = document.getElementById('descricao');

        descricao.innerHTML = this.responseText;

        imagem.style.width = "100%";
        imagem.style.height = "100%";
        titulo.style.display = "none";
       
       };
       
       xmlhttp.open("POST","http://localhost/xampp/avance/crud/upload_temp", true);
       xmlhttp.send(formData);
      }
  }

  </script>