<?php
    include("cliente.php");
    // Conexão com o banco
    $conn = new mysqli('localhost', 'root', '', 'mydb');
    if ($conn->connect_error) {
        die("Falha na conexão com o banco: " . $conn->connect_error);
    }
    
    // Obtendo dados do formulário
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $grupo = isset($_POST['grupo']) ? $_POST['grupo'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';

    // Verificar se todos os campos obrigatórios foram preenchidos
    if (empty($nome) || empty($grupo)) {
        echo "Por favor, preencha todos os campos obrigatórios.";
        exit();
    }

    // Preparar e executar a consulta SQL para inserir os dados
    $sql = "INSERT INTO cliente (nome, grupo, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $grupo, $email);
    
    if ($stmt->execute() === TRUE) {
        echo "Dados inseridos com sucesso! <br>";
        
        //Recuperar o ID do Cliente Inserido
        $id_cliente = $stmt->insert_id; 

        
    } else {
        echo "Erro ao inserir dados na tabela cliente: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    
?>