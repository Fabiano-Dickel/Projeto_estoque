<?php
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include('usuario.php');
    //Conexão com o banco
    $conn = new mysqli('localhost', 'root', '', 'mydb');
    if ($conn->connect_error){
        die("Erro na conexao: " . $conn->connect_error);
    }

    //Declaração de variáveis
    $nome_usuario = isset($_POST['nome_usuario']) ? $_POST['nome_usuario'] : '';
    $senha_usuario = isset($_POST['senha_usuario']) ? $_POST['senha_usuario'] : '';
    
    //Verifica se os campos estão preenchidos
    if (empty($nome_usuario) || empty($senha_usuario)) {
        die("Nome de usuário e senha são obrigatórios.");
    }

    //Criptografa a senha
    $senha_hashed = password_hash($senha_usuario, PASSWORD_DEFAULT);

    //Inserindo informações do usuário na tabela
    $sql = "INSERT INTO usuario (nome, senha) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        //Bind dos parâmetros
        $stmt->bind_param("ss", $nome_usuario, $senha_hashed);

        //Executa a declaração
        if ($stmt->execute()) {
            echo "Usuário cadastrado com sucesso";
        } else {
            echo "Erro ao cadastrar o usuário: " . $stmt->error;
        }

        //Fecha a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
     
    //Fecha a conexão
    $conn->close();
    
?>