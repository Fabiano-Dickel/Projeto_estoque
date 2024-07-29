<?php
// Incluir o arquivo de verificação de login
include("check_login.php");

// Verificar se foi passado um ID válido via parâmetro GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de cliente inválido.";
    exit();
}

$id_fiscal = $_GET['id'];

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'mydb');
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta SQL para obter informações do cliente
$sql_nota = "SELECT id_fiscal, nota FROM nota_fiscal WHERE id_fiscal = $id_fiscal";
$result_nota = $conn->query($sql_nota);

// Verificar se o cliente existe
if ($result_nota->num_rows == 0) {
    echo "Nota não encontrada.";
    exit();
}

$row_nota = $result_nota->fetch_assoc();
$nome_nota = $row_nota['nota'];

// Consulta SQL para obter produtos relacionados ao cliente na tabela produto_cliente
$sql_nota_produto = "SELECT np.id_produto, p.nome AS nome_produto, np.quantidade, np.numero_serie, np.data_hora
                        FROM nota_produto np
                        INNER JOIN produto p ON np.id_produto = p.id_produto
                        WHERE np.id_fiscal = $id_fiscal";
$result_nota_produto = $conn->query($sql_nota_produto);

// Verificar se há erro na consulta
if (!$result_nota_produto) {
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
    <title>Detalhes da Nota - <?php echo $nome_nota; ?></title>
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
        
            <h2 class="titulo">Detalhes da Nota - <?php echo $nome_nota; ?></h2>
            <h3 class="subtitulo">Produtos Relacionados</h3>
            <table>
                <thead>
                    <tr>
                        
                        <th>Nome do Produto</th>
                        <th>Quantidade</th>
                        <th>Número de Série</th>
                        <th>Data e Hora</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_nota_produto->num_rows > 0) {
                        while ($row_nota_produto = $result_nota_produto->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row_nota_produto['nome_produto'] . "</td>";
                            echo "<td>" . $row_nota_produto['quantidade'] . "</td>";
                            echo "<td>" . $row_nota_produto['numero_serie'] . "</td>";
                            echo "<td>" . $row_nota_produto['data_hora'] . "</td>";
                            
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
