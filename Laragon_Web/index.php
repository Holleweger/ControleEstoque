<?php
include './menu/menu.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.scss">
</head> 
<body>
<form>

<input type="radio" name="fancy" autofocus value="clubs" id="clubs" />
<input type="radio" name="fancy" value="hearts" id="hearts" />
<input type="radio" name="fancy" value="spades" id="spades" />
<input type="radio" name="fancy" value="diamonds" id="diamonds" />			
<label for="clubs">Estoque</label><label for="hearts">Produtos</label><label for="spades">Configurações</label><label for="diamonds">Contato</label>

<div class="keys">Use left and right keys to navigate</div>
</form>
</body>
</html>
