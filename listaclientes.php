<?php
    // Incluir o arquivo de verificação de login
    include("check_login.php");

    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'mydb');
    if ($conn->connect_error) {
        die("Falha de conectar com o banco: " . $conn->connect_error);
    }

    // Consulta SQL para selecionar todos os clientes
    $sql_clientes = "SELECT id_cliente, nome, grupo FROM cliente";
    $result_clientes = $conn->query($sql_clientes);

    // Verificar se há erro na consulta
    if (!$result_clientes) {
        die("Erro ao consultar clientes: " . $conn->error);
    }

    // Fechar conexão com o banco
    $conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Lista de Clientes</title>
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
                    tdName = tr[i].getElementsByTagName("td")[0]; //Coluna de nome usuario
                    tdGroup = tr[i].getElementsByTagName("td")[1]; //Coluna de grupo do cliente
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
            
            <h2 class="titulo">Lista de Colaboradores</h2>
            <!-- Formulário de pesquisa-->
            <div class="textfield">
                <input type="text" id="tabela_pesquisa" onkeyup="filterTable()" placeholder="Pesquisar Cliente">
            </div>

            <table id="tabela_filtro" >
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Grupo</th>
                        <th>Verificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result_clientes->num_rows > 0) {
                            while ($row_cliente = $result_clientes->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row_cliente['nome'] . "</td>";
                                echo "<td>" . $row_cliente['grupo'] . "</td>";
                                echo "<td><a href='detalhes_clientes.php?id=" . $row_cliente['id_cliente'] . "'>Ver Detalhes</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum cliente encontrado.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="card-logins">
        <a href="cliente.php" class="a">Cadastrar Clientes</a>
        </div>

    </div>
    </body>
</html>