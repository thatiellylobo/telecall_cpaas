document.addEventListener('DOMContentLoaded', function() {
    // Quando o DOM estiver completamente carregado, execute esta função
  
    // Fazer uma solicitação AJAX para buscar os dados do usuário
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_user_data.php', true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Se a solicitação for bem-sucedida, atualize a saudação de boas-vindas com os dados do usuário
          var userData = JSON.parse(xhr.responseText);
          var nomeCompleto = userData.nome;
          var primeiroNome = nomeCompleto.split(' ')[0]; // Obter o primeiro nome
          var greetingElement = document.querySelector('.user-greeting h2');
          greetingElement.textContent = 'Bem-vindo, ' + primeiroNome + '!';
          
        // Atualizar o conteúdo do dropdown com os dados do usuário
             document.getElementById('nome').innerHTML = '' + userData.nome;
             document.getElementById('username').innerHTML = '<strong>Usuário: </strong> ' + userData.userCad;
             document.getElementById('email').innerHTML = '<strong>Email: </strong> ' + userData.email;
             document.getElementById('cpf').innerHTML = '<strong>CPF: </strong> ' + userData.cpf;

        } else {
          // Se a solicitação falhar, exiba uma mensagem de erro
          console.error('Erro ao buscar dados do usuário. Status da solicitação: ' + xhr.status);
        }
      }
    };
    xhr.send();
  });
  
  // Adicionar evento de clique para alternar a exibição do dropdown
  var dropbtn = document.getElementById('dropdownMenuButton');
    var dropdownContent = document.querySelector('.dropdown-content');
  
    dropbtn.addEventListener('click', function() {
      dropdownContent.classList.toggle('show');
    });
  
    // Fechar o dropdown se o usuário clicar fora dele
    window.onclick = function(event) {
      if (!event.target.matches('#dropdownMenuButton') && !event.target.closest('.dropdown-user')) {
        var dropdowns = document.getElementsByClassName('dropdown-content');
        for (var i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    };
  