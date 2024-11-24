<?php
  include "../../menu/menu.php";
    /*-----------MENSAGENS----------*/
    if (!array_key_exists('msg_alert', $_GET)) {
      $_GET['sucess'] = "ok";
    }
    else {
      if ($_GET['msg_alert'] == "success_form"){
        $_GET['sucess'] = "true";
        $_GET['msg'] = "Gaveta inserida/adicionada com sucesso!";
      }
      else
      if ($_GET['msg_alert'] == "error_form") {
        $_GET['sucess'] = "false";
        $_GET['msg'] = "Erro ao inserir/cadastrar gaveta!";
      }
      else
      if ($_GET['msg_alert'] == "success_excluir") {
        $_GET['sucess'] = "true";
        $_GET['msg'] = "Gaveta excluída com sucesso!";
      }
      else
      if ($_GET['msg_alert'] == "error_excluir") {
        $_GET['sucess'] = "false";
        $_GET['msg'] = "Erro ao excluir gaveta!";
      }
    }
    /*------------------------------*/

    /*-------------URLs-------------*/
    $url_back = "https://localhost:44331/api/";
    $controller = "Gaveta/";
    $url_raiz = "http://localhost/cadastro_gaveta/";
    $url_gaveta_list = "cadastro_gaveta_list/cadastro_gaveta_list.php";
    $url_gaveta_form = "cadastro_gaveta_form/cadastro_gaveta_form.php";
  /*------------------------------*/

    /*-----------NOVO------------*/
    if (array_key_exists('novo', $_POST)) {
      echo '<script>window.location.href ="' . $url_raiz . $url_gaveta_form . '";</script>';
    }
    /*--------------------------*/

    /*-----------FILTRAR------------*/
    if ( array_key_exists('filtrar', $_POST)) {
      $_POST['id'] = array_key_exists('id', $_POST) ? $_POST['id'] : 0;
      $_POST['nome'] = array_key_exists('nome', $_POST) ? $_POST['nome'] : null;
      $_POST['codigo'] = array_key_exists('codigo', $_POST) ? $_POST['codigo'] : null;
        $url = $url_back . $controller . "FiltrarGaveta";
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
        $response = file_get_contents("https://localhost:44331/api/Gaveta/GetGaveta");
        $_GET['response'] = json_decode($response);
      }
    /*------------------------------*/

  if ($_POST) {
    /*-------------EDIT-------------*/
    if ( array_key_exists('edit', $_POST) && $_POST['edit'] != "") {
      echo '<script>window.location.href ="' . $url_raiz . $url_gaveta_form . '?id=' . $_POST['edit'] .'";</script>';
    }
    /*------------------------------*/
  
    /*-----------EXCLUIR------------*/
    if ( array_key_exists('delete', $_POST) && $_POST['delete'] != "") {
      $url = "https://localhost:44331/api/Gaveta/DeleteGaveta/" . $_POST['delete'];
      $options = array(
        'http' => array(
          'method'  => 'DELETE'
          )
      );
      $context  = stream_context_create( $options );
      $result = file_get_contents( $url, false, $context );
      $response = json_decode( $result );
      if($response == "201" || $response == "200") {
        echo '<script>window.location.href = "' . $url_raiz . $url_gaveta_list .'?msg_alert=success_excluir";</script>';
      } else {
        echo '<script>window.location.href = "' . $url_raiz . $url_gaveta_list .'?msg_alert=error_excluir";</script>';
      }
    }
    /*------------------------------*/
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="./cadastro_gaveta_list.scss">
  <title>Document</title>
</head>
<body>
  <h3>Cadastro de gaveta</h3>
  <div class="espacamento">
    <form method="post">
    <div style="display: flex;">
      <div class="input" style="width: 30px;">
        <input class="input" name="id" placeholder="Id..." type="number">
      </div>
      <div class="input" style="width: 30px; margin-left: 150px;">
        <input class="input" name="nome" placeholder="Nome..." type="text">
      </div>
      <div class="input" style="width: 30px; margin-left: 150px;">
        <input class="input" name="codigo" placeholder="Codigo..." type="text">
      </div>
    </div>
    <div class="buttons" style="display: flex;">
        <button class="button add" name="novo">
          <span> Nova gaveta </span>
          <span id="bold" class="bx bx-plus"></span>
        </button>
        <button class="button filter" name="filtrar">
          <span> Filtrar </span>
          <span id="bold" class="bx bx-search-alt-2"></span>
        </button>
      </div>
      <table>
        <tr>
          <th>Id</th>
          <th>Nome</th>
          <th>Código</th>
          <th>Gôndola</th>
          <th>Ações</th>
      </tr>
      <?php foreach ($_GET['response'] as $item): ?>
        <tr>
          <td style="width: 20%;"><?= $item -> id ?></td>
          <td style="width: 40%;"><?= $item -> nome ?></td>
          <td style="width: 20%;"><?= $item -> codigo ?></td>
          <td style="width: 20%;"><?= $item -> gondola -> nome ?></td>
          <td style='display: flex;'>
          <button style="margin-top: 5px;" class='button edit' name='edit' value='<?= $item -> id ?>'>
          <span> Editar </span>
          <span id="bold" class='bx bx-edit-alt'></span>
          </button> 
          <button style="margin-top: 5px;" class='button delete' name='delete' value='<?= $item -> id ?>'>
            <span> Excluir </span>
            <span id="bold" class='bx bx-trash'></span>
          </button>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if ($_GET['sucess'] == "true") : ?>
        <div class="success">
            <div class="success__icon">
              <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" d="m12 1c-6.075 0-11 4.925-11 11s4.925 11 11 11 11-4.925 11-11-4.925-11-11-11zm4.768 9.14c.0878-.1004.1546-.21726.1966-.34383.0419-.12657.0581-.26026.0477-.39319-.0105-.13293-.0475-.26242-.1087-.38085-.0613-.11844-.1456-.22342-.2481-.30879-.1024-.08536-.2209-.14938-.3484-.18828s-.2616-.0519-.3942-.03823c-.1327.01366-.2612.05372-.3782.1178-.1169.06409-.2198.15091-.3027.25537l-4.3 5.159-2.225-2.226c-.1886-.1822-.4412-.283-.7034-.2807s-.51301.1075-.69842.2929-.29058.4362-.29285.6984c-.00228.2622.09851.5148.28067.7034l3 3c.0983.0982.2159.1748.3454.2251.1295.0502.2681.0729.4069.0665.1387-.0063.2747-.0414.3991-.1032.1244-.0617.2347-.1487.3236-.2554z" fill="#393a37" fill-rule="evenodd"></path>
              </svg>
            </div>
            <?php echo "<div class='success__title'>" . $_GET['msg'] . "</div>" ?>
            <div class="success__close">
              <a href="http://localhost/cadastro_gaveta/cadastro_gaveta_list/cadastro_gaveta_list.php?sucess=ok">
                <svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                  <path d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z" fill="#393a37"></path>
                </svg>
              </a>
            </div>
        </div>
      <?php endif; ?>
      <?php if ($_GET['sucess'] == "false") : ?>
        <div class="error">
          <div class="error__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none"><path fill="#393a37" d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z"></path></svg>
          </div>
          <?php echo "<div class='error__title'>" . $_GET['msg'] . "</div>" ?>
          <div class="error__close">
            <a href="http://localhost/cadastro_gaveta/cadastro_gaveta_list/cadastro_gaveta_list.php?sucess=ok">
              <svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                <path d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z" fill="#393a37"></path>
              </svg>
            </a>
          </div>
        </div>
      <?php endif; ?>
    </table>
  </form>
  </div>
</body>
</html>