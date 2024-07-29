<?php
include("check_login.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>usuario</title>
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
                <li><a href="#" >Movimentações</a></li>
                <li><a href="estoque.php" >Estoque</a></li>
                <li><a href="usuario.php">Cadastro de Usuário</a></li>
                <li class="logout"><a href="logout.php" >Sair </a></li>
            </ul>
        </nav>
        <div class="direcionamento">
            <div class="card-login">
                <h2 class="titulo">Cadastrar Usuário</h2>
                <form action="usuario_cad.php" method="POST" class="form">
                    <div class="textfield">
                      <label for="nome_usuario">Nome</label>
                      <input type="text" name="nome_usuario" id="nome_usuario" required>
                    </div><br>
                    
                    <div class="textfield">
                        <label for="senha_usuario">Senha</label>
                        <input type="password" name="senha_usuario" id="senha_usuario" required>
                    </div><br>
                    <button type="submit" class="glow-on-hover">Cadastrar Usuário</button>
                </form>
            </div>
        </div>
    </body>

</html>