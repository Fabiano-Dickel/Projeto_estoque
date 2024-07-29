
<?php
include("movimentacao.php");

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'mydb');
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Obter dados do formulário
$nome_produto = $_POST['nome_produto'];
$quantidade = $_POST['quantidade'];
$tipo_movimentacao = $_POST['tipo_movimentacao'];
$id_usuario = $_POST['id_usuario'];
$descricao = isset($_POST['descricao']) ? $_POST['descricao'] : ''; //opcional
$usuario = $_POST['usuario'];
$numero_serie = isset($_POST['numero_serie']) ? $_POST['numero_serie'] : '';
$numero_serie_select = isset($_POST['numero_serie_select']) ? $_POST['numero_serie_select'] : '';
$id_cliente = isset($_POST['cliente']) ? $_POST['cliente'] : null; //id do cliente selecionado
$id_fiscal = isset($_POST['notafiscal']) ? $_POST['notafiscal'] : '';
$preco = isset($_POST['preco']) ? $_POST['preco'] : '';

// Verificar se a quantidade é maior que zero
if ($quantidade <= 0) {
    echo "A quantidade deve ser maior que zero.";
    exit();
}

// Consulta SQL para obter o ID do produto
$sql_produto = "SELECT id_produto, quantidade FROM produto WHERE nome = '$nome_produto'";
$result_produto = $conn->query($sql_produto);
if ($result_produto->num_rows > 0) {
    $row_produto = $result_produto->fetch_assoc();
    $id_produto = $row_produto['id_produto'];
    $quantidade_atual = $row_produto['quantidade'];

    

    // Atualizar a quantidade do produto com base no tipo de movimentação
    if ($tipo_movimentacao == 'entrada') {
        $nova_quantidade = $quantidade_atual + $quantidade;
       

        // Atualizar a quantidade do produto na tabela produto
        $sql_update_produto = "UPDATE produto SET quantidade = $nova_quantidade, preco = '$preco' WHERE id_produto = $id_produto";
        if ($conn->query($sql_update_produto) === TRUE) {
                
            
                // Inserir o registro de movimentação na tabela movimentacao
                $sql_insert_movimentacao = "INSERT INTO movimentacao (id_produto, tipo, quantidade, descricao, usuario, numero_serie, preco) VALUES 
                ($id_produto, '$tipo_movimentacao', $quantidade, '$descricao', '$usuario',
                '$numero_serie', '$preco')";
                if ($conn->query($sql_insert_movimentacao) === TRUE) {
                    echo "Movimentação registrada com sucesso.<br>";

                    // Se um número de série for fornecido, insira na tabela numeros_serie
                    if (!empty($numero_serie)) {
                        $sql_serie = "INSERT INTO numeros_serie (id_produto, numero_serie, status) VALUES ($id_produto, '$numero_serie', 'disponivel')";
                        if ($conn->query($sql_serie) === TRUE) {
                            echo "Número de série inserido com sucesso!<br>";
                        } else {
                            echo "Erro ao inserir número de série: " . $conn->error;
                        }
                    }
                    // Se alguma nota de fiscal for fornecido, insira na tabela nota_produto
                    if ($id_fiscal !== 'nenhum' && $id_fiscal !== null) {
                        $sql_insert_nota_produto = "INSERT INTO nota_produto (id_produto, quantidade, id_fiscal, numero_serie) VALUES 
                        ($id_produto, $quantidade, $id_fiscal, '$numero_serie')";
                        if($conn->query($sql_insert_nota_produto) === TRUE) {
                            echo "Produto registrado para para a nota com sucesso.<br>";
                        } else {
                            echo "Erro ao registrar produto para o cliente: " . $conn->error;
                        }
                    }
                } else {
                    echo "Erro ao registrar a movimentação: " . $conn->error;
                }
            
        } else {
            echo "Erro ao atualizar a quantidade: " . $conn->error;
        }
    } elseif ($tipo_movimentacao == 'saida') {
        // Verificar se há quantidade suficiente em estoque para a saída
        if ($quantidade_atual < $quantidade) {
            echo "Quantidade insuficiente em estoque.<br>";
            exit();
        }
        $nova_quantidade = $quantidade_atual - $quantidade;

        // Atualizar a quantidade do produto na tabela produto
        $sql_update_produto = "UPDATE produto SET quantidade = $nova_quantidade WHERE id_produto = $id_produto";
        if ($conn->query($sql_update_produto) === TRUE) {
            
                // Inserir o registro de movimentação na tabela movimentacao
                $sql_insert_movimentacao = "INSERT INTO movimentacao (id_produto, tipo, quantidade, descricao, usuario, numero_serie) VALUES 
                ($id_produto, '$tipo_movimentacao', $quantidade, '$descricao', '$usuario', '$numero_serie_select')";
                if ($conn->query($sql_insert_movimentacao) === TRUE) {
                    echo "Movimentação registrada com sucesso.<br>";

                    // Atualizar o status do número de série para 'indisponivel'
                    if (!empty($numero_serie_select)) {
                        $sql_serie_saida = "UPDATE numeros_serie SET status = 'baixado' WHERE id_produto = $id_produto AND numero_serie = '$numero_serie_select'";
                        if ($conn->query($sql_serie_saida) === TRUE) {
                            echo "Número de série atualizado para indisponível.<br>";
                        } else {
                            echo "Erro ao atualizar o status do número de série: " . $conn->error;
                        }
                    }

                    // Inserir na tabela produto_cliente apenas se o cliente não for 'NENHUM'
                    if ($id_cliente !== 'nenhum' && $id_cliente !== null) {
                        $sql_insert_produto_cliente = "INSERT INTO produto_cliente (id_produto, id_cliente, quantidade_itens, numero_serie) VALUES 
                        ($id_produto, $id_cliente, $quantidade, '$numero_serie_select') ON DUPLICATE KEY UPDATE quantidade_itens = quantidade_itens + $quantidade";
                        if($conn->query($sql_insert_produto_cliente) === TRUE) {
                            echo "Produto registrado para o cliente com sucesso.<br>";
                        } else {
                            echo "Erro ao registrar produto para o cliente: " . $conn->error;
                        }
                    }

                } else {
                    echo "Erro ao registrar a movimentação: " . $conn->error;
                }
            
            
        } else {
            echo "Erro ao atualizar a quantidade: " . $conn->error;
        }
    }
} else {
    echo "Item $nome_produto não encontrado.";
}

// Fechando a conexão com o banco
$conn->close();
?>
