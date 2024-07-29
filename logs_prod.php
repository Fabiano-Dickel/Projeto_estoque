<?php
    // Conexao com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'mydb');
    if ($conn->connect_error) {
        die("Falha na conexão com o banco" . $conn->connect_error);
    }

    // Obter filtros do formulário
    $produto = isset($_GET['produto']) ? $_GET['produto'] : '';
    $data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
    $data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

    // Construir a consulta sql com base nos filtros
    $sql = "SELECT m.*, p.nome FROM movimentacao m 
    JOIN produto p ON m.id_produto = p.id_produto
    WHERE 1=1";

    if(!empty($produto)) {
        $sql .= "AND m.id_produto = '$produto'";
    }

    if (!empty($data_inicio)) {
        $sql .= "AND m.data >= '$data_inicio'";
    }

    if (!empty($data_fim)) {
        $sql .= "AND m.data <= '$data_fim'";
    }

    $sql .= "ORDER BY m.data DESC";

    $result = $conn->query($sql);

    // Verificar se há resultados
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Produto</th><th>Tipo</th><th>Quantidade</th><th>Descrição</th><th>Usuário</th><th>Data</th><th>Número de Série</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_movimentacao'] . "</td>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>" . $row['tipo'] . "</td>";
            echo "<td>" . $row['quantidade'] . "</td>";
            echo "<td>" . $row['descricao'] . "</td>";
            echo "<td>" . $row['usuario'] . "</td>";
            echo "<td>" . $row['data'] . "</td>";
            echo "<td>" . $row['numero_serie'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhuma movimentação encontrada";
    }
    
    //Fechando a conexão com o banco
    $conn->close();
?>