<?php
include("check_login.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Cliente</title>
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
           <h2 class="titulo">Clientes</h2>
           <form method="POST" action="cliente_prod.php">
            <div class="textfield">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome">
            </div><br>
            <div class="textfield">
                <label for="grupo">Grupo:</label>
                <select name="grupo" id="grupo">
                    <option value="smartbr">SmartBr</option>
                    <option value="evocont">Evocont</option>
                    <option value="arktus">Arktus</option>
                    <option value="isp">ISP</option>
                    <option value="vitaverse">Vitaverse</option>
                    <option value="shopvita">Shopvita</option>
                    <option value="dsz">DSZ</option>
                    <option value="focus">Focus</option>
                </select>
            </div><br>
            <div class="textfield">
                <label for="email">E-Mail:</label>
                <input type="text" name="email" id="email">
            </div><br>
            <button type="submit" class="glow-on-hover">Cadastrar</button>
           </form>
        </div>
    </div>
    </body>
</html>