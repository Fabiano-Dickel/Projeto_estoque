<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'mydb');
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$nome_produto = $_GET['nome_produto'];

// Obter o ID do produto
$sql_produto = "SELECT id_produto FROM produto WHERE nome = ?";
$stmt_produto = $conn->prepare($sql_produto);
$stmt_produto->bind_param("s", $nome_produto);
$stmt_produto->execute();
$result_produto = $stmt_produto->get_result();

if ($result_produto->num_rows > 0) {
    $row_produto = $result_produto->fetch_assoc();
    $id_produto = $row_produto['id_produto'];

    // Obter números de série disponíveis filtrando por produto e categoria
    $sql_serie = "SELECT numero_serie FROM numeros_serie WHERE id_produto = ? AND status = 'disponivel'";
    $stmt_serie = $conn->prepare($sql_serie);
    $stmt_serie->bind_param("i", $id_produto);
    $stmt_serie->execute();
    $result_serie = $stmt_serie->get_result();
    
    $numeros_serie = [];
    while ($row_serie = $result_serie->fetch_assoc()) {
        $numeros_serie[] = $row_serie['numero_serie'];
    }

    echo json_encode($numeros_serie);
} else {
    echo json_encode([]);
}

$stmt_produto->close();
$stmt_serie->close();
$conn->close();
?>
