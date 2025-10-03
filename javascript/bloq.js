if (localStorage.getItem('token') == null) {
  const toast = document.createElement('div');
  toast.className = 'toast';
  toast.textContent = 'Você precisa estar logado para acessar essa página.';
  document.body.appendChild(toast);

  const overlay = document.createElement('div');
  overlay.className = 'overlay';
  document.body.appendChild(overlay);

  setTimeout(() => {
    
    window.location.href = "login.html";
  }, 1000);
}

function sair(){
  localStorage.removeItem('token');
  localStorage.removeItem('acesso');
  window.location.href = "index.html";
}
