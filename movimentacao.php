
<?php
include("check_login.php");
?>
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conectando ao banco
$conn = new mysqli('localhost', 'root', '', 'mydb');

// Verificando conexão
if($conn->connect_error){
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta SQL para selecionar todos os usuários da tabela de usuários
$sql = "SELECT id_usuario, nome FROM usuario";
$result = $conn->query($sql);

// Verifique se há erros na consulta
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}

// Fechando a conexão com o banco
$conn->close();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Movimentações</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
   
    <div class="card-login">
        <h2 class="titulo">Movimentação de Estoque</h2>
        
        <form method="POST" action="movimentacao_prod.php" >
        <div class="textfield">
    <label for="nome_produto">Produto:</label>
    <input type="text" id="produto_pesquisas" placeholder="Pesquisa">
    <select id="nome_produto" name="nome_produto" required>
        <?php
            // Conexão com o banco de dados
            $conn = new mysqli('localhost', 'root', '', 'mydb');

            // Verificando conexão
            if($conn->connect_error){
                die("Falha na conexão com o banco de dados:" . $conn->connect_error);
            }

            // Consulta SQL para selecionar todos os produtos
            $sql_produtos = "SELECT nome FROM produto ORDER BY nome ASC";
            $result_produtos = $conn->query($sql_produtos);

            // Verificar se há erros na consulta
            if ($result_produtos) {
                // Loop através dos resultados da consulta e imprima as opções de seleção
                while ($row_produto = $result_produtos->fetch_assoc()){
                    echo "<option value='" . $row_produto['nome'] . "'>" . $row_produto['nome'] . "</option>";
                }
            } else {
                echo "Erro na consulta: " . $conn->error;
            }

            // Fechando a conexão com o banco
            $conn->close();
        ?>
    </select>
</div><br>
<script>
    // Função para filtrar as opções do select conforme o usuário digita
    function filterSelect() {
        var input, filter, select, options, i, txtValue;
        input = document.getElementById("produto_pesquisas");
        filter = input.value.toUpperCase();
        select = document.getElementById("nome_produto");
        options = select.getElementsByTagName("option");

        for (i = 0; i < options.length; i++) {
            txtValue = options[i].textContent || options[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                options[i].style.display = ""; //Mostrar a opçao se corresponder à poesuisa
            } else {
                options[i].style.display = "none"; // Ocultar a opção se não corresponder
            }
        }
    }

    // Adicionar evento de entrada ao campo de pesquisa
    document.getElementById("produto_pesquisas").addEventListener("input", filterSelect); 
</script>

            
           
            
            <div id="entrada_serie" class="textfield">
                <label for="numero_serie">Número de Série (Entrada):</label>
                <input type="text" name="numero_serie" id="numero_serie" placeholder="Insira o Número de Série">
            </div>

            <div id="saida_serie" style="display:none;" class="textfield">
                <label for="numero_serie_select">Número de Série (Saída):</label>
                <select name="numero_serie_select" id="numero_serie_select">
                <!-- Este campo será preenchido com os números de série disponíveis -->
                </select>
            </div> <br>    

            <div class="textfield">
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" value="0" required>
            </div><br>

            <div class="textfield">
                <label for="tipo_movimentacao">Tipo de Movimentação:</label>
                <select name="tipo_movimentacao" id="tipo_movimentacao" required>
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                </select>
            </div>
            <div id="cliente_select" style="display: none;" class="textfield">
                <label for="cliente">Cliente:</label>
                <select name="cliente" id="cliente">
                    <option value="nenhum">NENHUM</option>
                    <?php
                        // Conexão com o banco de dados
                        $conn = new mysqli('localhost', 'root', '', 'mydb');
                        if ($conn->connect_error) {
                            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                        }

                        // Consulta para obter todos os clientes
                        $sql_clientes = "SELECT id_cliente, nome FROM cliente";
                        $result_clientes = $conn->query($sql_clientes);
                        if ($result_clientes->num_rows > 0) {
                            while ($row_cliente = $result_clientes->fetch_assoc()) {
                                echo "<option value='" . $row_cliente['id_cliente'] . "'>" . $row_cliente['nome'] . "</option>";
                            }
                        } else {
                            echo "<option value = ''>Nenhum cliente encontrado</option>";
                        }
                        $conn->close();
                    ?>
                </select>
            </div><br>

            <div class="textfield">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" cols="50" placeholder="Insira detalhes da movimentação"></textarea>
            </div><br>
            
            <div id="notafiscal_select" class="textfield">
                <label for="notafiscal">Nota Fiscal:</label>
                <select name="notafiscal" id="notafiscal">
                    <option value="nenhum">NENHUM</option>
                    <?php
                        // Conexão com o banco de dados
                        $conn = new mysqli('localhost', 'root', '', 'mydb');
                        if ($conn->connect_error) {
                            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                        }

                        // Consulta para obter todos os clientes
                        $sql_nota = "SELECT id_fiscal, nota FROM nota_fiscal ORDER BY id_fiscal DESC";
                        $result_nota = $conn->query($sql_nota);
                        if ($result_nota->num_rows > 0) {
                            while ($row_nota = $result_nota->fetch_assoc()) {
                                echo "<option value='" . $row_nota['id_fiscal'] . "'>" . $row_nota['nota'] . "</option>";
                            }
                        } else {
                            echo "<option value = ''>Nenhuma nota encontrada</option>";
                        }
                        $conn->close();
                    ?>
                </select>
            </div><br>

            <!-- Campo oculto para enviar o id do usuario -->
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $row['id_usuario']; ?>">

            <div class="textfield">
                <label for="usuario">Usuário:</label>
                <select id="usuario" name="usuario" required>
                    <?php
                    // Loop através dos resultados da consulta e imprima as opções de seleção
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_usuario'] . "'>" . $row['nome'] . "</option>";
                    }
                    ?>
                </select>
            </div><br>
            <button type="submit" class="glow-on-hover">Registrar Movimentação</button>
        </form>
        <script>
            
            //Mostrar Input ou select de preço conforme movimentacao
            document.getElementById('tipo_movimentacao').addEventListener('change', function () {
                var tipo = this.value;
                var saidaPreco = document.getElementById('saida_preco');
                if (tipo === 'saida') {
                    saidaPreco.style.display = '';
                } else {
                    saidaPreco.style.display = 'none';
                }
            });
            document.getElementById('tipo_movimentacao').addEventListener('change', function () {
                var tipo = this.value;
                var entradaPreco = document.getElementById('entrada_preco');
                if (tipo === 'entrada') {
                    entradaPreco.style.display = '';
                } else{
                    entradaPreco.style.display = 'none';
                }
            });

            // Mostrar/Esconder Nota fiscal conforme o tipo de movimentação
            document.getElementById('tipo_movimentacao').addEventListener('change', function () {
                var tipo = this.value;
                var notafiscalSelect = document.getElementById('notafiscal_select');
                if (tipo === 'entrada') {
                    notafiscalSelect.style.display = '';
                } else {
                    notafiscalSelect.style.display = 'none';
                }
            });
            // Mostrar/esconder campo de seleção de cliente conforme o tipo de movimentação
            document.getElementById('tipo_movimentacao').addEventListener('change', function () {
                var tipo = this.value;
                var clienteSelect = document.getElementById('cliente_select');
                if (tipo === 'saida') {
                    clienteSelect.style.display = '';
                } else {
                    clienteSelect.style.display = 'none';
                }
            });
        </script>
        <script>
            document.getElementById('tipo_movimentacao').addEventListener('change', function() {
                toggleNumeroSerieFields();
                if (this.value === 'saida') {
                    carregarNumerosSerie();
                }
            });

            document.getElementById('nome_produto').addEventListener('change', function() {
                if (document.getElementById('tipo_movimentacao').value === 'saida') {
                    carregarNumerosSerie();
                }
            });

            function toggleNumeroSerieFields() {
                var tipo = document.getElementById('tipo_movimentacao').value;
                if (tipo === 'entrada') {
                    document.getElementById('entrada_serie').style.display = 'block';
                    document.getElementById('saida_serie').style.display = 'none';
                } else if (tipo === 'saida') {
                    document.getElementById('entrada_serie').style.display = 'none';
                    document.getElementById('saida_serie').style.display = 'block';
                }
            }

            function carregarNumerosSerie() {
                var nomeProduto = document.getElementById('nome_produto').value;
                
                if (nomeProduto) {
                    fetch('get_numeros_serie.php?nome_produto=' + encodeURIComponent(nomeProduto))
                        .then(response => response.json())
                        .then(data => {
                            var select = document.getElementById('numero_serie_select');
                            select.innerHTML = '';
                            data.forEach(function(numero) {
                                var option = document.createElement('option');
                                option.value = numero;
                                option.textContent = numero;
                                select.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Erro ao carregar os números de série:', error));
                }
            }

            // Inicializar campos corretamente
            document.addEventListener('DOMContentLoaded', function() {
                toggleNumeroSerieFields();
            });
        </script>
        
        </div>
    
    </div>
</body>
</html>
