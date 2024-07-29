<?php
include("check_login.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Entrada Nota</title>
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
    <input type="checkbox" id="chec">
    <label for="chec" id="label">
        <img src="menu.svg" alt="" class="img">
    </label>
    
    <nav>
        <ul>
            <li><a href="teste.php">Cadastro</a></li>
            <li><a href="movimentacao.php">Movimentações</a></li>
            <li><a href="estoque.php">Estoque</a></li>
            <li><a href="listaclientes.php">Clientes</a></li>
            <li><a href="listanota.php">Notas Fiscais</a></li>

            <li class="logout"><a href="logout.php">Sair</a></li>
        </ul>
    </nav>
    <div class="direcionamento">
        <div class="card-login">
           <h2 class="titulo">Cadastrar Nota</h2>
           <form method="POST" action="nota_prod.php">
            <div class="textfield">
                <label for="nota">Número:</label>
                <input type="text" name="nota" id="nota">
            </div><br>
            <div class="textfield">
                <label for="fornecedor">Fornecedor:</label>
                <input type="text" name="fornecedor" id="fornecedor">
                
            </div><br>
            
            <button type="submit" class="glow-on-hover">Cadastrar</button>
           </form>
        </div>
    </div>
    </body>
</html>