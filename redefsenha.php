<?php
session_start();
include 'config.php';

// Inicialize as variáveis $erro e $sucesso
$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nova_senha = $_POST['nova_senha'];
  $confirmar_senha = $_POST['confirmar_senha'];

  // Verificar se as senhas coincidem e têm exatamente 8 caracteres
  if ($nova_senha != $confirmar_senha || strlen($nova_senha) !== 8 || strlen($confirmar_senha) !== 8) {
    $erro = "As senhas não coincidem ou não têm 8 caracteres.";
  } else {
    // Usar um hash simples e truncar (método não recomendado pois não é seguro)
    $hashed_senha = substr(md5($nova_senha), 0, 8);
    $id_cliente = $_SESSION['id_cliente'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      $erro = "Erro ao conectar ao banco de dados: " . $conn->connect_error;
    } else {
      $sql = "UPDATE cliente SET senhaCad = ? WHERE id_cliente = ?";
      $stmt = $conn->prepare($sql);
      if (!$stmt) {
        $erro = "Erro ao preparar a declaração: " . $conn->error;
      } else {
        $stmt->bind_param('si', $hashed_senha, $id_cliente);

        if ($stmt->execute()) {
          $sucesso = "Senha alterada com sucesso!";
        } else {
          $erro = "Erro ao atualizar a senha: " . $stmt->error;
        }

        $stmt->close();
      }
      $conn->close();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="icon" href="img/icon-telecall.png" type="image/x-icon" />
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="javascript/script.js" defer></script>
  <script src="javascript/aumentar.js" defer></script>
  <script src="javascript/usuario_greeting.js" defer></script>
  <script src="javascript/bloq.js" defer></script>
  <link href="redefsenha.css" rel="stylesheet" type="text/css" />
  <title>Redefinir senha</title>


  <script>

    function validarSenha(event) {
      event.preventDefault(); // Impede a submissão do formulário

      const novaSenha = document.getElementById('nova_senha').value;
      const confirmarSenha = document.getElementById('confirmar_senha').value;
      const mensagemErro = document.getElementById('mensagemErro');
      const mensagemSucesso = document.getElementById('mensagemSucesso');

      // Limpar mensagens anteriores
      mensagemErro.innerText = '';
      mensagemErro.classList.remove('error-message');
      mensagemSucesso.innerText = '';
      mensagemSucesso.classList.remove('success-message');

      // Verificação de campos vazios
      if (novaSenha === '' || confirmarSenha === '') {
        mensagemErro.innerText = 'Preencha os dois campos.';
        mensagemErro.classList.add('error-message');
        return;
      }

      // Verificação de senhas
      if (novaSenha !== confirmarSenha) {
        mensagemErro.innerText = 'As senhas não coincidem.';
        mensagemErro.classList.add('error-message');
      } else if (novaSenha.length !== 8) {
        mensagemErro.innerText = 'A senha deve ter 8 caracteres.';
        mensagemErro.classList.add('error-message');
      } else {
        // Se todas as verificações passarem, exibe a mensagem de sucesso e envia o formulário
        mensagemSucesso.innerText = 'Senha alterada com sucesso!';
        mensagemSucesso.classList.add('success-message');
        setTimeout(() => {
          event.target.submit();
        }, 1000); // Envia o formulário após 1 segundo
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('redefinir-senha').addEventListener('submit', validarSenha);

      const clearError = () => {
        const mensagemErro = document.getElementById('mensagemErro');
        mensagemErro.innerText = '';
        mensagemErro.classList.remove('error-message');
      };

      document.getElementById('nova_senha').addEventListener('input', clearError);
      document.getElementById('confirmar_senha').addEventListener('input', clearError);
    });

  </script>
 
<style>

.dark #nome {
  margin-top: -2px;
}


.dark .dropdown-content p {
      margin-bottom: 35px;
    }


.dark .menu1 {
  margin-top: -30px;
}

  .btnn {
  background-color: #373737;
  color: white;
  text-decoration: none;
  border: none;
  font-weight: bolder;
  cursor: pointer;
  outline: none;
  box-shadow: none;
}

.btnn:hover {
  outline: none;
  text-decoration: none;
  box-shadow: none;
  color: #70c8ff;

}

#sair {
  float: left;
  margin-left: 10px;
  width: 65px;
  height: 30px;
  font-size: 12px;
  white-space: nowrap;
  background-color: #b04a4a;
  color: white;
  border: none;!important
  outline-style: none;
  outline:none;
  border-radius: 10px;
  cursor: pointer;
}

#sair:hover {
  outline-style: none;
  outline: none;
  border: none;
}

.dropdown-item {
  margin-left: -12px;
  
}

.dropdown-user a:hover {
  background-color: transparent;
}

button#userButton:focus,
.user-button:focus {
  outline: none;
  box-shadow: none;
}

#dropdownMenuButton {
  background-color: transparent;
  border: none;
  box-shadow: none;
}

.dropdown-content p {
      margin-bottom: 15px;
    }



</style>

</head>

<body>

  <header>
    <!--- header --->

    <header id="cabeçalho">
      <a href="telainterna.html">
        <img id="img" src="img/modavo-icon-branco.png" alt="logo da loja"></a>

      <!---------  menu com botao ------->

      <div class="menu1">
        <nav class="menu-opcoes active">
          <ul>
            <li class="dropdown">
              <button class="btnn btn-prim dropdown-toggle" type="button" data-toggle="dropdown"> Serviços
                <span class="caret"></span> </button>
              <div class="dropdown-menu">
                <a id="first" href="2fa.html">2FA</a>
                <a href="numascara.html">Número Máscara</a>
                <a href="googleverif.html">Google Verified Calls</a>
                <a href="sms.html">SMS Programável</a>
              </div>
            </li>
            <li>
              <a id="sobre-link" href="#sobre">Sobre</a>
            </li>
          </ul>
        </nav>
      </div>
      <!---------  menu com botao ------->

      <!-- - dark theme --->
      <div>
        <input type="checkbox" name="change-theme" id="change-theme">
        <label for="change-theme">
          <i class="bi bi-circle-half"> </i>
        </label>
      </div>
      <!--- dark theme - -->


      <!--- acessibilidade aumento de font --->
      <div class="letra">
        <input type="checkbox" name="change-letter" id="change-letter">
        <label for="change-letter">
          <i class="bi bi-type"></i>
        </label>
        <button type="button" id="btnDiminuir">-</button>
        <button type="button" id="btnAumentar">+</button>
      </div>

      <!--- acessibilidade aumento de font --->

      <!--- menu com dados do usuário --->

      <div class="dropdown-user">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <div class="user-greeting">
            <h2 style="color: white;">Bem-vindo, <span id="userCad"></span>!</h2>
          </div>
          <i style="color: white;" class="bi bi-person-circle"></i>
        </button>
        <div class="dropdown-menu-user" aria-labelledby="dropdownMenuButton">
          <div class="dropdown-content">
            <div class="borda-nome">
              <p id="nome"></p>
            </div>
            <p id="username"></p>
            <p id="email"></p>
            <p id="cpf"></p>
            <a class="dropdown-item"></a>
            <a class="dropdown-item"></a><br>
            <button onclick="sair()" id="sair">Sair <i class="bi bi-box-arrow-in-right"></i></button>
          </div>
        </div>

        <!--- menu com dados do usuário --->

    </header>
    <div class="container">
      <div class="row">
        <div class="row">
          <div class="col-md-6">
            <div class="form-senha">
              <img id="img-mododark" src="img/modavo-icon-branco.png" alt="logo da loja" />
              <img src="img/modavo-icon.png" alt="logo da loja" /> <br />
              <p>Preencha os campos abaixo para redefinir sua senha</p>
              <div id="mensagemErro" class="borda-erro"></div>
              <div id="mensagemSucesso" class="borda-sucesso"></div>
              <form id="redefinir-senha" method="POST" action="redefsenha.php">
                <input id="nova_senha" name="nova_senha" type="password" maxlength="8" placeholder="Nova senha"
                  autofocus aria-label="Insira sua nova senha" />
                <input id="confirmar_senha" name="confirmar_senha" type="password" maxlength="8"
                  placeholder="Confirmar nova senha" aria-label="Confirme sua nova senha" />
                <input type="submit" value="Redefinir Senha" id="botao" />
                <input type="reset" value="Limpar" id="botao-reset" />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
  <script>
  document.addEventListener('DOMContentLoaded', () => {
  const acessoLocalStorage = localStorage.getItem('acesso');
  if (!acessoLocalStorage || acessoLocalStorage !== '1') {
    const overlay = document.createElement('div');
    overlay.className = 'overlay';
    
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerText = 'Acesso negado. Você não tem permissão para acessar esta página.';
    
    document.body.appendChild(overlay);
    document.body.appendChild(toast);
    
    setTimeout(() => {

      window.location.href = "telainterna.html";
    }, 3000); // Remover o toast e o overlay após 3 segundos
  }
});

function togglePassword(id) {
      const input = document.getElementById(id);
      const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
      input.setAttribute('type', type);
    }

</script>

</html>