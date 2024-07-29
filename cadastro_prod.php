<?php
    
    include("teste.php");
    

    // Conectar ao banco de dados
    $conexao = new mysqli("localhost", "root", "", "mydb");

    // Verificar conexão
    if ($conexao->connect_error) {
        die("Erro de conexão: " . $conexao->connect_error);
    }

    // Recuperar os dados do formulário
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';

    // Verificar se todos os campos obrigatórios foram preenchidos
    if (empty($nome) || empty($usuario)) {
        echo "Por favor, preencha todos os campos obrigatórios.";
        exit();
    }
    

        // Preparar e executar a consulta SQL para inserir os dados
        $sql = "INSERT INTO produto (nome, descricao, usuario) VALUES (?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sss", $nome, $descricao, $usuario);

        if ($stmt->execute() === TRUE) {
            echo "Dados inseridos com sucesso! <br>";

            // Recuperar o ID do produto inserido
            $id_produto = $stmt->insert_id;
        }

           

            
        $stmt->close();

    

    $conexao->close();
?>