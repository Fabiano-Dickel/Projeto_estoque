<?php
include("check_login.php");

// Verificar se os dados necessários foram passados via POST
if(!isset($_POST['id_produto']) || !isset($_POST['id_cliente'])) {
    echo "Dados inválidos.";
    exit();
}

$id_produto = $_POST['id_produto'];
$id_cliente = $_POST['id_cliente'];
$numero_serie = $_POST['numero_serie'] ?? ''; // Adiciona o número de série se estiver disponivel

error_log("ID Produto: $id_produto");
error_log("ID Cliente: $id_cliente");
error_log("Número de Série: $numero_serie");


// Verifique se os valores estão sendo recebidos corretamente
if (empty($id_produto) || empty($id_cliente)) {
    echo "Dados inválidos recebidos.";
    exit();
}

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'mydb');
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados. " . $conn->connect_error);
}

// Iniciar transação
$conn->begin_transaction();

try {
    // Obter a quantidade de itens a serem devolvidos
    $sql_quantidade = "SELECT quantidade_itens FROM produto_cliente WHERE id_produto = $id_produto AND id_cliente = $id_cliente";
    $result_quantidade = $conn->query($sql_quantidade);
    if ($result_quantidade->num_rows == 0) {
        throw new Exception("Produto ou cliente não encontrado.");
    }
    $row_quantidade = $result_quantidade->fetch_assoc();
    $quantidade_itens = $row_quantidade['quantidade_itens'];

    // Atualizar a quantidade do produto na tabela produto
    $sql_update_produto = "UPDATE produto SET quantidade = quantidade + $quantidade_itens WHERE id_produto = $id_produto";
    if (!$conn->query($sql_update_produto)) {
        throw new Exception("Erro ao atualizar a quantidade na tabela produto: " . $conn->error);
    }
   

    // Se houver um número de série, fazer a entrada do produto com o número de série
    if(!empty($numero_serie)) {
        $sql_serie = "INSERT INTO numeros_serie (id_produto, numero_serie, status) VALUES
                      ($id_produto, '$numero_serie', 'disponivel')";
        if (!$conn->query($sql_serie)) {
            throw new Exception("Erro ao inserir o número de série na tabela numeros_serie." . $conn->error);
        }
    }

    // Remover o produto do Cliente
    $sql_delete_produto_cliente = "DELETE FROM produto_cliente WHERE id_produto = $id_produto AND id_cliente = $id_cliente";
    if (!$conn->query($sql_delete_produto_cliente)) {
        throw new Exception("Erro ao remover o produto do cliente: " . $conn->error);
    }

    // Commit da transação
    $conn->commit();
    echo "Produto devolvido com sucesso.";
} catch (Exception $e) {
    // Rollback da transação em caso de erro
    $conn->rollback();
    echo $e->getMessage();
}

$conn->close();
?>