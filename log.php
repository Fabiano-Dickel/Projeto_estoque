<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movimentações</title>
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
                <li><a href="movimentacao.php" >Movimentações</a></li>
                <li><a href="estoque.php" >Estoque</a></li>
                <li><a href="listaclientes.php">Clientes</a></li>
                
                <li><a href="estoque_abertos.php">Abertos</a></li>
            </ul>
        </nav>
    <div class="direcionamento">
    <div class="card-login">
    <div class="form">
        <h2 class="titulo">Filtrar Movimentações</h2>
        <form action="log.php" method="GET">
            <div class="textfield">
                <label for="produto">Produto:</label>
                <select name="produto" id="produto">
                    <option value="">Todos</option>
                    <?php
                    // Conectar ao banco de dados
                    $conn = new mysqli('localhost', 'root', '', 'mydb');
                    if ($conn->connect_error) {
                        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                    }

                    // Obter lista de produtos
                    $sql_produtos = "SELECT id_produto, nome FROM produto";
                    $result_produtos = $conn->query($sql_produtos);
                    if ($result_produtos->num_rows > 0) {
                        while ($row = $result_produtos->fetch_assoc()) {
                            echo "<option value='" . $row['id_produto'] . "'>" . $row['nome'] . "</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>
            </div>

            

            <div class="textfield">
                <label for="data_inicio">Data Início:</label>
                <input type="date" id="data_inicio" name="data_inicio">
            </div>

            <div class="textfield">
                <label for="data_fim">Data Fim:</label>
                <input type="date" id="data_fim" name="data_fim">
            </div>

            <button type="submit" class="glow-on-hover">Filtrar</button>
        </form>
    </div>
    </div>
    </div>
    <div class="card-cliente">
    <?php
    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'mydb');
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obter filtros do formulário
    $produto = isset($_GET['produto']) ? $_GET['produto'] : '';
    $data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
    $data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

    // Construir a consulta SQL com base nos filtros
    $sql = "SELECT m.id_movimentacao, p.nome AS produto_nome, m.tipo, m.quantidade, m.descricao, u.nome AS usuario_nome, m.data_hora, m.numero_serie 
    FROM movimentacao m
    JOIN produto p ON m.id_produto = p.id_produto
    JOIN usuario u ON m.usuario = u.id_usuario
    WHERE 1=1";

    if (!empty($produto)) {
        $sql .= " AND m.id_produto = '" . $conn->real_escape_string($produto) . "'";
    }

    if (!empty($data_inicio)) {
        $sql .= " AND m.data_hora >= '" . $conn->real_escape_string($data_inicio) . "'";
    }
    if (!empty($data_fim)) {
        $sql .= " AND m.data_hora <= '" . $conn->real_escape_string($data_fim) . "'";
    }

    $sql .= " ORDER BY m.data_hora DESC";

    $result = $conn->query($sql);

    // Verificar se há resultados
    if ($result === false) {
        echo "Erro na consulta SQL: " . $conn->error;
    } else {
        // Verificar se há resultados
        if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Produto</th><th>Tipo</th><th>Quantidade</th><th>Descrição</th><th>Usuário</th><th>Data</th><th>Número de Série</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_movimentacao'] . "</td>";
            echo "<td>" . $row['produto_nome'] . "</td>";
            echo "<td>" . $row['tipo'] . "</td>";
            echo "<td>" . $row['quantidade'] . "</td>";
            echo "<td>" . $row['descricao'] . "</td>";
            echo "<td>" . $row['usuario_nome'] . "</td>";
            echo "<td>" . $row['data_hora'] . "</td>";
            echo "<td>" . $row['numero_serie'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhuma movimentação encontrada.";
    }
    }
    // Fechando a conexão com o banco
    $conn->close();
    ?>
    </div>
    
</body>
</html>
