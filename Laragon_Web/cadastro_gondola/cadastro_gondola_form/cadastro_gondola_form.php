<?php
  include "../../menu/menu.php";
    /*-----------MENSAGENS----------*/
    if (!array_key_exists('sucess', $_GET)) {
      $_GET['sucess'] = "true";
    }
    /*------------------------------*/

  /*---------URLs----------*/
    $url_back = "https://localhost:44331/api/";
    $controller = "Gondola/";
    $url_raiz = "http://localhost/cadastro_gondola/";
    $url_gondola_list = "cadastro_gondola_list/cadastro_gondola_list.php";

  /*-----------FORM---------*/
    $response = new stdClass();
    $response -> id = "";
    $response -> nome = "";
    $response -> codigo = "";
  /*------------------------*/

  /*-----EDIT-----*/
  if (array_key_exists('id', $_GET)) {
    $response = file_get_contents($url_back . $controller . "GetGondolaById/" . $_GET['id']);
    $response = json_decode($response);
    if(array_key_exists('submit', $_POST)) {
      $url = $url_back . $controller . "UpdateGondola";
      $postData = array(
        'id' => (int)$_POST['id'],
        'nome' => $_POST['nome'],
        'codigo' => $_POST['codigo'],
      );
      $options = array(
        'http' => array(
          'method'  => 'PUT',
          'content' => json_encode( $postData ),
          'header'=>  "Content-Type: application/json\r\n" .
                      "Accept: application/json\r\n"
          )
      );
    }
  /*------------------*/
  
  /*-----CADASTRO-----*/
  } else {
    if(array_key_exists('submit', $_POST)) {
      $url = $url_back . $controller . "InsertGondola";
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
    }
  }
  /*--------------------*/

  /*-----CANCELAR------*/
  if ( array_key_exists('cancel', $_POST)) {
    echo '<script>window.location.href = "' . $url_raiz . $url_gondola_list .'";</script>';
  }
  /*-------------------*/
  
  /*------REQUEST------*/
  if(array_key_exists('submit', $_POST)) {
    $context  = stream_context_create( $options );
    $result = file_get_contents( $url, false, $context );
    $response = json_decode( $result );
    if($response == "201" || $response == "200") {
      echo '<script>window.location.href = "' . $url_raiz . $url_gondola_list .'?msg_alert=success_form";</script>';
    } else {
      echo '<script>window.location.href = "' . $url_raiz . $url_gondola_list .'?msg_alert=error_form";</script>';
    }
  }
  /*-------------------*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./cadastro_gondola_form.scss">
  <script src="C:\ControleEstoque\Laragon_Web\modules\dist\css\adminlte.css"></script>
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css"> -->
  <title>Document</title>
</head>
<body >
  <h3>Cadastro de gôndola</h3>
  <form method="post" id="consultation-form" class="feed-form">
    <div class="espacamento">
    </div>
      <section class="section_form">
        <input placeholder="Id" type="text" value="<?php echo $response -> id ?>" required="true" name="id"></input>
        <input value="<?php echo $response -> nome ?>" name="nome" required="true" placeholder="Nome">
        <input value="<?php echo $response -> codigo ?>" name="codigo" required="true" placeholder="Codigo" type="text">
        <button name="submit" class="button_submit">CONFIRMAR</button>
        <button name="cancel" onclick="location.href='http://localhost/cadastro_gondola/cadastro_gondola_list/cadastro_gondola_list.php';" class="button_exit">CANCELAR</button>
      </section>
    </div>
  </div>
</form>
</body>
</html>