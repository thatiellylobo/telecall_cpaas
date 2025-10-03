<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['token'])) {
    header("Location: login.html");
    exit();
}

// Definir as possíveis perguntas e respostas
$perguntas = ["Qual o nome da sua mãe?", "Qual o seu cep?", "Qual a sua data de nascimento?"];
$respostas = [];

// Definir as respostas corretas com base nos dados do usuário no banco de dados
$servername = "localhost";
$username = "root";
$password = "thati2536";
$dbname = "telecall_cpaas";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

$id_cliente = $_SESSION['id_cliente'];
$sql = "SELECT nome_materno, cep, nascimento FROM cliente WHERE id_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$respostas[] = $row['nome_materno'];
$respostas[] = $row['cep'];
$respostas[] = $row['nascimento'];
$stmt->close();
$conn->close();

// Escolher aleatoriamente uma pergunta para exibir
$pergunta_index = array_rand($perguntas);
$pergunta = $perguntas[$pergunta_index];
?>

<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>2 FA</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="css/tela2fa.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="img/icon-telecall.png" type="image/x-icon" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <script src="javascript/script.js" defer></script>
    <script src="javascript/bloq.js" defer></script>

    <style>
    .toast {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #b04a4a;
      color: #fff;
      padding: 10px;
      border-radius: 5px;
      z-index: 9999;
    }
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      -webkit-backdrop-filter: blur(40px); /* Safari */
      backdrop-filter: blur(40px);
      z-index: 9998;
    }

    .erro-msg {
  background-color: #f8d7da;
  color: #721c24;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #f5c6cb;
  border-radius: 5px;
  text-align: center;
}

    /* .form h2{
      font-size: 23px;
      letter-spacing: 1px;
      text-align: center;
    } */

</style>
  </head>

  <body>
    <!--- dark theme --->
    <header>
      <div>
        <input type="checkbox" name="change-theme" id="change-theme" />
        <label for="change-theme">
          <i class="bi bi-circle-half"> </i>   <!-- botão contraste -->
        </label>
      </div>
    </header>
    <!--- dark theme --->

    <div class = "pagina">
    <form  class= "form" action="autenticacao.php" method="POST">
    <img id="img-mododark" src="img/modavo-icon-branco.png" alt="logo da loja"/>
    <img src="img/modavo-icon.png" alt="logo da loja" /> <br />
    <h2>Pergunta de Autenticação</h2>
    <?php
        if (isset($_SESSION['erro_msg'])) {
            echo '<div class="erro-msg" id="erro-msg">' . $_SESSION['erro_msg'] . '</div>';
            unset($_SESSION['erro_msg']);
        }
        ?>

    <p><?php echo $pergunta; ?></p>
    <label for="resposta"></label>
        <input type="text" name="resposta" id="resposta" autofocus placeholder="Digite sua resposta" required>
        
        <input type="submit" value="Entrar" id="botao" />
        <input type="reset" value="Limpar" id="botaolimpar" /> 

        <input type="hidden" name="pergunta" value="<?php echo $pergunta_index; ?>">
    </form>
    
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const respostaInput = document.getElementById('resposta');
  const erroMsg = document.getElementById('erro-msg');

  respostaInput.addEventListener('input', function() {
    if (respostaInput.value.length > 0) {
      erroMsg.style.display = 'none'; // Ocultar a mensagem de erro
    }
  });
});
</script>


</body>
</html>
