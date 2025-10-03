function validarLogin(event) {
  event.preventDefault(); // Impede a submissão do formulário

  const usuario = document.getElementById('login').value;
  const senha = document.getElementById('senha').value;
  const mensagemErro = document.getElementById('mensagemErro');
  const mensagemSucesso = document.getElementById('mensagemSucesso');

  // Limpar mensagens anteriores
  mensagemErro.innerText = '';
  mensagemErro.classList.remove('error-message');
  mensagemSucesso.innerText = '';
  mensagemSucesso.classList.remove('success-message');

  // Verificação de campos vazios
  if (usuario === '' || senha === '') {
      mensagemErro.innerText = 'Preencha todos os campos.';
      mensagemErro.classList.add('error-message');
      return;
  }

  // Verificação de comprimento da senha e usuário
  if (usuario.length !== 6) {
      mensagemErro.innerText = 'O nome de usuário deve ter 6 caracteres.';
      mensagemErro.classList.add('error-message');
      return;
  }

  if (senha.length !== 8) {
      mensagemErro.innerText = 'A senha deve ter 8 caracteres.';
      mensagemErro.classList.add('error-message');
      return;
  }

  // Enviar o formulário via AJAX
  $.ajax({
      url: 'login.php',
      type: 'POST',
      data: $('#loginForm').serialize(),
      dataType: 'json',
      success: function(data) {
          if (data.status === 'error') {
              mensagemErro.innerText = data.message;
              mensagemErro.classList.add('error-message');
          } else if (data.status === 'success') {
              // Salvar token e acesso no localStorage
              localStorage.setItem('token', data.token);
              localStorage.setItem('acesso', data.acesso);

              // Exibir mensagem de sucesso e redirecionar
              mensagemSucesso.innerText = 'Login realizado com sucesso!';
              mensagemSucesso.classList.add('success-message');
              setTimeout(() => {
                  window.location.href = data.redirect;
              }, 1000);
          }
      },
      error: function() {
          mensagemErro.innerText = 'Ocorreu um erro. Por favor, tente novamente.';
          mensagemErro.classList.add('error-message');
      }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('loginForm').addEventListener('submit', validarLogin);

  const clearError = () => {
      const mensagemErro = document.getElementById('mensagemErro');
      mensagemErro.innerText = '';
      mensagemErro.classList.remove('error-message');
  };

  document.getElementById('login').addEventListener('input', clearError);
  document.getElementById('senha').addEventListener('input', clearError);
});

// Mostrar/Ocultar Senha
$(document).ready(function() {
  $('.bi-eye-fill').on('click', function() {
      let inputSenha = $('#senha');
      if (inputSenha.attr('type') === 'password') {
          inputSenha.attr('type', 'text');
      } else {
          inputSenha.attr('type', 'password');
      }
  });
});
