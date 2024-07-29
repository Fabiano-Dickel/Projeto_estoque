<?php
session_start();

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "mydb");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Obter dados do formulário
$nome = $_POST['nome'];
$senha = $_POST['senha'];

// Consulta SQL para verificar as credenciais
$sql = "SELECT * FROM login WHERE nome = '$nome' AND senha = '$senha'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login bem-sucedido
    $_SESSION['nome'] = $nome;
   header("Location:teste.php");
} else {
    // Login falhou
    echo "É gambá ou magangá?";
}
?>