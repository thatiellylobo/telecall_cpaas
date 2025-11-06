<?php
// Verificar se o ID do cliente foi enviado
if (isset($_GET['id'])) {
    // Conectar ao banco de dados
  $servername = "telecall-bd.ceuorwf57uex.us-east-1.rds.amazonaws.com";
  $username = "admin";
  $password = "thati2215";
  $dbname = "telecall_cpaas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Obter o ID do cliente enviado via GET
    $id_cliente = $_GET['id'];

    // Consulta SQL para obter os dados do cliente com o ID correspondente
    $sql = "SELECT * FROM cliente WHERE id_cliente = $id_cliente";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Retornar os dados do cliente em formato JSON
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        // Retornar um erro se o cliente não foi encontrado
        echo "Cliente não encontrado";
    }

    $conn->close();
}
?>