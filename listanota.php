<?php
    // Incluir o arquivo de verificação de login
    include("check_login.php");

    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'mydb');
    if ($conn->connect_error) {
        die("Falha de conectar com o banco: " . $conn->connect_error);
    }

    // Consulta SQL para selecionar todos os clientes
    $sql_nota = "SELECT id_fiscal, nota, fornecedor FROM nota_fiscal";
    $result_nota = $conn->query($sql_nota);

    // Verificar se há erro na consulta
    if (!$result_nota) {
        die("Erro ao consultar notas: " . $conn->error);
    }

    // Fechar conexão com o banco
    $conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Lista de Notas</title>
        <link rel="stylesheet" href="style.css">
        <script>
            // Função para filtrar a tabela conforme o usuário digita
            function filterTable() {
                var input, filter, table, tr, tdName, tdGroup, i, txtValueName, txtValueGroup;
                input = document.getElementById("tabela_pesquisa");
                filter = input.value.toUpperCase();
                table =document.getElementById("tabela_filtro");
                tr = table.getElementsByTagName("tr");

                for (i = 1; i < tr.length; i++) { // COmeçar de 1 para pular a linha do cabeçalho
                    tdName = tr[i].getElementsByTagName("td")[0]; //Coluna da nota
                    tdGroup = tr[i].getElementsByTagName("td")[1]; //Coluna do fornecedor
                    if (tdName || tdGroup) {
                        txtValueName = tdName.textContent || tdName.innerText;
                        txtValueGroup = tdGroup.textContent || tdGroup.innerText;
                        if (txtValueName.toUpperCase().indexOf(filter) > -1 || txtValueGroup.toUpperCase().indexOf(filter) > -1) {
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
            <li><a href="movimentacao.php" >Movimentações</a></li>
            <li><a href="estoque.php" >Estoque</a></li>
            <li><a href="listaclientes.php">Clientes</a></li>
            <li><a href="listanota.php">Notas Fiscais</a></li>

            
            <li class="logout"><a href="logout.php" >Sair </a></li>
        </ul>
    </nav>
    <div class="direcionamento">
        <div class="card-cliente">
            
            <h2 class="titulo">Notas Fiscais</h2>
            <!-- Formulário de pesquisa-->
            <div class="textfield">
                <input type="text" id="tabela_pesquisa" onkeyup="filterTable()" placeholder="Pesquisar Cliente">
            </div>

            <table id="tabela_filtro" >
                <thead>
                    <tr>
                        <th>Nota</th>
                        <th>Fornecedor</th>
                        <th>Verificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result_nota->num_rows > 0) {
                            while ($row_cliente = $result_nota->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row_cliente['nota'] . "</td>";
                                echo "<td>" . $row_cliente['fornecedor'] . "</td>";
                                echo "<td><a href='detalhes_notas.php?id=" . $row_cliente['id_fiscal'] . "'>Ver Detalhes</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhuma nota encontrada.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="card-logins">
        <a href="entrada_nota.php" class="a">Cadastrar Nota</a>
        </div>

    </div>
    </body>
</html>