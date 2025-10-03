<?php
session_start();

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "thati2536";
$dbname = "telecall_cpaas";

// Conectando ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Erro ao conectar ao banco de dados."]);
    exit();
}

// Verificar se o formulário de login foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["login"];
    $senha = $_POST["senha"];

    // Preparar a consulta para evitar injeção de SQL
    $sql = "SELECT id_cliente, userCad, senhaCad, acesso FROM cliente WHERE userCad = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    header('Content-Type: application/json');
    // Verificar se o usuário foi encontrado
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = substr(md5($senha), 0, 8); // Hash truncado da senha fornecida

        // Verificar se a senha está correta
        if ($hashed_password === $row['senhaCad']) {
            // Gerar um token
            $token = bin2hex(random_bytes(16)); // Gera um token aleatório de 32 caracteres

            // Salvar o token na sessão
            $_SESSION['token'] = $token;
            $_SESSION['id_cliente'] = $row['id_cliente'];
            $_SESSION['userCad'] = $row['userCad'];

            // Retornar resposta de sucesso
            echo json_encode([
                "status" => "success",
                "token" => $token,
                "acesso" => $row['acesso'],
                "redirect" => "2fa.php"
            ]);
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Senha incorreta."]);
            exit();
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Usuário não encontrado."]);
        exit();
    }

    // Fechar a declaração
    $stmt->close();
}

// Fechar a conexão
$conn->close();
?>