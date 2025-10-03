<?php
$mysqli = new mysqli("localhost", "root", "thati2536", "telecall_cpaas");

if ($mysqli->connect_errno) {
  echo "Falha ao conectar ao MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  exit();
}

$parametro = isset($_GET['parametro']) ? $_GET['parametro'] : '';

if ($parametro) {
    $query = "SELECT * FROM cliente WHERE nome LIKE '%$parametro%' AND acesso = 1 ORDER BY nome";
} else {
    $query = "SELECT * FROM cliente WHERE acesso = 1 ORDER BY id_cliente";
}


if ($result = $mysqli->query($query)) {
  ?>
  <!DOCTYPE html>
  <html lang="pt-BR">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="img/icon-telecall.png" type="image/x-icon" />
    <script src="javascript/script.js" defer></script>
    <link rel="stylesheet" href="css/cons_usuario.css">
    <script src="javascript/cons_usuario.js" defer></script>
    <script src="javascript/aumentar.js" defer></script>
    <script src="javascript/bloq.js" defer></script>
    <script src="javascript/usuario_greeting.js" defer></script>
    <title>Consulta de Usuário</title>

    <style>


     .cliente-info {
      color: black;
     }
      /* ------ acessibilidade letra ----- */

      #btnAumentar {
        outline: none;
        border: none;
        background-color: #373737;
        color: #ffffff;
        cursor: pointer;
        font-size: 1.2rem;
        float: right;
        right: 300px;
        top: 39.5px;
        position: absolute;
      }

      #btnAumentar:hover {
        color: #70c8ff;
      }

      #btnDiminuir {
        outline: none;
        border: none;
        background-color: #373737;
        color: #ffffff;
        cursor: pointer;
        font-size: 1.6rem;
        float: right;
        right: 255px;
        top: 35px;
        position: absolute;
      }

      .dark #btnDiminuir {
        background-color: #0a0a0a;
      }

      .dark #btnAumentar {
        background-color: #0a0a0a;
      }

      #btnDiminuir:hover {
        color: #70c8ff;
      }

      .bi-type {
        color: #ffffff;
        font-size: 1.7rem;
        float: right;
        right: 275px;
        top: 35px;
        position: absolute;
      }

      .bi-type:hover {
        color: white;
      }

      /* ------ acessibilidade letra ----- */

      /* menu do usuario */

      strong {
        font-weight: bold;
        color: white;
      }

      .dropdown-user {
        margin-right: 50px;
      }

      .dark .dropdown-menu-user {
        background-color: #0a0a0a;
      }

      .dropdown-menu-user {
        width: 300px;
        position: fixed;
        background-color: #373737;
        padding: 10px;
        border-radius: 3px;
        top: 10;
        right: 0;
        margin-right: -16px;
      }

      #dropdownMenuButton {
        position: fixed;
        top: 0;
        right: 0;
        padding: 33px;
        height: 100px;
        margin-right: -10px;
      }

      .dark #dropdownMenuButton {
        background-color: #0a0a0a;
      }

      .user-greeting {
        margin-left: 35px;
      }

      .user-greeting h2 {
        margin-bottom: -2px;
        font-size: 13px;
        font-weight: 100;
        white-space: normal;
      }

      .bi-person-circle {
        float: left;
        margin-right: 3px;
        margin-top: -21px;
        font-size: 28px;
      }

      .dropdown-content p {
        color: #fffefe;
        padding: 10px 10px;
        font-size: 13px;
        margin-bottom: -15px;
      }

      .dropdown-content #email {
        margin-left: 0.5px;
      }

      .dropdown-item {
        margin-left: 3%;
        font-size: 13px;
        text-decoration: none;
        color: white;
        font-weight: bold;
      }

      .dropdown-content #banco {
        margin-left: -20px;
      }

      .dropdown-item:hover {
        color: #70c8ff;
      }

      #nome {
        color: rgb(61, 61, 61);
        font-weight: bolder;
        white-space: nowrap;
        text-align: left;
        padding: 5px;
        margin-top: 2px;
      }

      #cpf {
        margin-bottom: 17px;
        border-bottom: #9b9a9a 1px solid;
      }

      .borda-nome {
        width: 280px;
        height: 28px;
        margin-left: 0px;
        margin-top: 15px;
        background-color: #f3f3f3;
        padding: 2px;
        border-radius: 2px;
      }

      #sair {
        float: left;
        margin-left: 10px;
        width: 65px;
        height: 30px;
        font-size: 12px;
        white-space: nowrap;
      }

      .dropdown-content {
        display: none;
      }

      .show {
        display: block;
      }

      /* menu do usuario */

      .bi-circle-half {
        color: #ffffff;
        font-size: 1.4rem;
        right: 0;
        top: 0;
        padding: 40px;
        margin-right: 175px;
        position: fixed;
        cursor: pointer;
        display: block;
      }

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
        -webkit-backdrop-filter: blur(40px);
        /* Safari */
        backdrop-filter: blur(40px);
        z-index: 9998;
      }
    </style>



  </head>

  <!--- header --->
<header id="cabeçalho">
  <a href="telainterna.html">
    <img id="img" src="img/modavo-icon-branco.png" alt="logo da loja"></a>


  <!--------- mobile menu --------->
  <span class="material-symbols-outlined" onclick="clickMenu()">menu</span>
  <div class="area-mobmenu">
    <ul id="itens" class="mobile-menu">
      </li>
      <li><a href="telainterna.html#sobre">Sobre</a></li>
      <li><a id="first" href="2fa.html">2FA</a></li>
      <li><a href="numascara.html">Número Máscara</a></li>
      <li><a href="googleverif.html">Google Verified Calls</a></li>
      <li><a href="sms.html">SMS Programável</a></li>
      <li><button onclick="sair()" id="mobsair">Sair <i class="bi bi-box-arrow-in-right"></i></button>
    </ul>
  </div>
  <!---------- mobile menu ---------->

    <!---------  menu com botao ------->

  <div class="menu1">
    <nav class="menu-opcoes active">
      <ul>
        <li class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Serviços
            <span class="caret"></span> </button>
          <div class="dropdown-menu">
            <a id="first" href="2fa.html">2FA</a>
            <a href="numascara.html">Número Máscara</a>
            <a href="googleverif.html">Google Verified Calls</a>
            <a href="sms.html">SMS Programável</a>
          </div>
        </li>
        <li>
          <a href="telainterna.html#sobre">Sobre</a>
        </li>
      </ul>
    </nav>
  </div>
  <!---------  menu com botao ------->


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
        <a class="dropdown-item"></a><br>
        <a class="dropdown-item"></a><br>
        <a class="dropdown-item"></a>
        <button onclick="sair()" id="sair">Sair <i class="bi bi-box-arrow-in-right"></i></button>
      </div>
    </div>

    <!--- menu com dados do usuário --->



    <!--- dark theme --->
    <div>
      <input type="checkbox" name="change-theme" id="change-theme">
      <label for="change-theme">
        <i class="bi bi-circle-half"> </i>
      </label>
    </div>
    <!--- dark theme --->


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
</header>
<!--- header --->

<body>
  <div class="container">
    <div id="conteudo">
      <h1>Consulta de Usuário</h1>
      <p>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" autofocus name="parametro">
        <input type="submit" value="Buscar" id="btnbuscar">
        <input type="reset" value="Limpar" id="botaolimpar">
      </form>
      </p>

      <table border="1">
        <tr>
          <th>Id</th>
          <th>Nome</th>
          <th>CPF</th>
          <th>Acessar</a></th>
        </tr>
        <?php
        if ($result->num_rows === 0) {
          echo "<tr><td colspan='3'>Nome não encontrado</td></tr>";
        } else {
          while ($linha = $result->fetch_assoc()) {
            ?>
        <tr>
          <td>
            <?php echo $linha['id_cliente'] ?>
          </td>
          <td>
            <?php echo $linha['nome'] ?>
          </td>
          <td>
            <?php echo $linha['cpf'] ?>
          </td>
          <td><a href="#" class="visualizar" data-id="<?php echo $linha['id_cliente']; ?>"><i class="bi bi-eye"></i></a>
          </td>

        </tr>
        <?php
          }
        }
        $result->free();
        ?>
      </table>
    </div>

    <div id="modal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Dados do Cliente</h2>
        <p id="cliente-info"></p>
      </div>
    </div>
  </div>

  <!--- footer --->
  <footer>
    <div id="container">
      <a href="https://telecall.com/?gclid=EAIaIQobChMI7Zn_6qKUggMV-19IAB1lIAw2EAAYASAAEgJ73fD_BwE" target="_blank"><img
          src="img/logotelecallbranco.png" alt="Logo Telecall" id="logo"></a>
      <div class="contato">
        <h2>Contato</h2>
        <ul>
          <li>(21) 3030-1010</li>
          <li>0800 030 2016</li>
          <li id="email">suporte@telecall.com</li>
        </ul>
      </div>
      <div class="social">
        <ul>
          <li>
            <a href="https://www.linkedin.com/company/telecall/" target="_blank">
              <i class="bi bi-linkedin"></i></a>
          </li>
          <li>
            <a href="https://www.instagram.com/telecallbr/" target="_blank">
              <i class="bi bi-instagram"> </i></a>
          </li>
          <li>
            <a href="https://www.facebook.com/TelecallBr" target="_blank">
              <i class="bi bi-facebook"> </i></a>
          </li>
        </ul>
      </div>

  </footer>
  <!--- footer --->

</body>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const acessoLocalStorage = localStorage.getItem('acesso');
    if (!acessoLocalStorage || acessoLocalStorage !== '0') {
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
</script>

</html>
<?php
} else {
  echo "Erro na consulta: " . $mysqli->error;
}

$mysqli->close();
?>