// Iniciar a sessão
<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "thati2536";
$dbname = "telecall_cpaas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Recebendo e sanitizando os dados do primeiro formulário
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$nascimento = isset($_POST['nascimento']) ? $_POST['nascimento'] : '';
$nome_materno = isset($_POST['nome_materno']) ? $_POST['nome_materno'] : '';
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
$celular = isset($_POST['celular']) ? $_POST['celular'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$userCad = isset($_POST['userCad']) ? $_POST['userCad'] : '';
$senhaCad = isset($_POST['senhaCad']) ? $_POST['senhaCad'] : '';

// Recebendo e sanitizando os dados do segundo formulário
$cep = isset($_POST['cep']) ? $_POST['cep'] : '';
$endereco = isset($_POST['endereco']) ? $_POST['endereco'] : '';
$numero = isset($_POST['numero']) ? $_POST['numero'] : 0;
$bairro = isset($_POST['bairro']) ? $_POST['bairro'] : '';
$cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
$estado = isset($_POST['estado']) ?  $_POST['estado'] : '';

$formulario = isset($_POST['formulario']) ? $_POST['formulario'] : '';

$acesso = isset($_POST['acesso']) ? $_POST['acesso'] : 1;

if ($formulario === 'cadastro1') {
    // Gerar o hash da senha com md5 e, em seguida, truncar para 8 caracteres
    $senha_hash = substr(md5($senhaCad), 0, 8);

    // Processar os dados do cadastro1
    // Inserir na tabela cliente
    $sql = "INSERT INTO cliente (nome, nascimento, nome_materno, cpf, celular, email, userCad, senhaCad, acesso) VALUES ('$nome', '$nascimento', '$nome_materno', '$cpf', '$celular', '$email', '$userCad', '$senha_hash', '$acesso')";
    if ($conn->query($sql) === TRUE) {
        $id_cliente = $conn->insert_id;
        
        // Armazenar o ID do cliente na sessão
        $_SESSION['id_cliente'] = $id_cliente;

        // Redirecionar para o segundo formulário
        header("Location: cadastro2.html");
        exit();
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

if ($formulario === 'cadastro2') {
    // Obter o ID do cliente da sessão
    $id_cliente = $_SESSION['id_cliente'];

    // Processar os dados do cadastro2
    // Atualizar os dados na tabela cliente
    $sql = "UPDATE cliente SET cep='$cep', endereco='$endereco', numero='$numero', bairro='$bairro', cidade='$cidade', estado='$estado' 
    WHERE id_cliente = $id_cliente;";
    if ($conn->query($sql) === TRUE) {
        header("Location: cadastro3.html");
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

?>
