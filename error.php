<?php
session_start();

// Verificar se o parâmetro "from" está definido e se seu valor é "2fa"
if (!isset($_GET['from']) || $_GET['from'] !== '2fa') {
    // Redirecionar para a página de login se o parâmetro "from" não estiver definido ou se seu valor não for "2fa"
    header("Location: login.html");
    exit();
}
?>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>2 FA</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="css/error.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="img/icon-telecall.png" type="image/x-icon" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <script src="javascript/script.js" defer></script>


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

    <div>
    <img id="acesso-negado" src="img/aviso-azul.svg" alt="acesso negado"/>
</div>
    
    <div class = "pagina">
        <h1 id="frase principal">3 tentativas sem sucesso!<br>Favor realizar login novamente.<h1>

        <a id="botao" href="login.html">Login</a> 
</div>


</body>
</html>
