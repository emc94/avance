<?php
if(isset($mensagem) AND $mensagem!=''){
    $pagina = str_replace('-','/',$pagina);
    $pagina=base_url($pagina);

    header('refresh:2;url='.$pagina);

    echo'<div class="container>
            <div class="row">
    ';
    
	$notificacao = $mensagem;//recebe os dados da sessao com a notificação

    if($status == 'error'){//mostra a mensagem em caso de erro
        echo"
        <div class=\"error_center\">
        <div class=\"row col-md-9 col-xs-12\">
        <div class=\"alert alert-danger\" role=\"alert\">
        <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
        <span class=\"sr-only\">Por favor, verifique os erros abaixo:</span>
        <p>".$mensagem."</p>
        </div>
        </div>
        </div>";
        echo '</body>
        </html>';

    }elseif($status=='sucesso'){
        echo"
        <div class=\"error_center\">
        <div class=\"row col-md-9 col-xs-12\">
        <div class=\"alert alert-success\" role=\"alert\">
        <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
        <span class=\"sr-only\">$mensagem</span>
        </div>
        </div>
        </div>";
        echo '</body>
        </html>';
    }elseif($status == 'sessao'){
        echo"
        <div class=\"error_center\">
        <div class=\"row col-md-9 col-xs-12\">
        <div class=\"alert alert-danger\" role=\"alert\">
        <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
        <span class=\"sr-only\">$mensagem</span>
        </div>
        </div>
        </div>";
        echo '</body>
        </html>';
    }
echo '</div></div>';

}else{
	echo"
	<div class=\"error_center\">
	 <div class=\"row col-md-9 col-xs-12\">
	  <div class=\"alert alert-danger\" role=\"alert\">
  	   <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
 	   <span class=\"sr-only\">Error:</span>
  	    Erro ao resgatar os dados da página!
	  </div>
	 </div>
	</div>";
	echo '</body>
	</html>';
}

?>