<?php
$servername = "rds-telecall.ceuorwf57uex.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "thati2536";
$dbname = "telecall_cpaas";

// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
