<?php
  include "../../menu/menu.php";
    /*-----------MENSAGENS----------*/
    if (!array_key_exists('sucess', $_GET)) {
      $_GET['sucess'] = "true";
    }
    /*------------------------------*/

  /*---------URLs----------*/
    $url_back = "https://localhost:44331/api/";
    $controller = "Gaveta/";
    $url_raiz = "http://localhost/cadastro_gaveta/";
    $url_gaveta_list = "cadastro_gaveta_list/cadastro_gaveta_list.php";
  /*----------------------*/

  /*-----------FORM---------*/
    $response = new stdClass();
    $response -> id = "";
    $response -> nome = "";
    $response -> codigo = "";
  /*------------------------*/

  /*---------GET_GONDOLAS---------*/
    $gondolas = file_get_contents($url_back . "Gondola/" . "GetGondola/");
    $_GET['gondolas'] = json_decode($gondolas);
  /*--------------------------------*/

  /*-----EDIT-----*/
  if (array_key_exists('id', $_GET)) {
    $response = file_get_contents($url_back . $controller . "GetGavetaById/" . $_GET['id']);
    $response = json_decode($response);
    foreach ($_GET['gondolas'] as $gondola) {
      $gondola -> selected = $gondola -> id == $response -> gondola -> id;
    };
    if(array_key_exists('submit', $_POST)) {
      $url = $url_back . $controller . "UpdateGaveta";
      $gondola = new stdClass();
      $gondola -> id = (int)$_POST['gondola'];
      $postData = array(
        'id' => (int)$_GET['id'],
        'nome' => $_POST['nome'],
        'codigo' => $_POST['codigo'],
        'gondola' => $gondola,
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
      $gondola = new stdClass();
      $gondola -> id = (int)$_POST['gondola'];
      $url = $url_back . $controller . "InsertGaveta";
      $postData = array(
        'id' => 0,
        'nome' => $_POST['nome'],
        'codigo' => $_POST['codigo'],
        'gondola' => $gondola,
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
    echo '<script>window.location.href = "' . $url_raiz . $url_gaveta_list .'";</script>';
  }
  /*-------------------*/
  
  /*------REQUEST------*/
  if(array_key_exists('submit', $_POST)) {
    $context  = stream_context_create( $options );
    $result = file_get_contents( $url, false, $context );
    $response = json_decode( $result );
    if($response == "201" || $response == "200") {
      echo '<script>window.location.href = "' . $url_raiz . $url_gaveta_list .'?msg_alert=success_form";</script>';
    } else {
      echo '<script>window.location.href = "' . $url_raiz . $url_gaveta_list .'?msg_alert=error_form";</script>';
    }
  }
  /*-------------------*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./cadastro_gaveta_form.scss">
  <script src="C:\ControleEstoque\Laragon_Web\modules\dist\css\adminlte.css"></script>
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css"> -->
  <title>Document</title>
</head>
<body >
  <h3>Cadastro de gaveta</h3>
  <form method="post" id="consultation-form" class="feed-form">
    <div class="espacamento">
    </div>
      <section class="section_form">
        <input value="<?php echo $response -> nome ?>" name="nome" required="true" placeholder="Nome">
        <input value="<?php echo $response -> codigo ?>" name="codigo" required="true" placeholder="Codigo" type="text">
          <select name="gondola">
            <option>Selecione uma gôndola...</option>
            <?php foreach ($_GET['gondolas'] as $item): ?>
              <option 
                <?php 
                  if (isset($item -> selected)) {
                    echo $item -> selected ? "selected" : false;
                  };
                ?>
                value="<?php echo $item -> id ?>">
                <?php echo $item -> nome?>
              </option>
            <?php endforeach ?>
          </select>
        <button name="submit" class="button_submit">CONFIRMAR</button>
        <button name="cancel" onclick="location.href='http://localhost/cadastro_gaveta/cadastro_gaveta_list/cadastro_gaveta_list.php';" class="button_exit">CANCELAR</button>
      </section>
    </div>
  </div>
</form>
</body>
</html>