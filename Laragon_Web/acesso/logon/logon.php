<?php 
  /*---------URLs----------*/
    $url_back = "https://localhost:44331/api/";
    $controller = "Usuario/";
    $url_raiz = "http://localhost/acesso/";
    $url_login = "login/login.php";
  /*-----------------------*/

  /*-----CADASTRO-----*/
    if(array_key_exists('submit', $_POST)) {
      $url = $url_back . $controller . "CadastrarUsuario";
      $postData = array(
        'id' => 0,
        'nome' => $_POST['nome'],
        'sobrenome' => $_POST['sobrenome'],
        'email' => $_POST['email'],
        'senha' => $_POST['senha'],
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
  /*--------------------*/

  /*------REQUEST------*/
    if(array_key_exists('submit', $_POST)) {
      $context  = stream_context_create( $options );
      $result = file_get_contents( $url, false, $context );
      $response = json_decode( $result );
      if($response == "201" || $response == "200") {
        echo '<script>window.location.href = "' . $url_raiz . $url_login .'?msg_alert=success_register";</script>';
      } else {
        echo '<script>window.location.href = "' . $url_raiz . $url_login .'?msg_alert=error_register";</script>';
      }
    }
  /*-------------------*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./logon.scss">
</head> 
<body>
<form class="form" method="post">
    <p class="title">Cadastrar-se </p>
    <p class="message">Registre-se agora para obter acesso ao aplicativo. </p>
    <div class="flex">
        <label>
            <input name="nome" required="" placeholder="" type="text" class="input">
            <span>Nome</span>
        </label>

        <label>
            <input name="sobrenome" required="" placeholder="" type="text" class="input">
            <span>Sobrenome</span>
        </label>
    </div>  
            
    <label>
        <input name="email" required="" placeholder="" type="email" class="input">
        <span>Email</span>
    </label> 
        
    <label>
        <input name="senha" required="" placeholder="" type="password" class="input">
        <span>Senha</span>
    </label>
    <button class="submit" name="submit">Submit</button>
    <p class="signin">Already have an acount ? <a href="http://localhost">Signin</a> </p>
</form>
</body>
</html>
