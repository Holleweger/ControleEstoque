<?php
  include "../../menu/menu.php";

  function obter() {
    $response = file_get_contents("https://localhost:44331/api/Gondola/GetGondola");
    $response = json_decode($response);
    foreach ($response as $item) {
      echo "<tr>";
      echo "<td>" . $item -> id . "</td>";
      echo "<td>" . $item -> nome . "</td>";
      echo "<td>" . $item -> codigo . "</td>";
      echo "<td> <button onclick='<?php obter(); ?>'> Editar </button> </td>";
      echo "</tr>";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./cadastro_gondola_list.scss">
  <title>Document</title>
</head>
<body>
  <form method="post">
  <h3>Cadastro de gôndola</h3>
  <div class="espacamento">
    <table>
      <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Código</th>
        <th>Ações</th>
      </tr>
      <?php obter(); ?>
    </table>
  </div>
  </form>
</body>
</html>