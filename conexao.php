
        /*
        // Conectar ao banco de dados
        $conexao = new mysqli("localhost", "root", "", "mydb");

        // Verificar conexão
        if ($conexao->connect_error) {
            die("Erro de conexão: " . $conexao->connect_error);
        }

        // Recuperar os dados do formulário
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $quantidade = $_POST['quantidade'];
        $usuario = $_POST['usuario'];

        // Preparar e executar a consulta SQL para inserir os dados
        $sql = "INSERT INTO produto (nome, descricao, quantidade, usuario) VALUES ('$nome', '$descricao', '$quantidade', '$usuario')";
        if ($conexao->query($sql) === TRUE) {
            echo "Dados inseridos com sucesso!";
        } else {
            echo "Erro ao inserir dados: " . $conexao->error;
        }

        //Fechar conexão com o banco de dados
        $conexao->close();

        header("content-type: text/html;charset=utf-8");
            $server = "localhost";
            $usuario = "root";
            $senha = "";
            $database = "mydb";

            $conn = new mysqli($server, $usuario, $senha, $database) or die (mysqli_error($conn));
	mysqli_set_charset($conn,"utf8");

  

    ?>  */