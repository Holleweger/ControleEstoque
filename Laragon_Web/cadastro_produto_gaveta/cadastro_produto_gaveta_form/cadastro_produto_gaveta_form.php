<?php
  include "../../menu/menu.php";
    /*-----------MENSAGENS----------*/
    if (!array_key_exists('sucess', $_GET)) {
      $_GET['sucess'] = "true";
    }
    /*------------------------------*/

  /*---------URLs----------*/
    $url_back = "https://localhost:44331/api/";
    $controller = "Produto_Gaveta/";
    $url_raiz = "http://localhost/cadastro_produto_gaveta/";
    $url_produto_gaveta_list = "cadastro_produto_gaveta_list/cadastro_produto_gaveta_list.php";
  /*----------------------*/

  /*-----------FORM---------*/
    $response = new stdClass();
    $response -> quantidade = "";
  /*------------------------*/

  /*---------GET_PRODUTOS---------*/
    $produtos = file_get_contents($url_back . "Produto/" . "GetProduto/");
    $_GET['produtos'] = json_decode($produtos);
  /*--------------------------------*/

  /*---------GET_GAVETAS----------*/
    $gavetas = file_get_contents($url_back . "Gaveta/" . "GetGaveta/");
    $_GET['gavetas'] = json_decode($gavetas);
  /*--------------------------------*/

  /*-----EDIT-----*/
  if (array_key_exists('id', $_GET)) {
    $response = file_get_contents($url_back . $controller . "GetProdutoGavetaById/" . $_GET['id']);
    $response = json_decode($response);
    foreach ($_GET['gavetas'] as $gaveta) {
      $gaveta -> selected = $gaveta -> id == $response -> gaveta -> id;
    };
    foreach ($_GET['produtos'] as $produto) {
      $produto -> selected = $produto -> id == $response -> produto -> id;
    };
    if(array_key_exists('submit', $_POST)) {
      $url = $url_back . $controller . "UpdateProdutoGaveta";
      $produto = new stdClass();
      $produto -> id = (int)$_POST['produto'];
      $gaveta = new stdClass();
      $gaveta -> id = (int)$_POST['gaveta'];
      $postData = array(
        'id' => (int)$_GET['id'],
        'quantidade' => (int)$_POST['quantidade'],
        'gaveta' => $gaveta,
        'produto' => $produto,
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
      $produto = new stdClass();
      $produto -> id = (int)$_POST['produto'];
      $gaveta = new stdClass();
      $gaveta -> id = (int)$_POST['gaveta'];
      $url = $url_back . $controller . "InsertProdutoGaveta";
      $postData = array(
        'quantidade' => (int)$_POST['quantidade'],
        'gaveta' => $gaveta,
        'produto' => $produto,
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
    echo '<script>window.location.href = "' . $url_raiz . $url_produto_gaveta_list .'";</script>';
  }
  /*-------------------*/
  
  /*------REQUEST------*/
  if(array_key_exists('submit', $_POST)) {
    $context  = stream_context_create( $options );
    $result = file_get_contents( $url, false, $context );
    $response = json_decode( $result );
    if($response == "201" || $response == "200") {
      echo '<script>window.location.href = "' . $url_raiz . $url_produto_gaveta_list .'?msg_alert=success_form";</script>';
    } else {
      echo '<script>window.location.href = "' . $url_raiz . $url_produto_gaveta_list .'?msg_alert=error_form";</script>';
    }
  }
  /*-------------------*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./cadastro_produto_gaveta_form.scss">
  <script src="C:\ControleEstoque\Laragon_Web\modules\dist\css\adminlte.css"></script>
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css"> -->
  <title>Document</title>
</head>
<body >
  <h3>Cadastro Inventário</h3>
  <form method="post" id="consultation-form" class="feed-form">
    <div class="espacamento">
    </div>
      <section class="section_form">
        <select name="produto">
          <option>Selecione um produto...</option>
          <?php foreach ($_GET['produtos'] as $item): ?>
            <option 
              <?php 
                if (isset($item -> selected)) {
                  echo $item -> selected ? "selected" : false;
                };
              ?>
              value="<?php echo $item -> id ?>">
              <?php echo $item -> codigo . " - " . $item -> nome?>
            </option>
          <?php endforeach ?>
        </select>
        <select name="gaveta">
          <option>Selecione uma gaveta...</option>
          <?php foreach ($_GET['gavetas'] as $item): ?>
            <option 
              <?php 
                if (isset($item -> selected)) {
                  echo $item -> selected ? "selected" : false;
                };
              ?>
              value="<?php echo $item -> id ?>">
              <?php echo $item -> codigo . " - " . $item -> nome?>
            </option>
          <?php endforeach ?>
        </select>
        <input value="<?php echo $response -> quantidade ?>" name="quantidade" required="true" placeholder="Quantidade">
        <button name="submit" class="button_submit">CONFIRMAR</button>
        <button name="cancel" onclick="location.href='http://localhost/cadastro_produto_gaveta/cadastro_produto_gaveta_list/cadastro_produto_gaveta_list.php';" class="button_exit">CANCELAR</button>
      </section>
    </div>
  </div>
</form>
</body>
</html>