<?php
session_start();
include 'config.php';

// Função para buscar usuários no banco de dados com opções de filtro
function getAllUsers($conn, $filter = null, $searchTerm = null)
{
    $sql = "SELECT nome, userCad, timestamp_acesso, pergunta_bem_sucedida FROM cliente WHERE `acesso` != 0";

    // Se houver filtro e termo de pesquisa, adicione à consulta SQL
    if ($filter && $searchTerm) {
        if ($filter === 'userCad') {
            $sql .= " AND userCad LIKE ?";
        } elseif ($filter === 'nome') {
            $sql .= " AND nome LIKE ?";
        }
    } elseif ($searchTerm) {
        $sql .= " AND (userCad LIKE ? OR nome LIKE ?)";
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Falha na preparação da consulta SQL: " . $conn->error);
    }

    if ($filter && $searchTerm) {
        $searchTerm = "%$searchTerm%";
        $stmt->bind_param("s", $searchTerm);
    } elseif ($searchTerm) {
        $searchTerm = "%$searchTerm%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
    }

    $stmt->execute();
    if (!$stmt) {
        throw new Exception("Erro ao executar a consulta SQL: " . $stmt->error);
    }

    $result = $stmt->get_result();
    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST['search'];
    $filter = $_POST['filter'];

    if ($filter == 'all') {
        $users = getAllUsers($conn);
    } else {
        $users = getAllUsers($conn, $filter, $searchTerm);
    }
} else {
    // Carregar todos os usuários ao abrir a página pela primeira vez
    $users = getAllUsers($conn);
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/icon-telecall.png" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="javascript/script.js" defer></script>

    <script src="javascript/usuario_greeting.js" defer></script>
    <script src="javascript/bloq.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="css/telalog.css" rel="stylesheet" type="text/css" />
    <script src="javascript/aumentar.js" defer></script>
    <title>Listagem de Usuários</title>

    <style>

        .dark footer {
            background-color: #000000;
            width: 100%;
            height: 200px;
        }

        .dark #logo1 {
            display: block;
            width: 160px;
            height: 40px;
            border-radius: 2px;
        
        }

        #logo1 {
            display: none;
        }

        .dark footer #logo  {
            display: block;
          
        }
        
        .dark footer .contato {
            margin-top: -50px;
        }

        #email {
            margin-left: 3.4%;
            display: block;
        }

        .dark .dropdown-menu-user {
            background-color: #0a0a0a;
            margin-top: 10px;

        }

        .dark #dropdownMenuButton {
            margin-top: -36px;
        }

        .dropdown-item {
            padding-left: 23px;
            font-size: 13px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            display: block;
            margin-top: 20px;
            margin-bottom: 20px;
            line-height: 1px;

        }

        input[type="checkbox"] {
            display: none;
        }

        .dark #nome {
            margin-top: -2px;
        }


        .dark .dropdown-content p {
            margin-bottom: 35px;
        }


        .dark .menu1 {
            margin-top: -42px;
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
            border: none;
            !important outline-style: none;
            outline: none;
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

        * {
            box-sizing: border-box;
        }

        body {
            scroll-behavior: smooth;
            font-family: Arial, sans-serif;
            background-color: #ebf5fa;
            transition: background-color 0.4s ease-in-out, color 0.4s ease-in-out;
            margin: 0;
            padding: 0;
        }

        .dark .container {
            background-color: black;
            box-shadow: 0 0.2rem 1rem #cfcfcf;
        }

        .container {
            margin-top: 150px;
            margin-left: 20%;
            margin-right: 20%;
            max-width: 800px;
            /* margin: 20px auto; */
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            font-size: 28px;
            text-align: center;
            margin-bottom: 20px;
        }

        .container h3 {

            padding: 10px;
        }

        form {
            display: flex;
            justify-content: center;
            /* Centraliza o formulário horizontalmente */
            margin-bottom: 20px;
        }


        form input[type="text"],
        form select {
            padding: 8px;
            border: 1px solid #0084db;
            font-size: 16px;
            outline: none;
            border-radius: 4px;
            margin: 3px;
            width: 250px;
        }

        form select {
            border-radius: 4px;
            cursor: pointer;
            width: 100px;
        }

        form button {
            background-color: #0274be;
            color: #ffffff;
            width: 115px;
            font-size: 15px;
            font-weight: 600;
            height: 37px;
            transition: all linear 160ms;
            cursor: pointer;
            display: block;
            margin: 0pt;
            margin-top: 3px;
            margin-left: 5px;
            border-radius: 5px;
            border: none;
        }

        form button:hover {
            transform: scale(1.05);
            background-color: #0084db;
        }

        table {
            width: 98%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 5px;

        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #0274be;
            color: #fff;
        }

        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .dark table tbody tr:nth-child(even) {
            background-color: black;
        }

        .dark ::placeholder {
            color: white;
        }

        .dark form input {
            background-color: #383c3d;
            border: 1px solid #bababa;
            color: white;
        }

        .dark form select {
            background-color: #383c3d;
            border: 1px solid #bababa;
            color: white;
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
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <a class="dropdown-item"></a>
                        <a class="dropdown-item"></a>
                        <button onclick="sair()" id="sair">Sair <i class="bi bi-box-arrow-in-right"></i></button>
                    </div>
                </div>

                <!--- menu com dados do usuário --->

        </header>


        <div class="container">
            <h1>Tela de Log</h1>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="search" autofocus placeholder="Pesquisar por Nome, Usuário">
                <select name="filter">
                    <option value="nome">Nome</option>
                    <option value="userCad">Usuário</option>
                </select>
                <button type="submit" name="submit">Pesquisar</button>
            </form>

            <h3>Resultados da Pesquisa</h3>

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Usuário</th>
                        <th>Data/Hora de Acesso</th>
                        <th>Pergunta de autenticação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users && $users->num_rows > 0) {
                        while ($row = $users->fetch_assoc()) { ?>
                    <tr>
                        <td>
                            <?php echo $row['nome']; ?>
                        </td>
                        <td>
                            <?php echo $row['userCad']; ?>
                        </td>
                        <td>
                            <?php echo $row['timestamp_acesso']; ?>
                        </td>
                        <td>
                            <?php echo $row['pergunta_bem_sucedida']; ?>
                        </td>
                    </tr>
                    <?php }
                    } else { ?>
                    <tr>
                        <td colspan="4">Nenhum usuário encontrado.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

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
        <!--- footer --->
        <footer>
            <img src="img/logotelecallbranco1.png" alt="Logo Telecall" id="logo1">

            <div id="container">
                <a href="https://telecall.com/?gclid=EAIaIQobChMI7Zn_6qKUggMV-19IAB1lIAw2EAAYASAAEgJ73fD_BwE"
                    target="_blank"><img src="img/logotelecallbranco.png" alt="Logo Telecall" id="logo"></a>
                
                <div class="contato">
                    <h2>Contato</h2>
                    <ul>
                        <li>(21) 3030-1010</li>
                        <li>0800 030 2016</li>
                        <li id="email1">suporte@telecall.com</li>
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

</html>