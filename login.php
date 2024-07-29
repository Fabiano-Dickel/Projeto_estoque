
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
      <div class="main-login">
         <div class="left-login">
            <h1>Faça seu login</h1>
            <img src="pagina.svg" class="left-login-image" alt="pagina">
            </h1>
         </div>
         <div class="right-login">
            <div class="card-login">
                <h1>LOGIN</h1>
                <form action="login_proccess.php" method="POST" class="form">
                <div class="textfield">
                    <label for="nome">Usuário:</label><br>
                    <input type="text" id="nome" name="nome" placeholder="Insira seu Usuário"><br>
                </div>
                <div class="textfield">
                    <label for="senha">Senha:</label><br>
                    <input type="password" id="senha" name="senha" placeholder="Insira sua senha">
                </div><br>
                
                
                 <button class="btn-login">Login</button>
                 
                
            </form>
            </div>
            </div>
        </div>
    </body>
</html>
