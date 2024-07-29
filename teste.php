<?php
include("check_login.php");
?>
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Conectando ao banco
$conn = new mysqli("localhost", "root", "", "mydb");

//Verificando conexão
if($conn->connect_error){
    die("Falha na conexão com o banco de dados" . $conn->connect_error);
}
// Consulta SQL para selecionar todos os usuários da tabela de usuários
$sql = "SELECT nome, id_usuario FROM usuario";
$result = $conn->query($sql);

// Verifique se há erros na consulta
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}

// Fechando a conexão com o banco
$conn->close();

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <input type="checkbox" id="chec">
    <label for="chec" id="label">
        <img src="menu.svg" alt="" class="img">
    </label>
    
        <nav>
            <ul>
                <li><a href="#">Cadastro</a></li>
                <li><a href="movimentacao.php" >Movimentações</a></li>
                <li><a href="estoque.php" >Estoque</a></li>
                <li><a href="listaclientes.php">Clientes</a></li>
                <li><a href="listanota.php">Notas Fiscais</a></li>

                
                <li class="logout"><a href="logout.php" >Sair </a></li>
            </ul>
        </nav>
   <div class="direcionamento">
   
    <div class="card-login">

        <form method="POST" action="cadastro_prod.php">
        <h2 class="titulo">Cadastro de Produto</h2><br> 
            <div class="textfield">
              <br>  <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" required placeholder="Insira o nome do produto">
            </div><br>
          
            <div class="textfield">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" cols="50" placeholder="Descreva o produto"></textarea>
            </div><br>
            
            <!--Campo oculto para enviar o id do usuario-->
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $row['id_usuario']; ?>">

            <div class="textfield">
                <label for="usuario">Usuário:</label>
                <select id="usuario" name="usuario"required>
                    <?php
                    // Loop através dos resultados da consulta e imprima as opções de seleção
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['nome'] . "'>" . $row['nome'] . "</option>";
                    }
                    ?>
                </select>
             </div><br>
             <button class="glow-on-hover" type="submit">Cadastrar</button>
        </form>
        </div>
    
    </div>
    
    
    
</body>
</html>