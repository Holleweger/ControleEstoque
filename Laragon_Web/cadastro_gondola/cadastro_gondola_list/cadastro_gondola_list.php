<?php
  include "../../menu/menu.php";
  if ($_POST) {
    /*-------------URLs-------------*/
      $url_back = "https://localhost:44331/api/";
      $controller = "Gondola/";
      $url_raiz = "http://localhost/cadastro_gondola/";
      $url_gondola_list = "cadastro_gondola_list/cadastro_gondola_list.php";
      $url_gondola_form = "cadastro_gondola_form/cadastro_gondola_form.php";
    /*------------------------------*/

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
      if($response == "201" || $response == "200") {
        echo '<script>alert("Menu excluído com sucesso!")</script>'; 
        echo '<script>window.location.href = "' . $url_raiz . $url_gondola_list .'";</script>';
      } else {
        echo '<script>alert("Erro no cadastro!")</script>'; 
      }
    }
    /*------------------------------*/
  }

  /*----------LISTAR------------*/
  function obter() {
    $response = file_get_contents("https://localhost:44331/api/Gondola/GetGondola");
    $response = json_decode($response);
    foreach ($response as $item) {
      echo "<tr>";
      echo "<td>" . $item -> id . "</td>";
      echo "<td>" . $item -> nome . "</td>";
      echo "<td>" . $item -> codigo . "</td>";
      echo "<td style='display: flex;'> 
      <button class='btn edit' name='edit' value='" . $item -> id . "'>
        <span> Editar </span>
        <span style='margin-left: 3px;' class='fas fa-pen'></span>
      </button> 
      <button class='btn excluir' name='delete' value='" . $item -> id . "'>
        <span> Excluir </span>
        <span style='margin-left: 3px;' class='fas fa-close'></span>
      </button>
      </td>";
      echo "</tr>";
    }
  }
  /*------------------------------*/
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
    <div style="display: flex;">
      <div class="input" style="width: 30px;">
        <span>Id</span>
        <input type="number" name="id"></input>
      </div>
      <div class="input" style="width: 30px; margin-left: 150px;">
        <span>Nome</span>
        <input type="text" name="Nome"></input>
      </div>
      <div class="input" style="width: 30px; margin-left: 150px;">
        <span>Codigo</span>
        <input type="text" name="codigo"></input>
      </div>
    </div>
    <div class="buttons" onclick="location.href='http://localhost/cadastro_gondola/cadastro_gondola_form/cadastro_gondola_form.php';" style="display: flex;">
        <button class="btn add">
          <span> Nova gôndola </span>
          <span style="margin-left: 3px;" class="fas fa-plus"></span>
        </button>
        <button class="btn filter">
          <span> Filtrar </span>
          <span style="margin-left: 3px;" class="fas fa-search"></span>
        </button>
      </div>
      <form method="post">
      <table>
        <tr>
          <th>Id</th>
        <th>Nome</th>
        <th>Código</th>
        <th>Ações</th>
      </tr>
      <?php obter(); ?>
    </table>
  </form>
  </div>
</body>
</html>