<?php
// Incluir o arquivo de verificação de login
include("check_login.php");

// Verificar se foi passado um ID válido via parâmetro GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de cliente inválido.";
    exit();
}

$id_cliente = $_GET['id'];

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'mydb');
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta SQL para obter informações do cliente
$sql_cliente = "SELECT id_cliente, nome FROM cliente WHERE id_cliente = $id_cliente";
$result_cliente = $conn->query($sql_cliente);

// Verificar se o cliente existe
if ($result_cliente->num_rows == 0) {
    echo "Cliente não encontrado.";
    exit();
}

$row_cliente = $result_cliente->fetch_assoc();
$nome_cliente = $row_cliente['nome'];

// Consulta SQL para obter produtos relacionados ao cliente na tabela produto_cliente
$sql_produtos_cliente = "SELECT pc.id_produto, p.nome AS nome_produto, pc.quantidade_itens, pc.numero_serie, pc.data_hora
                        FROM produto_cliente pc
                        INNER JOIN produto p ON pc.id_produto = p.id_produto
                        WHERE pc.id_cliente = $id_cliente";
$result_produtos_cliente = $conn->query($sql_produtos_cliente);

// Verificar se há erro na consulta
if (!$result_produtos_cliente) {
    die("Erro ao consultar produtos do cliente: " . $conn->error);
}

// Fechar a conexão com o banco
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detalhes do Cliente - <?php echo $nome_cliente; ?></title>
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
            <li><a href="listanota.php">Notas Fiscais</a></li>

            
            <li class="logout"><a href="logout.php" >Sair </a></li>
        </ul>
    </nav>

    <div class="direcionamento">
        <div class="card-tabela">
        
            <h2 class="titulo">Detalhes do Cliente - <?php echo $nome_cliente; ?></h2>
            <h3 class="subtitulo">Produtos Relacionados</h3>
            <table>
                <thead>
                    <tr>
                        
                        <th>Nome do Produto</th>
                        <th>Quantidade</th>
                        <th>Número de Série</th>
                        <th>Data e Hora</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_produtos_cliente->num_rows > 0) {
                        while ($row_produto_cliente = $result_produtos_cliente->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row_produto_cliente['nome_produto'] . "</td>";
                            echo "<td>" . $row_produto_cliente['quantidade_itens'] . "</td>";
                            echo "<td>" . $row_produto_cliente['numero_serie'] . "</td>";
                            echo "<td>" . $row_produto_cliente['data_hora'] . "</td>";
                            echo "<td><form method='post' action='devolver_estoque.php'>
                                <input type='hidden' name='id_produto' value='". $row_produto_cliente['id_produto'] ."'>
                                <input type='hidden' name='id_cliente' value='" . $id_cliente ."'>
                                <input type='hidden' name='numero_serie' value='" . $row_produto_cliente['numero_serie'] . "'>
                                <button type='submit' class='botao_devolver'>Devolver</button>
                                </form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhum produto encontrado para este cliente.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
