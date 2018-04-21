<?php

define( 'URL_BASE', 'localhost/' );
define( 'URL_FOLDER', 'xampp/avance/' );

define('url_base', URL_BASE.URL_FOLDER); 

$url = url_base;
$uploaddir = $url.'assets/uploads/temp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

//usar depois $_FILES['userfile']['size'] e $_FILES['userfile']['type']

if($_FILES['userfile']['size'] <= 4096000 AND ($_FILES['userfile']['type'] == "image/png" OR $_FILES['userfile']['type'] == "image/jpeg")){

  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
  		$uploaddir = $url.'assets/uploads/temp/';
  		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
      echo $uploadfile;
  } else {
      echo "Possível ataque de upload de arquivo!";
  }
}


?>