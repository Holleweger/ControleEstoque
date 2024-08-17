<?php
  function get_request() {
    echo "Hello World";
  }

  $response = file_get_contents("https://localhost:44331/api/Gondola/GetGondola");

  $response = json_decode($response);

  foreach ($response as $item) {
    echo $item -> nome . "<br>";
  }

  //phpinfo()
?>