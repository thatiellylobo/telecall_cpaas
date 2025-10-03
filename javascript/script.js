//----------------  DARK THEME  ----------------// 
const changeThemeBtn = document.querySelector("#change-theme");

function toggleDarkMode() {
  document.body.classList.toggle("dark");
}

// carrega light ou dark mode

function loadTheme() {
  const darkMode = localStorage.getItem("dark");

  if (darkMode) {
    toggleDarkMode();
  }
}

//chamando a função

loadTheme();

//--------

changeThemeBtn.addEventListener("change", function() {
  toggleDarkMode();

  // salva ou remove darkmode

  localStorage.removeItem("dark");

  if (document.body.classList.contains("dark")) {
    localStorage.setItem("dark", 1);
  }
});
//----------------  DARK THEME  ----------------//  

// mobile menu //

function clickMenu() {
  var itens = document.getElementById("itens");

  if (itens.style.display === 'block') {
    itens.style.display = 'none';
  } else {
    itens.style.display = 'block';
    itens.classList.toggle("active");
  }
}

// botão back to top //
function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// evento de rolagem
window.addEventListener('scroll', function() {
  var button = document.getElementById('scroll-to-top');

  // verifica se a posição de rolagem é maior que 300 pixels
  if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
    button.classList.add('active');
  } else {
    button.classList.remove('active');
  }
});
// botão back to top //


// Verifica o valor do acesso no localStorage
var acesso = localStorage.getItem('acesso');

// Seleciona os elementos do link no menu com os dados do usuário
var linksUsuario = document.querySelectorAll('.dropdown-content a');

// Verifica o valor do acesso e altera os links correspondentes
if (acesso == 0) {
  linksUsuario[0].href = 'modeloBD.html';
  linksUsuario[0].textContent = 'Modelo BD';
  linksUsuario[1].href = 'cons_usuario.php';
  linksUsuario[1].textContent = 'Consulta de usuário';
  linksUsuario[2].href = 'telalog.php';
  linksUsuario[2].textContent = 'Tela de Log';
} else if (acesso == 1) {
  linksUsuario[0].href = 'redefsenha.php';
  linksUsuario[0].textContent = 'Redefinir senha';
  linksUsuario[1].href = 'modeloBD.html';
  linksUsuario[1].textContent = 'Modelo BD';
}

document.getElementById("conceitual").addEventListener("click", function() {
  this.classList.toggle("ampliada");
});