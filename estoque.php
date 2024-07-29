<?php
include("check_login.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Estoque</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css">
    <script>
        // Função para filtrar a tabela conforme o usuário digita
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("produto_pesquisa");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabela_produtos");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // Coluna do nome do produto
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = ""; // Mostrar a linha se corresponder à pesquisa
                    } else {
                        tr[i].style.display = "none"; // Ocultar a linha se não corresponder à pesquisa
                    }
                }
            }
        }
    </script>
</head>
<body>
    <input type="checkbox" id="chec">
    <label for="chec" id="label">
        <img src="menu.svg" alt="" class="img">
    </label>
    
    <nav>
        <ul>
            <li><a href="teste.php">Cadastro</a></li>
            <li><a href="movimentacao.php">Movimentações</a></li>
            <li><a href="#">Estoque</a></li>
            <li><a href="listaclientes.php">Clientes</a></li>
            <li><a href="listanota.php">Notas Fiscais</a></li>
            
            <li class="logout"><a href="logout.php">Sair</a></li>
        </ul>
    </nav>
    <div class="direcionamento">
        <div class="card-cliente">
        <h2 class="titulo">Itens em Estoque</h2>

        <!-- Formulário de pesquisa -->
        <div class="textfield">
            <input type="text" id="produto_pesquisa" onkeyup="filterTable()" placeholder="Pesquisar Produto">
        </div>

        <table id="tabela_produtos" class="">
            <thead>
                <tr>
                    <th>Nome do Produto</th>
                    
                    <th>Quantidade</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados
                $conn = new mysqli('localhost', 'root', '', 'mydb');

                // Verificação da conexão com o banco
                if ($conn->connect_error) {
                    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                }

                // Consulta SQL para selecionar o nome do produto, categoria e quantidade disponível de séries
                $sql = "SELECT * FROM produto WHERE quantidade > 0";

                $result = $conn->query($sql);

                // Verificação se há resultados
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['quantidade'] . "</td>";
                        echo "<td>" . $row['preco'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum produto encontrado.</td></tr>";
                }

                // Fechamento da conexão com o banco
                $conn->close();
                ?>
            </tbody>
        </table>
        </div>
    </div>
    <a href="log.php" class="link-movimentacao">
        <img src="Question.png">
    </a>
</body>
</html>
