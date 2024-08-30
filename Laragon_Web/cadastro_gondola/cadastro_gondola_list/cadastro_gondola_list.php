<?php
  include "../../menu/menu.php";
    /*-------------URLs-------------*/
    $url_back = "https://localhost:44331/api/";
    $controller = "Gondola/";
    $url_raiz = "http://localhost/cadastro_gondola/";
    $url_gondola_list = "cadastro_gondola_list/cadastro_gondola_list.php";
    $url_gondola_form = "cadastro_gondola_form/cadastro_gondola_form.php";
  /*------------------------------*/

    /*-----------NOVO------------*/
    if (array_key_exists('novo', $_POST)) {
      echo '<script>window.location.href ="' . $url_raiz . $url_gondola_form . '";</script>';
    }
    /*--------------------------*/

    /*-----------FILTRAR------------*/
    if ( array_key_exists('filtrar', $_POST)) {
      $_POST['id'] = array_key_exists('id', $_POST) ? $_POST['id'] : 0;
      $_POST['nome'] = array_key_exists('nome', $_POST) ? $_POST['nome'] : null;
      $_POST['codigo'] = array_key_exists('codigo', $_POST) ? $_POST['codigo'] : null;
        $url = $url_back . $controller . "FiltrarGondola";
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
        $context  = stream_context_create( $options );
        
        $result = file_get_contents( $url, false, $context );
        $_GET['response'] = json_decode( $result );
        
      } else {
        $response = file_get_contents("https://localhost:44331/api/Gondola/GetGondola");
        $_GET['response'] = json_decode($response);
      }
    /*------------------------------*/

  if ($_POST) {
    /*-------------EDIT-------------*/
    if ( array_key_exists('edit', $_POST) && $_POST['edit'] != "") {
      echo '<script>window.location.href ="' . $url_raiz . $url_gondola_form . '?id=' . $_POST['edit'] .'";</script>';
    }
    /*------------------------------*/
  
    /*-----------EXCLUIR------------*/
    if ( array_key_exists('delete', $_POST) && $_POST['delete'] != "") {
      $url = "https://localhost:44331/api/Gondola/DeleteGondola/" . $_POST['delete'];
      $options = array(
        'http' => array(
          'method'  => 'DELETE'
          )
      );
      $context  = stream_context_create( $options );
      $result = file_get_contents( $url, false, $context );
      $response = json_decode( $result );
    }
    /*------------------------------*/
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./cadastro_gondola_list.scss">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title>Document</title>
</head>
<body>
  <h3>Cadastro de gôndola</h3>
  <div class="espacamento">
    <form method="post">
    <div style="display: flex;">
      <div class="input" style="width: 30px;">
        <span>Id</span>
        <input type="number" name="id"></input>
      </div>
      <div class="input" style="width: 30px; margin-left: 150px;">
        <span>Nome</span>
        <input type="text" name="nome"></input>
      </div>
      <div class="input" style="width: 30px; margin-left: 150px;">
        <span>Codigo</span>
        <input type="text" name="codigo"></input>
      </div>
    </div>
    <div class="buttons" style="display: flex;">
        <button class="btn add" name="novo">
          <span> Nova gôndola </span>
          <span style="margin-left: 3px;" class="fas fa-plus"></span>
        </button>
        <button name="filtrar" class="btn filter">
          <span> Filtrar </span>
          <span style="margin-left: 3px;" class="fas fa-search"></span>
        </button>
      </div>
      <table>
        <tr>
          <th>Id</th>
          <th>Nome</th>
          <th>Código</th>
          <th>Ações</th>
      </tr>
      <?php foreach ($_GET['response'] as $item): ?>
        <tr>
          <td><?= $item -> id ?></td>
          <td><?= $item -> nome ?></td>
          <td><?= $item -> codigo ?></td>
          <td style='display: flex;'>
          <button class='btn edit' name='edit' value='<?= $item -> id ?>'>
          <span> Editar </span>
          <span style='margin-left: 3px;' class='fas fa-pen'></span>
          </button> 
          <button class='btn excluir' name='delete' value='<?= $item -> id ?>'>
            <span> Excluir </span>
            <span style='margin-left: 3px;' class='fas fa-close'></span>
          </button>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </form>
  </div>
</body>
</html>