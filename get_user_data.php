<?php
session_start();
include 'config.php'; // Inclua o arquivo de configuração do banco de dados

// Verifique se o usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    header("Location: login.html");
    exit();
}

// Recuperar dados do usuário logado
$id_cliente = $_SESSION['id_cliente'];
$sql = "SELECT nome, userCad, email, cpf FROM cliente WHERE id_cliente = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Retorna os dados do usuário como JSON
header('Content-Type: application/json');
echo json_encode($user);
?>
