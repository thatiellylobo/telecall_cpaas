<?php
// Verificar se o ID do cliente foi enviado
if (isset($_GET['id'])) {
    // Conectar ao banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "thati2536";
    $dbname = "telecall_cpaas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Recebe o id do cliente a ser excluído
    $idCliente = $_GET['id'];

    // Query SQL para exclusão do cliente
    $sql = "DELETE FROM cliente WHERE id_cliente = $idCliente";

    // Verifica se a exclusão foi bem sucedida
    if ($conn->query($sql) === TRUE) {
        echo "Cliente excluído com sucesso!";
    } else {
        echo "Erro ao excluir cliente: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();

} else {
    echo "Erro: Id do cliente não foi enviado.";
}


?>