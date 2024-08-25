<?php
  include "../../menu/menu.php";

  $_GET['id'];
  
  if($_POST ? true : false) {
    $url = "https://localhost:44331/api/Gondola/InsertGondola";
    $postData = array(
      'id' => (int)$_POST['id'],
      'nome' => $_POST['nome'],
      'codigo' => $_POST['codigo'],
    );
    $options = array(
      'http' => array(
        'method'  => 'POST',
        'content' => json_encode( $postData ),
        'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
        )
    );

    if($_POST['id'] === ""){
      echo '<script>window.location.href = "http://localhost/cadastro_gondola/cadastro_gondola_list/cadastro_gondola_list.php";</script>';
      exit();
    }
    
    $context  = stream_context_create( $options );
    $result = file_get_contents( $url, false, $context );
    $response = json_decode( $result );
    if($response == "201") {
      echo '<script>alert("Gondola cadastrada com sucesso!")</script>';
      echo '<script>window.location.href = "http://localhost/cadastro_gondola/cadastro_gondola_list/cadastro_gondola_list.php";</script>';
    } else {
      echo '<script>alert("Erro no cadastro!")</script>'; 
    }
  }        
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./cadastro_gondola_form.scss">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title>Document</title>
</head>
<body >
  <form method="post">
  <h3>Cadastro de gôndola</h3>
  <div class="espacamento">
    <div style="display: block;">
    <div class="input" style="width: 400px;">
        <span>Id</span>
        <input name="id"></input>
      </div>
      <div class="input" style="width: 400px;">
        <span>Nome</span>
        <input name="nome"></input>
      </div>
      <div class="input" style="width: 400px;">
        <span>Codigo</span>
        <input name="codigo"></input>
      </div>
    </div>
    <div class="buttons" style="display: flex;">
      <button class="btn add">
      <span> Confirmar </span>
      </button>
      <button onclick="location.href='http://localhost/cadastro_gondola/cadastro_gondola_list/cadastro_gondola_list.php';" class="btn cancelar">
      <span> Cancelar </span>
      </button>
    </div>
  </div>
  </form>
</body>
</html>