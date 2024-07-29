<?php
    include("entrada_nota.php");
    // Conexão com o banco
    $conn = new mysqli('localhost', 'root', '', 'mydb');
    if ($conn->connect_error) {
        die("Falha na conexão com o banco: " . $conn->connect_error);
    }
    
    // Obtendo dados do formulário
    $nota = isset($_POST['nota']) ? $_POST['nota'] : '';
    $fornecedor = isset($_POST['fornecedor']) ? $_POST['fornecedor'] : '';

    // Verificar se todos os campos obrigatórios foram preenchidos
    if (empty($nota)) {
        echo "Por favor, preencha todos os campos obrigatórios.";
        exit();
    }

    // Preparar e executar a consulta SQL para inserir os dados
    $sql = "INSERT INTO nota_fiscal (nota, fornecedor) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nota, $fornecedor);
    
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