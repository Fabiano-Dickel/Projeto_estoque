<?php
// Conectar ao banco de dados
$conexao = new mysqli("localhost", "root", "", "mydb");

// Verificar conexão
if ($conexao->connect_error) {
    die("Erro conexão: " . $conexao->connect_error);
}

// Recuperar o ID do produto do POST
$id_produto = isset($_POST['id_produto']) ? $_POST['id_produto'] : '';

// Preparar a consulta para buscar números de série disponíveis
$sql = "SELECT numero_siere FROM numeros_serie WHERE id_produto = ? AND status = 'disponivel'";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_produto);
$stmt->execute();
$stmt->bind_result($numero_serie);

$options = "";
while ($stmt->fetch()) {
    $options .= "<option value='$numero_serie'>$numero_serie</option>";
}

$stmt->close();
$conexao->close();

echo $options;
?>