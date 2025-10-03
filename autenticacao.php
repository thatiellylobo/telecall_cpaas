<?php
session_start();

include 'config.php'; // Inclua suas configurações de conexão com o banco de dados e funções necessárias

// Função para buscar informações do usuário no banco de dados por ID
function getUsuarioPorId($conn, $id_cliente) {
    $sql = "SELECT nome_materno, cep, nascimento FROM cliente WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    return $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_SESSION['id_cliente'];
    $pergunta_index = $_POST["pergunta"];
    $resposta_usuario = $_POST["resposta"];

    // Definir as possíveis perguntas e respostas
    $perguntas = ["Qual o nome da sua mãe?", "Qual o seu cep?", "Qual a sua data de nascimento?"];

    // Buscar as respostas corretas no banco de dados
    $usuario = getUsuarioPorId($conn, $id_cliente);
    $respostas_corretas = [
        $usuario['nome_materno'],
        $usuario['cep'],
        $usuario['nascimento']
    ];
    $resposta_correta = $respostas_corretas[$pergunta_index];

    if ($resposta_usuario !== $resposta_correta) {
        // Resposta incorreta
        if (!isset($_SESSION['tentativas'])) {
            $_SESSION['tentativas'] = 1;
        } else {
            $_SESSION['tentativas']++;
        }

        if ($_SESSION['tentativas'] >= 3) {
            $_SESSION['erro_msg'] = "3 tentativas sem sucesso! Favor realizar login novamente.";
            session_destroy(); // Destruir a sessão para garantir um novo login
            header("Location: error.php?from=2fa"); // Redirecionar para a página de erro
            exit();
        } else {
            $_SESSION['erro_msg'] = "Resposta incorreta. Tente novamente.";
            header("Location: 2fa.php");
            exit();
        }
    } else {
        // Resposta correta
        $_SESSION['pergunta_bem_sucedida'] = $perguntas[$pergunta_index];

        // Atualizar o banco de dados com a pergunta bem sucedida
        $conn = new mysqli($servername, $username, $password, $dbname); // Reabrir a conexão
        if ($conn->connect_error) {
            die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
        }

        $sqlUpdate = "UPDATE cliente SET pergunta_bem_sucedida = ? WHERE id_cliente = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("si", $_SESSION['pergunta_bem_sucedida'], $id_cliente);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        // Fechar a conexão após todas as operações
        $conn->close();

        // Resetar o número de tentativas para 0
        $_SESSION['tentativas'] = 0;
        header("Location: telainterna.html");
        exit();
    }
}
?>
